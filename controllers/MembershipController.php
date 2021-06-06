<?php

  function membership_create()
  {
    $membership = array(
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
        'phonenumber2' => null,
        'image_rights' => null,
        'membership_date' => date("Y-m-d"),
        'membership_type' => null,
        'comments' => null,
        'fiscal_year_id' => null,
        'listCotisation' => array(),
    );
    return $membership;
  }

  function membership_load()
  {
    $membership = array();
    // Membership infos
    $membership['id'] = $_POST['MembershipId'];
    $membership['membership_date'] = $_POST['MembershipDate'];
    $membership['membership_type'] = $_POST['MembershipType'];
    $membership['comments'] = ($_POST['Comments'] != "" ? $_POST['Comments'] : null);
    $membership['fiscal_year_id'] = $_POST['MembershipFiscalYearId'];
    // Member infos
    $membership['person_id'] = $_POST['PersonId'];
    $membership['firstname'] = $_POST['Firstname'];
    $membership['lastname'] = $_POST['Lastname'];
    $membership['gender'] = 0;
    $membership['birthdate'] = ($_POST['Birthdate'] != "" ? $_POST['Birthdate'] : null);
    $membership['address'] = ($_POST['Address'] != "" ? $_POST['Address'] : null);
    $membership['zipcode'] =  ($_POST['Zipcode'] != "" ? $_POST['Zipcode'] : null);
    $membership['city'] = ($_POST['City'] != "" ? $_POST['City'] : null);
    $membership['email'] = $_POST['Email'];
    $membership['phonenumber'] = ($_POST['Phonenumber'] != "" ? $_POST['Phonenumber'] : null);
    $membership['phonenumber2'] = ($_POST['Phonenumber2'] != "" ? $_POST['Phonenumber2'] : null);
    $membership['image_rights'] = ($_POST['Imagerights'] != "" ? $_POST['Imagerights'] : null);
    return $membership;
  }

  function membership_cotisations_load($membership_id)
  {
    $membership_cotisations = array();

    $count = $_POST['CotisationCount'];
    for($i = 0; $i<$count; $i++){
        $fieldBase = 'CotisationMember_'.$i.'_';
        $membership_cotisations[$i] = array(
           'enabled' => isset($_POST[$fieldBase.'Enabled']),
           'membership_id' => $membership_id,
           'cotisation_id' => $_POST[$fieldBase.'CotisationId'],
           'amount' => $_POST[$fieldBase.'Amount'],
           'payment_method' => $_POST[$fieldBase.'PaymentMethod'],
           'date' => $_POST[$fieldBase.'Date'],

        );
    }

    return $membership_cotisations;
  }

  function membership_person($membership)
  {
    $person = person_create();
    $person['firstname'] = $membership['firstname'];
    $person['lastname'] = $membership['lastname'];
    $person['gender'] = $membership['gender'];
    $person['birthdate'] = $membership['birthdate'];
    $person['address'] = $membership['address'];
    $person['zipcode'] = $membership['zipcode'];
    $person['city'] = $membership['city'];
    $person['email'] = $membership['email'];
    $person['phonenumber'] = $membership['phonenumber'];
    $person['phonenumber2'] = $membership['phonenumber2'];
    $person['image_rights'] = $membership['image_rights'];
    $person['comments'] = $membership['comments'];
    return $person;
  }

  function memberships_is_new($membership)
  {
    return (!isset($membership['id'])) || ($membership['id'] == 0);
  }

  function memberships_get_cotisation_from_id($membership, $cotisation_id)
  {
    if(isset($membership['cotisations'])){
      foreach($membership['cotisations'] as $membership_cotisation)
      {
         if($membership_cotisation['cotisation_id'] == $cotisation_id){
            return $membership_cotisation;
         }
      }
    }
    return null;
  }

  function memberships_db_load_from_id($conn, $membership_id, &$membership, &$errors)
  {
    $res = true;

    $sql =  'SELECT id, person_id, firstname, lastname, gender, birthdate, address, zipcode, city, email, phonenumber, phonenumber2, image_rights, membership_date, membership_type, comments, fiscal_year_id FROM membership WHERE id='.$membership_id;
    $stmt = $conn->prepare($sql);
    if($stmt){
        $res = $stmt->execute();
        if ($res) {
            $membership = $stmt->fetch();
        }else{
            $errors[] = TSHelper::pdoErrorText($stmt->errorInfo());
        }
    }else{
		$res = false;
	    $errors[] = TSHelper::pdoErrorText($conn->errorInfo());
    }

    return $res;
  }

  function memberships_db_load_list($conn, $sql, &$membership, &$errors)
  {
    $res = true;

    $stmt = $conn->prepare($sql);
    if($stmt){
        $res = $stmt->execute();
        if ($res) {
            $membership = $stmt->fetchAll();
        }else{
            $errors[] = TSHelper::pdoErrorText($stmt->errorInfo());
        }
    }else{
		$res = false;
	    $errors[] = TSHelper::pdoErrorText($conn->errorInfo());
    }

    return $res;
  }

  function memberships_db_load_list_from_person_id($conn, $person_id, &$memberships, &$errors)
  {
    $sql = "SELECT id, firstname, lastname, birthdate, address, zipcode, city, email, phonenumber, phonenumber2, image_rights, membership_date, membership_type, comments, person_id";
    $sql .= " FROM membership";
    $sql .= " WHERE person_id=".$person_id;
    $sql .= " ORDER BY membership_date DESC";
    return memberships_db_load_list($conn, $sql, $memberships, $errors);
  }

  function memberships_db_load_list_from_fiscal_year_id($conn, $fiscal_year_id, &$memberships, &$errors)
  {
    $sql = "SELECT id, firstname, lastname, birthdate, address, zipcode, city, email, phonenumber, phonenumber2, image_rights, membership_date, membership_type, comments, person_id";
    $sql .= " FROM membership";
    $sql .= " WHERE fiscal_year_id=".$fiscal_year_id;
    $sql .= " ORDER BY membership_date DESC";
    return memberships_db_load_list($conn, $sql, $memberships, $errors);
  }

  function memberships_db_load_membership_cotisations_list_from_id($conn, $membership_id, &$membership, &$errors)
  {
    $res = true;

    $sql =  'SELECT membership_id, cotisation_id, date, amount, payment_method FROM membership_cotisation WHERE membership_id='.$membership_id;
    $stmt = $conn->prepare($sql);
    if($stmt){
        $res = $stmt->execute();
        if ($res) {
            $membership['cotisations'] = $stmt->fetchAll();
        }else{
            $errors[] = TSHelper::pdoErrorText($stmt->errorInfo());
        }
    }else{
		$res = false;
	    $errors[] = TSHelper::pdoErrorText($conn->errorInfo());
    }

    return $res;
  }

  function membership_save($conn, $bSavePerson, &$membership, &$errors)
  {
    $res = true;

    if(isset($membership['id']) && $membership['id'] != 0){
      $id = $membership['id'];
    }else{
      $id = 0;
    }

    if(isset($membership['person_id']) && $membership['person_id'] != 0){
      $person_id = $membership['person_id'];
    }else{
      $person_id = 0;
    }

    // Check data
    if($membership['firstname'] == ""){
        $errors[] = "Firstname cannot be empty";
        $res = false;
    }
    if($membership['lastname'] == ""){
        $errors[] = "Lastname cannot be empty";
        $res = false;
    }
    if($membership['membership_date'] == ""){
        $errors[] = "Membership date cannot be empty";
        $res = false;
    }
    if($membership['membership_type'] == ""){
        $errors[] = "Membership type cannot be empty";
        $res = false;
    }

    // Save the person
	$stmt = null;
    if($res){
        $person = membership_person($membership);

        if($bSavePerson){
            if($person_id == 0){
            	$sql =  'INSERT INTO person (firstname, lastname, gender, birthdate, address, zipcode, city, email, phonenumber, phonenumber2, image_rights, creation_date, is_member) VALUES (:firstname, :lastname, :gender, :birthdate, :address, :zipcode, :city, :email, :phonenumber, :phonenumber2, :image_rights, date(\'now\'), 1)';
	        }else{
            	$sql =  'UPDATE person SET firstname=:firstname, lastname=:lastname, gender=:gender, birthdate=:birthdate, address=:address, zipcode=:zipcode, city=:city, email=:email, phonenumber=:phonenumber, phonenumber2=:phonenumber2, image_rights=:image_rights WHERE id=:id';
	        }
	        $stmt = $conn->prepare($sql);
	        if($stmt){
                if($person_id != 0){        
	              $stmt->bindParam(':id', $person_id, PDO::PARAM_INT);
                }
	            $stmt->bindParam(':firstname', $person['firstname'], PDO::PARAM_STR, 50);
	            $stmt->bindParam(':lastname', $person['lastname'], PDO::PARAM_STR, 50);
	            $stmt->bindParam(':gender', $person['gender'], PDO::PARAM_INT);
	            $stmt->bindParam(':birthdate', $person['birthdate'], PDO::PARAM_STR, 10);
	            $stmt->bindParam(':address', $person['address'], PDO::PARAM_STR, 100);
	            $stmt->bindParam(':zipcode', $person['zipcode'], PDO::PARAM_INT, 10);
	            $stmt->bindParam(':city', $person['city'], PDO::PARAM_STR, 50);
	            $stmt->bindParam(':email', $person['email'], PDO::PARAM_STR, 100);
	            $stmt->bindParam(':phonenumber', $person['phonenumber'], PDO::PARAM_STR, 50);
	            $stmt->bindParam(':phonenumber2', $person['phonenumber2'], PDO::PARAM_STR, 50);
	            $stmt->bindParam(':image_rights', $person['image_rights'], PDO::PARAM_STR);
	            $res = $stmt->execute();
                if($res){
                    if($person_id==0){
                        $person_id = $conn->lastInsertId();
		                $person["id"] = $person_id;
                    }
                    $membership['person_id'] = $person_id;
                }else{
	                $errors[] = TSHelper::pdoErrorText($stmt->errorInfo());
                }
            }else{
			    $res = false;
		        $errors[] = TSHelper::pdoErrorText($conn->errorInfo());
	        }
        }

	}

    // Save the membership
	$stmt = null;
    if($res){
        // Prepare the query
        if($id==0){
        	$sql =  'INSERT INTO membership (person_id, firstname, lastname, gender, birthdate, address, zipcode, city, email, phonenumber, phonenumber2, image_rights, membership_date, membership_type, comments, fiscal_year_id) VALUES (:person_id, :firstname, :lastname, :gender, :birthdate, :address, :zipcode, :city, :email, :phonenumber, :phonenumber2, :image_rights, :membership_date, :membership_type, :comments, :fiscal_year_id)';
	    }else{
        	$sql =  'UPDATE membership SET person_id=:person_id, firstname=:firstname, lastname=:lastname, gender=:gender, birthdate=:birthdate, address=:address, zipcode=:zipcode, city=:city, email=:email, phonenumber=:phonenumber, phonenumber2=:phonenumber2, image_rights=:image_rights, membership_date=:membership_date, membership_type=:membership_type, comments=:comments, fiscal_year_id=:fiscal_year_id WHERE id=:id';
	    }

	    $stmt = $conn->prepare($sql);
	    if($stmt){
            if($id != 0){        
	          $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            }
	        $stmt->bindParam(':person_id', $membership['person_id'], PDO::PARAM_INT);
	        $stmt->bindParam(':firstname', $membership['firstname'], PDO::PARAM_STR, 50);
	        $stmt->bindParam(':lastname', $membership['lastname'], PDO::PARAM_STR, 50);
	        $stmt->bindParam(':gender', $membership['gender'], PDO::PARAM_INT);
	        $stmt->bindParam(':birthdate', $membership['birthdate'], PDO::PARAM_STR, 10);
	        $stmt->bindParam(':address', $membership['address'], PDO::PARAM_STR, 100);
	        $stmt->bindParam(':zipcode', $membership['zipcode'], PDO::PARAM_INT, 10);
	        $stmt->bindParam(':city', $membership['city'], PDO::PARAM_STR, 50);
	        $stmt->bindParam(':email', $membership['email'], PDO::PARAM_STR, 100);
	        $stmt->bindParam(':phonenumber', $membership['phonenumber'], PDO::PARAM_STR, 50);
	        $stmt->bindParam(':phonenumber2', $membership['phonenumber2'], PDO::PARAM_STR, 50);
	        $stmt->bindParam(':image_rights', $membership['image_rights'], PDO::PARAM_STR);
	        $stmt->bindParam(':membership_date', $membership['membership_date'], PDO::PARAM_STR, 10);
	        $stmt->bindParam(':membership_type', $membership['membership_type'], PDO::PARAM_INT);
	        $stmt->bindParam(':comments', $membership['comments'], PDO::PARAM_STR);
	        $stmt->bindParam(':fiscal_year_id', $membership['fiscal_year_id'], PDO::PARAM_INT);
	        $res = $stmt->execute();
            if($res){
                if($id==0){
		            $membership["id"] = $conn->lastInsertId();
                }
            }else{
	            $errors[] = TSHelper::pdoErrorText($stmt->errorInfo());
            }

        }else{
			$res = false;
		    $errors[] = TSHelper::pdoErrorText($conn->errorInfo());
	    }

	}

    // Clear the membership cotisations
    if($res){
        $sql = 'DELETE FROM membership_cotisation WHERE membership_id=:membership_id';
	    $stmt = $conn->prepare($sql);
	    if($stmt){
		    $stmt->bindParam(':membership_id', $membership["id"], PDO::PARAM_INT);
	        $res = $stmt->execute();
            if(!$res){
	            $errors[] = TSHelper::pdoErrorText($stmt->errorInfo());
            }
        }else{
            $res = false;
		    $errors[] = TSHelper::pdoErrorText($conn->errorInfo());
	    }
    }

    // Save the membership cotisations
    if($res){
        $sql = 'INSERT INTO membership_cotisation (membership_id, cotisation_id, date, amount, payment_method) VALUES (:membership_id, :cotisation_id, :date, :amount, :payment_method)';
	    $stmt = $conn->prepare($sql);
	    if(!$stmt){
            $res = false;
		    $errors[] = TSHelper::pdoErrorText($conn->errorInfo());
	    }

	    if($res){
		    $stmt->bindParam(':membership_id', $membership["id"], PDO::PARAM_INT);
		    foreach($membership["cotisations"] as $membership_cotisation)
            {
			    if($membership_cotisation['enabled']){
                    $date = $membership_cotisation["date"];
                    $payment_method = $membership_cotisation["payment_method"];
                    $cotisation_id = $membership_cotisation["cotisation_id"];
                    $amount = $membership_cotisation["amount"];
		            $stmt->bindParam(':date', $date, PDO::PARAM_STR);
		            $stmt->bindParam(':payment_method', $payment_method, PDO::PARAM_INT);
				    $stmt->bindParam(':cotisation_id', $cotisation_id, PDO::PARAM_INT);
				    $stmt->bindParam(':amount', $amount, PDO::PARAM_INT);
				    $res = $stmt->execute();
				    if(!$res){
					    $errors[] = TSHelper::pdoErrorText($stmt->errorInfo());
					    break;
				    }
			    }
		    }
        }
    }

    return $res;
  }

