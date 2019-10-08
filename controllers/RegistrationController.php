<?php
/*
  function registrations_member_load()
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

  function registrations_member_save($conn, $person_id, $cotisations_member, &$errors)
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

*/
dispatch('/registrations', 'registration_list');
  function registration_list()
  {
	$webuser = loadWebUser();
	if($webuser->is_anonymous){
		redirect_to('/login'); return;
	}

    $conn = $GLOBALS['db_connexion'];

    $res = true;
    $listRegistrations = null;

    // Load registration list
    if($res){
        $sql =  'SELECT id, firstname, lastname, birthdate, address, zipcode, city, email, phonenumber, image_rights, registration_date, registration_type
            FROM registration ORDER BY registration_date DESC';
        $stmt = $conn->prepare($sql);
        $res = $stmt->execute();
        if($res){
          $listRegistrations = $stmt->fetchAll();
        }
    }

    // Render
    if ($res) {
        set('listRegistrations', $listRegistrations);

        set('page_title', "Registrations");
        set('page_submenus', getSubMenus("registrations"));
        return html('registration.list.html.php');
    }

    set('page_title', "Bad request");
    return html('error.html.php');
  }

dispatch('/registrations/:id', 'registration_view');
  function registration_view()
  {
	$webuser = loadWebUser();
	if($webuser->is_anonymous){
		redirect_to('/login'); return;
	}

    $id = params('id');
    $conn = $GLOBALS['db_connexion'];

    $res = true;
    $registration = null;

    // Load registration
    if($res){
        $sql =  'SELECT id, firstname, lastname, gender, birthdate, address, zipcode, city, email, phonenumber, image_rights, registration_date, registration_type FROM registration WHERE id='.$id;
        $stmt = $conn->prepare($sql);
        $res = $stmt->execute();
        if ($res) {
	        $registration = $stmt->fetch();
        }
    }

    if($res){
        $sql =  'SELECT id, label, cotisation.amount AS cotisation_amount, start_date, end_date, date, registration_cotisation.amount as amount, payment_method FROM cotisation, registration_cotisation WHERE cotisation.id=cotisation_id AND registration_id='.$id;
        $stmt = $conn->prepare($sql);
        $res = $stmt->execute();
        if ($res) {
	        $listCotisations = $stmt->fetchAll();
        }
    }

    if($res){
        set('registration', $registration);
        set('listCotisations', $listCotisations);

        set('page_title', sprintf(TS::Registration_Num, $id));
        set('page_submenus', getSubMenus("registrations"));
        return html('registration.html.php');
    }else{
        set('page_title', "Bad request");
        return html('error.html.php');
    }
  }


dispatch('/registrations/add', 'registration_add_new_nember');
  function registration_add_new_nember()
  {
	return registration_add(null);
  }

dispatch('/registrations/add/member/:id', 'registration_add_old_member');
  function registration_add_old_member()
  {
    $id = params('id');
	return registration_add($id);
  }

dispatch('/registrations/add', 'registration_add');
  function registration_add($person_id)
  {
	$webuser = loadWebUser();
	if($webuser->is_anonymous){
		redirect_to('/login'); return;
	}

    $conn = $GLOBALS['db_connexion'];

    $res = true;
    $listRegistrations = null;

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
	        $listCotisations = $stmt->fetchAll();
        }
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
	    set('listCotisations', $listCotisations);

	    set('page_title', TS::Cotisation_CotisationRegister);
	    set('page_submenus', getSubMenus("registrations"));
	    return html('registration.add.html.php');
    }

    set('page_title', "Bad request");
    return html('error.html.php');
  }

dispatch_post('/registrations/register', 'registration_save_new');
  function registration_save()
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
	        $listCotisations = $stmt->fetchAll();
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


?>
