<?php

  function registration_create()
  {
    $registration = array(
        'id' => '',
        'person_id' => '',
        'firstname' => '',
        'lastname' => '',
        'gender' => 0,
        'birthdate' => null,
        'address' => null,
        'zipcode' => null,
        'city' => null,
        'email' => null,
        'phonenumber' => null,
        'image_rights' => null,
        'registration_date' => date("Y-m-d"),
        'registration_type' => null,
        'fiscal_year_id' => null,
        'listCotisation' => array(),
    );
    return $registration;
  }

  function registration_load()
  {
    $valueGender = 0;
    $valueImagerights = ($_POST['Imagerights'] != "" ? $_POST['Imagerights'] : null);
    $registration = array(
        // Registration infos
        'id' => $_POST['RegistrationId'],
        'registration_date' => $_POST['RegistrationDate'],
        'registration_type' => $_POST['RegistrationType'],
        'fiscal_year_id' => $_POST['RegistrationFiscalYearId'],
        // Member infos
        'person_id' => $_POST['PersonId'],
        'firstname' => $_POST['Firstname'],
        'lastname' => $_POST['Lastname'],
        'gender' => $valueGender,
        'birthdate' => $_POST['Birthdate'],
        'address' => $_POST['Address'],
        'zipcode' => $_POST['Zipcode'],
        'city' => $_POST['City'],
        'email' => $_POST['Email'],
        'phonenumber' => $_POST['Phonenumber'],
        'image_rights' => $valueImagerights
    );

    return $registration;
  }

  function registration_person($registration)
  {
    $person = person_create();
    $person['firstname'] = $registration['firstname'];
    $person['lastname'] = $registration['lastname'];
    $person['gender'] = $registration['gender'];
    $person['birthdate'] = $registration['birthdate'];
    $person['address'] = $registration['address'];
    $person['zipcode'] = $registration['zipcode'];
    $person['city'] = $registration['city'];
    $person['email'] = $registration['email'];
    $person['phonenumber'] = $registration['phonenumber'];
    $person['image_rights'] = $registration['image_rights'];
    return $person;
  }

  function registrations_is_new($registration)
  {
    return (!isset($registration['id'])) || ($registration['id'] == 0);
  }

  function registrations_get_cotisation_from_id($registration, $cotisation_id)
  {
    if(isset($registration['cotisations'])){
      foreach($registration['cotisations'] as $registration_cotisation)
      {
         if($registration_cotisation['cotisation_id'] == $cotisation_id){
            return $registration_cotisation;
         }
      }
    }
    return null;
  }

  function registrations_db_load_from_id($conn, $registration_id, &$registration, &$errors)
  {
    $res = true;

    $sql =  'SELECT id, person_id, firstname, lastname, gender, birthdate, address, zipcode, city, email, phonenumber, image_rights, registration_date, registration_type, fiscal_year_id FROM registration WHERE id='.$registration_id;
    $stmt = $conn->prepare($sql);
    if($stmt){
        $res = $stmt->execute();
        if ($res) {
            $registration = $stmt->fetch();
        }else{
            $errors[] = TSHelper::pdoErrorText($stmt->errorInfo());
        }
    }else{
		$res = false;
	    $errors[] = TSHelper::pdoErrorText($conn->errorInfo());
    }

    return $res;
  }


  function registrations_db_load_registration_cotisations_list_from_id($conn, $registration_id, &$registration, &$errors)
  {
    $res = true;

    $sql =  'SELECT registration_id, cotisation_id, date, amount, payment_method FROM registration_cotisation WHERE registration_id='.$registration_id;
    $stmt = $conn->prepare($sql);
    if($stmt){
        $res = $stmt->execute();
        if ($res) {
            $registration['cotisations'] = $stmt->fetchAll();
        }else{
            $errors[] = TSHelper::pdoErrorText($stmt->errorInfo());
        }
    }else{
		$res = false;
	    $errors[] = TSHelper::pdoErrorText($conn->errorInfo());
    }

    return $res;
  }

  function registration_save($conn, &$registration, &$errors)
  {
    $res = true;

    if(isset($registration['id']) && $registration['id'] != 0){
      $id = $registration['id'];
    }else{
      $id = 0;
    }

    if(isset($registration['person_id']) && $registration['person_id'] != 0){
      $person_id = $registration['person_id'];
    }else{
      $person_id = 0;
    }

    // Check data
    if($registration['firstname'] == ""){
        $errors[] = "Firstname cannot be empty";
        $res = false;
    }
    if($registration['lastname'] == ""){
        $errors[] = "Lastname cannot be empty";
        $res = false;
    }
    if($registration['registration_date'] == ""){
        $errors[] = "Registration date cannot be empty";
        $res = false;
    }
    if($registration['registration_type'] == ""){
        $errors[] = "Registration type cannot be empty";
        $res = false;
    }

    // Save the person
	$stmt = null;
    if($res){

        $person = registration_person($registration);

        if($registration['person_id']==0){
        	$sql =  'INSERT INTO person (firstname, lastname, gender, birthdate, address, zipcode, city, email, phonenumber, image_rights, creation_date, is_member) VALUES (:firstname, :lastname, :gender, :birthdate, :address, :zipcode, :city, :email, :phonenumber, :image_rights, date(\'now\'), 1)';
	    }else{
        	$sql =  'UPDATE person SET firstname=:firstname, lastname=:lastname, gender=:gender, birthdate=:birthdate, address=:address, zipcode=:zipcode, city=:city, email=:email, phonenumber=:phonenumber, image_rights=:image_rights WHERE id=:id';
	    }
	    $stmt = $conn->prepare($sql);
	    if($stmt){
	        $stmt->bindParam(':firstname', $person['firstname'], PDO::PARAM_STR, 50);
	        $stmt->bindParam(':lastname', $person['lastname'], PDO::PARAM_STR, 50);
	        $stmt->bindParam(':gender', $person['gender'], PDO::PARAM_INT);
	        $stmt->bindParam(':birthdate', $person['birthdate'], PDO::PARAM_STR, 10);
	        $stmt->bindParam(':address', $person['address'], PDO::PARAM_STR, 100);
	        $stmt->bindParam(':zipcode', $person['zipcode'], PDO::PARAM_INT, 10);
	        $stmt->bindParam(':city', $person['city'], PDO::PARAM_STR, 50);
	        $stmt->bindParam(':email', $person['email'], PDO::PARAM_STR, 100);
	        $stmt->bindParam(':phonenumber', $person['phonenumber'], PDO::PARAM_STR, 50);
	        $stmt->bindParam(':image_rights', $person['image_rights'], PDO::PARAM_STR);
	        $res = $stmt->execute();
            if($res){
                if($person_id==0){
                    $person_id = $conn->lastInsertId();
		            $person["person_id"] = $person_id;
                }
            }else{
	            $errors[] = TSHelper::pdoErrorText($stmt->errorInfo());
            }
        }else{
			$res = false;
		    $errors[] = TSHelper::pdoErrorText($conn->errorInfo());
	    }

	}

    // Save the registration
	$stmt = null;
    if($res){
        // Prepare the query
        if($id==0){
        	$sql =  'INSERT INTO registration (person_id, firstname, lastname, gender, birthdate, address, zipcode, city, email, phonenumber, image_rights, registration_date, registration_type, fiscal_year_id) VALUES (:person_id, :firstname, :lastname, :gender, :birthdate, :address, :zipcode, :city, :email, :phonenumber, :image_rights, :registration_date, :registration_type, :fiscal_year_id)';
	    }else{
        	$sql =  'UPDATE registration SET person_id=:person_id, firstname=:firstname, lastname=:lastname, gender=:gender, birthdate=:birthdate, address=:address, zipcode=:zipcode, city=:city, email=:email, phonenumber=:phonenumber, image_rights=:image_rights, registration_date=:registration_date, registration_type=:registration_type, fiscal_year_id=:fiscal_year_id WHERE id=:id';
	    }

	    $stmt = $conn->prepare($sql);
	    if($stmt){
	        $stmt->bindParam(':person_id', $registration['person_id'], PDO::PARAM_INT);
	        $stmt->bindParam(':firstname', $registration['firstname'], PDO::PARAM_STR, 50);
	        $stmt->bindParam(':lastname', $registration['lastname'], PDO::PARAM_STR, 50);
	        $stmt->bindParam(':gender', $registration['gender'], PDO::PARAM_INT);
	        $stmt->bindParam(':birthdate', $registration['birthdate'], PDO::PARAM_STR, 10);
	        $stmt->bindParam(':address', $registration['address'], PDO::PARAM_STR, 100);
	        $stmt->bindParam(':zipcode', $registration['zipcode'], PDO::PARAM_INT, 10);
	        $stmt->bindParam(':city', $registration['city'], PDO::PARAM_STR, 50);
	        $stmt->bindParam(':email', $registration['email'], PDO::PARAM_STR, 100);
	        $stmt->bindParam(':phonenumber', $registration['phonenumber'], PDO::PARAM_STR, 50);
	        $stmt->bindParam(':image_rights', $registration['image_rights'], PDO::PARAM_STR);
	        $stmt->bindParam(':registration_date', $registration['registration_date'], PDO::PARAM_STR, 10);
	        $stmt->bindParam(':registration_type', $registration['registration_type'], PDO::PARAM_INT);
	        $stmt->bindParam(':fiscal_year_id', $registration['fiscal_year_id'], PDO::PARAM_INT);
	        $res = $stmt->execute();
            if($res){
                if($id==0){
		            $registration["id"] = $conn->lastInsertId();
                }
            }else{
	            $errors[] = TSHelper::pdoErrorText($stmt->errorInfo());
            }

        }else{
			$res = false;
		    $errors[] = TSHelper::pdoErrorText($conn->errorInfo());
	    }

	}

    return $res;
  }

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

        set('page_title', TS::Registration_Registrations);
        set('page_submenus', getSubMenus("registrations"));
        return html('registration.list.html.php');
    }

    set('page_title', "Bad request");
    return html('error.html.php');
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

	$registration = registration_create();

    $res = true;

    // Load current fiscal year
    $fiscalyear = null;
    if($res){
       $res = fiscalyears_db_load_current($conn, $fiscalyear, $errors);
       if($res){
         $registration['fiscal_year_id'] = $fiscalyear['id'];
       }
    }

    // Load current
    $cotisations = array();
    if($res){
       $res = cotisations_db_load_list($conn, $fiscalyear['id'], $cotisations, $errors);
    }

    // Load person
    if($res){
	    if($person_id != null){
	      $sql = 'SELECT id, firstname, lastname, birthdate, address, zipcode, city, email, phonenumber, image_rights
			    FROM person
			    WHERE id = '.$person_id;
	      $stmt = $conn->prepare($sql);
	      $res = $stmt->execute();
	      if ($res) {
            $person = $stmt->fetch();
            $registration['person_id'] = $person_id;
            $registration['firstname'] = $person['firstname'];
            $registration['lastname'] = $person['lastname'];
            $registration['birthdate'] = $person['birthdate'];
            $registration['address'] = $person['address'];
            $registration['zipcode'] = $person['zipcode'];
            $registration['city'] = $person['city'];
            $registration['email'] = $person['email'];
            $registration['phonenumber'] = $person['phonenumber'];
            $registration['image_rights'] = $person['image_rights'];
          }
	    }else{
          
	    }
    }