dispatch('/memberships', 'membership_list');
  function membership_list()
  {
	$webuser = loadWebUser();
	if($webuser->is_anonymous){
		redirect_to('/login'); return;
	}

    $conn = $GLOBALS['db_connexion'];

    $res = true;
    $memberships = null;

    // Load membership list
    if($res){
        $sql = 'SELECT id, firstname, lastname, birthdate, address, zipcode, city, email, phonenumber, phonenumber2, image_rights, membership_date, membership_type, comments, SUM(amount) AS total_amount, MIN(payment_method) AS payment_method';
        $sql .= ' FROM membership';
        $sql .= ' LEFT JOIN  membership_cotisation ON membership.id = membership_cotisation.membership_id';
        $sql .= ' GROUP BY membership.id';
        $sql .= ' ORDER BY membership_date DESC';
        $stmt = $conn->prepare($sql);
        $res = $stmt->execute();
        if($res){
          $memberships = $stmt->fetchAll();
        }
    }

    // Render
    if ($res) {
        set('listMembership', $memberships);

        set('page_title', TS::Membership_Memberships);
        set('page_submenus', getSubMenus("memberships"));
        return html('membership.list.html.php');
    }

    set('page_title', "Bad request");
    return html('error.html.php');
  }


dispatch('/memberships/add', 'membership_add_new_nember');
  function membership_add_new_nember()
  {
	return membership_add(null);
  }

