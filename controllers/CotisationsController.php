<?php

  function cotisations_member_load()
  {
    $cotisations_member = array();
    
    $cotisations_member["payment_method"] = $_POST['CotisationMember_PaymentMethod'];
    $cotisations_member["date"] = $_POST['CotisationMember_Date'];
    $cotisations_member["cotisations"] = array();

    $count = $_POST['CotisationCount'];
    for($i = 0; $i < $count; $i++){
        $key = "CotisationMember_${i}_CotisationId";
        $cotisation_id = $_POST[$key];
        $key = "CotisationMember_${i}_Enabled";
        $cotisation_enabled = isset($_POST[$key]);
        $key = "CotisationMember_${i}_Amount";
        $cotisation_amount = $_POST[$key];
        $cotisation = array("id" => $cotisation_id, "enabled" => $cotisation_enabled, "amount" => $cotisation_amount);
        $cotisations_member["cotisations"][$i] = $cotisation;
    }
    
    return $cotisations_member;
  }

  function cotisations_db_load_list($conn, $fiscal_year_id, &$cotisations, &$errors)
  {
	$res = true;

    $sql = "SELECT id, label, type, amount, start_date, end_date, fiscal_year_id
        FROM cotisation ";
    if($fiscal_year_id != null){
        $sql .= "WHERE fiscal_year_id=".$fiscal_year_id ; 
    }

    $stmt = $conn->prepare($sql);
    if($stmt){
        $res = $stmt->execute();
        if ($res) {
            $cotisations = $stmt->fetchAll();
        }else{
            $errors[] = TSHelper::pdoErrorText($stmt->errorInfo());
        }
    }else{
		$res = false;
	    $errors[] = TSHelper::pdoErrorText($conn->errorInfo());
    }
    return $res;
  }

  function cotisations_member_save($conn, $person_id, $cotisations_member, &$errors)
  {
    $res = true;

    // Check data
    if($cotisations_member['payment_method'] == ""){
        $errors[] = "Payment method cannot be empty";
        $res = false;
    }

	$stmt = null;
    if($res){
        $sql = 'INSERT INTO cotisation_member (person_id, cotisation_id, date, amount, payment_method) VALUES (:person_id, :cotisation_id, :date, :amount, :payment_method)';
	    $stmt = $conn->prepare($sql);
	    if(!$stmt){
            $res = false;
		    $errors[] = TSHelper::pdoErrorText($conn->errorInfo());
	    }
    }

	if($res){
		//print_r($cotisations_member);

		$stmt->bindParam(':person_id', $person_id, PDO::PARAM_INT);
		$stmt->bindParam(':date', $cotisations_member["date"], PDO::PARAM_STR);
		$stmt->bindParam(':payment_method', $cotisations_member['payment_method'], PDO::PARAM_INT);
		foreach($cotisations_member["cotisations"] as $cotisation_member)
        {
			if($cotisation_member['enabled']){
				$cotisation_id = $cotisation_member['id'];
				$cotisation_amount = $cotisation_member['amount'];

				$stmt->bindParam(':cotisation_id', $cotisation_id, PDO::PARAM_INT);
				$stmt->bindParam(':amount', $cotisation_amount, PDO::PARAM_INT);
				$res = $stmt->execute();
				if(!$res){
					$errors[] = TSHelper::pdoErrorText($stmt->errorInfo());
					break;
				}
			}
		}
    }
    return $res;
  }

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
	      $sql = 'SELECT id, firstname, lastname, birthdate, address, zipcode, city, email, phonenumber, image_rights, comments
			    FROM person
			    WHERE id = '.$person_id;
	      $stmt = $conn->prepare($sql);
	      $res = $stmt->execute();
	      if ($res) {
            $person = $stmt->fetch();
          }
	    }else{
		    $person = person_create();
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
    $errors = array();

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
        $cotisations_member = cotisations_member_load();

        $conn->beginTransaction();
		$person_id = (isset($person['id']) && $person['id'] != "" ? $person['id'] : null);
        $res = person_save($conn, $person_id, $person, $errors);
        if($res){
            // $person['id'] will be set in person_save
        	$res = cotisations_member_save($conn, $person['id'], $cotisations_member, $errors);
        }
        if($res){
            $conn->commit();
        }else{
            $conn->rollBack();
        }
    }

    if($res){
		redirect_to('/members/'.$person['id']);
    }else{
	    set('person', $person);
	    set('cotisations', $cotisations);
        set('cotisations_member', $cotisations_member);

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
