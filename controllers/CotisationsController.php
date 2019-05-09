<?php

  function cotisation_list($membershipOnly)
  {
	$webuser = loadWebUser();
	if($webuser->is_anonymous){
		redirect_to('/login'); return;
	}

    $conn = $GLOBALS['db_connexion'];

    $sql =  'SELECT id, label, type, start_date, end_date, cotisation.amount AS amount, COUNT(cotisation_id) AS cotisation_count, SUM(cotisation_member.amount) AS cotisation_totalamount
        FROM cotisation LEFT JOIN cotisation_member ON cotisation.id=cotisation_id ';
	if($membershipOnly){
		$sql .= 'WHERE cotisation.type = 1 ';
	}
	$sql .= 'GROUP BY cotisation.id ORDER BY start_date DESC';
    $stmt = $conn->prepare($sql);
    $res = $stmt->execute();
    if ($res) {
        $results = $stmt->fetchAll();
        set('cotisationlist', $results);

        set('page_title', "Cotisations");
        set('page_submenus', getSubMenus("cotisations"));
        return html('cotisation.list.html.php');
    }

    set('page_title', "Bad request");
    return html('error.html.php');
  }

dispatch('/cotisations', 'cotisation_list_all');
  function cotisation_list_all()
  {
	return cotisation_list(false);
  }

dispatch('/cotisations/membership', 'cotisation_list_membership');
  function cotisation_list_membership()
  {
	return cotisation_list(true);
  }

  function cotisation_register($person_id)
  {
	$webuser = loadWebUser();
	if($webuser->is_anonymous){
		redirect_to('/login'); return;
	}

    $conn = $GLOBALS['db_connexion'];

    // Load cotisation list
    $sql =  'SELECT cotisation.id AS id, label, amount
        FROM cotisation, fiscal_year 
        WHERE fiscal_year.id=fiscal_year_id
	    AND fiscal_year_id = (SELECT fiscal_year_id FROM cotisation ORDER BY fiscal_year_id DESC LIMIT 1)
        ORDER BY type, id';
    $stmt = $conn->prepare($sql);
    $res = $stmt->execute();
    if ($res) {
	    $cotisations = $stmt->fetchAll();
    }

    // Load person
    if($res){
	    if($person_id != null){
	      $sql =  'SELECT id, firstname, lastname, birthdate, email, phonenumber, image_rights, comments
			    FROM person
			    WHERE id = '.$person_id;
	      $stmt = $conn->prepare($sql);
	      $res = $stmt->execute();
	      if ($res) {
            $person = $stmt->fetch();
          }
	    }else{
		    $person = array('firstname' => '', 'lastname' => '', 'birthdate' => '', 'email' => '', 'phonenumber' => '', 'image_rights' => '', 'comments' => '');
	    }
    }

    if($res){
	    set('person', $person);
	    set('cotisations', $cotisations);

	    set('page_title', TS::Cotisation_CotisationRegister);
	    set('page_submenus', getSubMenus("cotisations"));
	    return html('cotisation.register.html.php');
    }

    set('page_title', "Bad request");
    return html('error.html.php');
  }

dispatch('/cotisations/register', 'cotisation_register_new');
  function cotisation_register_new()
  {
	return cotisation_register(null);
  }

dispatch('/cotisations/register/member/:id', 'cotisation_register_member');
  function cotisation_register_member()
  {
    $id = params('id');
	return cotisation_register($id);
  }

dispatch_post('/cotisations/register', 'cotisation_register_save');
  function cotisation_register_save()
  {
	$webuser = loadWebUser();
	if($webuser->is_anonymous){
		redirect_to('/login'); return;
	}

    $res = true;

    $conn = $GLOBALS['db_connexion'];

    // Load cotisation list
    if($res){
        $sql =  'SELECT cotisation.id AS id, label, amount
            FROM cotisation, fiscal_year 
            WHERE fiscal_year.id=fiscal_year_id
	        AND fiscal_year_id = (SELECT fiscal_year_id FROM cotisation ORDER BY fiscal_year_id DESC LIMIT 1)
            ORDER BY type, id';
        $stmt = $conn->prepare($sql);
        $res = $stmt->execute();
        if ($res) {
	        $cotisations = $stmt->fetchAll();
        }
    }

    // Save data
    if($res){
        $person = person_load();
        $errors = array();    

        $conn->beginTransaction();
        $res = person_save($conn, $person['id'], $person, $errors);
        if($res){
            $conn->commit();
        }else{
            $conn->rollBack();
        }
    }

    if($res){
		redirect_to('/members/'.$id);
    }else{
	    set('person', $person);
	    set('cotisations', $cotisations);

	    set('page_title', TS::Cotisation_CotisationRegister);
	    set('page_submenus', getSubMenus("cotisations"));
        set('errors', $errors);
	    return html('cotisation.register.html.php');
    }
  }

dispatch('/cotisations/:id/members', 'cotisation_members_list');
  function cotisation_members_list()
  {
	$webuser = loadWebUser();
	if($webuser->is_anonymous){
		redirect_to('/login'); return;
	}
    
    $id = params('id');

    $conn = $GLOBALS['db_connexion'];

    $sql =  'SELECT id, firstname, lastname, birthdate, email, phonenumber, image_rights, creation_date, amount, payment_method, cotisation_count
        FROM person, cotisation_member 
        LEFT JOIN 
          (SELECT person_id, COUNT(cotisation_id) AS cotisation_count FROM cotisation_member, cotisation
           WHERE cotisation.id = cotisation_id AND cotisation.fiscal_year_id < (SELECT fiscal_year_id FROM cotisation WHERE id='.$id.')
           GROUP BY person_id
          ) AS CotisationCount ON CotisationCount.person_id=person.id
        WHERE person.id=cotisation_member.person_id AND cotisation_id='.$id.'
        GROUP BY person.id
        ORDER BY lastname, firstname';
    $stmt = $conn->prepare($sql);
    $res = $stmt->execute();
    if ($res) {
        $results = $stmt->fetchAll();
        set('personlist', $results);

        set('page_title', "Members");
        return html('cotisation.person.list.html.php');
    }

    set('page_title', "Bad request");
    return html('error.html.php');
  }


?>