dispatch('/memberships/add/member/:id', 'membership_add_old_member');
  function membership_add_old_member()
  {
    $id = params('id');
	return membership_add($id);
  }

  function membership_add($person_id)
  {
	$webuser = loadWebUser();
	if($webuser->is_anonymous){
		redirect_to('/login'); return;
	}

    $res = true;

    $conn = $GLOBALS['db_connexion'];
    $errors = array();
    $dbController = new DatabaseController($conn, $errors);

	$membership = membership_create();

    // Load current fiscal year
    $fiscalyear = null;
    if($res){
       $res = fiscalyears_db_load_from_current($conn, $fiscalyear, $errors);
       if($res){
         $membership['fiscal_year_id'] = $fiscalyear['id'];
       }
    }

    // Load cotisation list
    $listCotisation = null;
    if($res){
        $res = $dbController->getCotisationListByFiscalYearId($fiscalyear['id'], $listCotisation);
    }

    // Load person
    if($res){
	    if($person_id != null){
	      $sql = 'SELECT id, firstname, lastname, birthdate, address, zipcode, city, email, phonenumber, phonenumber2, image_rights
			    FROM person
			    WHERE id = '.$person_id;
	      $stmt = $conn->prepare($sql);
	      $res = $stmt->execute();
	      if ($res) {
            $person = $stmt->fetch();
            $membership['person_id'] = $person_id;
            $membership['firstname'] = $person['firstname'];
            $membership['lastname'] = $person['lastname'];
            $membership['birthdate'] = $person['birthdate'];
            $membership['address'] = $person['address'];
            $membership['zipcode'] = $person['zipcode'];
            $membership['city'] = $person['city'];
            $membership['email'] = $person['email'];
            $membership['phonenumber'] = $person['phonenumber'];
            $membership['phonenumber2'] = $person['phonenumber2'];
            $membership['image_rights'] = $person['image_rights'];
          }
	    }else{
          
	    }
    }

    if($res){
	    set('membership', $membership);
	    set('cotisations', $listCotisation);

	    set('page_title', TS::Cotisation_CotisationRegister);
	    set('page_submenus', getSubMenus("memberships"));
	    return html('membership.add.html.php');
    }

    set('page_title', "Bad request");
	set('errors', $errors);
    return html('error.html.php');
  }