/*
    // Load cotisation list
    if($res){
        $sql =  'SELECT cotisation.id AS id, label, amount
            FROM cotisation, fiscal_year 
            WHERE fiscal_year.id=fiscal_year_id
	        AND fiscal_year.is_current = \'true\'
            ORDER BY type, id';
        $stmt = $conn->prepare($sql);
        if($stmt){
          $res = $stmt->execute();
          if ($res) {
	        $cotisations = $stmt->fetchAll();
          }
        }else{
          $res = false;
        }
    }
*/

    if($res){
	    set('registration', $registration);
	    set('cotisations', $cotisations);

	    set('page_title', TS::Cotisation_CotisationRegister);
	    set('page_submenus', getSubMenus("registrations"));
	    return html('registration.add.html.php');
    }

    set('page_title', "Bad request");
	set('errors', $errors);
    return html('error.html.php');
  }

dispatch('/registrations/:id/edit', 'registration_edit');
  function registration_edit()
  {
	$webuser = loadWebUser();
	if($webuser->is_anonymous){
		redirect_to('/login'); return;
	}

    $id = params('id');
    $conn = $GLOBALS['db_connexion'];

    $res = true;

    // Load registration
    $registration = null;
    if($res){
       $res = registrations_db_load_from_id($conn, $id, $registration, $errors);
    }

    // Load registration contisations
    if($res){
       $res = registrations_db_load_registration_cotisations_list_from_id($conn, $id, $registration, $errors);
    }

    // Load current fiscal year
    $fiscalyear = null;
    if($res){
       $res = fiscalyears_db_load_from_id($conn, $registration['fiscal_year_id'], $fiscalyear, $errors);
       if($res){
         $registration['fiscal_year_id'] = $fiscalyear['id'];
       }
    }

    // Load current
    $cotisations = array();
    if($res){
       $res = cotisations_db_load_list($conn, $fiscalyear['id'], $cotisations, $errors);
    }

    if($res){
        set('registration', $registration);
        set('cotisations', $cotisations);

        set('page_title', sprintf(TS::Registration_Num, $id));
        set('page_submenus', getSubMenus("registrations"));
        return html('registration.edit.html.php');
    }else{
        set('page_title', "Bad request");
        return html('error.html.php');
    }
  }

dispatch_post('/registrations/:id/edit', 'registration_edit_post');
  function registration_edit_post()
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
        $registration = registration_load();
        $cotisations_member = cotisations_member_load();

        $conn->beginTransaction();
        $res = registration_save($conn, $registration, $errors);
        if($res){
            $conn->commit();
        }else{
            $conn->rollBack();
        }
    }

    if($res){
		redirect_to('/registrations/'.$registration['id'].'/edit');
    }else{
	    set('registration', $registration);
	    set('cotisations', $cotisations);
        set('cotisations_member', $cotisations_member);

	    set('page_title', TS::Cotisation_CotisationRegister);
	    set('page_submenus', getSubMenus("cotisations"));
        set('errors', $errors);
	    return html('registration.edit.html.php');
    }
  }


?>