dispatch('/memberships/:id/edit', 'membership_edit');
  function membership_edit()
  {
	$webuser = loadWebUser();
	if($webuser->is_anonymous){
		redirect_to('/login'); return;
	}

    $res = true;

    $conn = $GLOBALS['db_connexion'];
    $errors = array();
    $dbController = new DatabaseController($conn, $errors);

    $id = params('id');

    // Load membership
    $membership = null;
    if($res){
       $res = memberships_db_load_from_id($conn, $id, $membership, $errors);
    }

    // Load membership contisations
    if($res){
       $res = memberships_db_load_membership_cotisations_list_from_id($conn, $id, $membership, $errors);
    }

    // Load current fiscal year
    $fiscalyear = null;
    if($res){
       $res = fiscalyears_db_load_from_id($conn, $membership['fiscal_year_id'], $fiscalyear, $errors);
       if($res){
         $membership['fiscal_year_id'] = $fiscalyear['id'];
       }
    }

    // Load cotisation list
    $listCotisation = null;
    if($res){
        $res = $dbController->getCotisationListByFiscalYearId($fiscalyear['id'], $listCotisation);
    }

    if($res){
        set('membership', $membership);
        set('cotisations', $listCotisation);

        set('page_title', sprintf(TS::Membership_Num, $id));
        set('page_submenus', getSubMenus("memberships"));
        return html('membership.edit.html.php');
    }else{
        set('page_title', "Bad request");
        return html('error.html.php');
    }
  }

dispatch_post('/memberships/:id/edit', 'membership_edit_post');
  function membership_edit_post()
  {
	$webuser = loadWebUser();
	if($webuser->is_anonymous){
		redirect_to('/login'); return;
	}

    $res = true;

    $conn = $GLOBALS['db_connexion'];
    $errors = array();
    $dbController = new DatabaseController($conn, $errors);

    // Load current fiscal year
    $fiscalyear = null;
    if($res){
       $res = fiscalyears_db_load_from_current($conn, $fiscalyear, $errors);
    }

    // Save data
    if($res){
        $membership = membership_load();
        $membership['cotisations'] = membership_cotisations_load($membership['id']);
    }

    // Load cotisation list
    $listCotisation = null;
    if($res){
        $res = $dbController->getCotisationListByFiscalYearId($membership['fiscal_year_id'], $listCotisation);
    }

    if($res){
        $bSavePerson = ($fiscalyear['id'] == $membership['fiscal_year_id']);
        $conn->beginTransaction();
        $res = membership_save($conn, $bSavePerson, $membership, $errors);
        if($res){
            $conn->commit();
        }else{
            $conn->rollBack();
        }
    }

    if($res){
		redirect_to('/memberships/'.$membership['id'].'/edit');
    }else{
	    set('membership', $membership);
	    set('cotisations', $listCotisation);

	    set('page_title', TS::Cotisation_CotisationRegister);
	    set('page_submenus', getSubMenus("cotisations"));
        set('errors', $errors);
	    return html('membership.edit.html.php');
    }
  }


?>
