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
  function registrations_list()
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

dispatch('/registrations', 'registrations_list_all');
  function registrations_list_all()
  {
	return registrations_list(false);
  }

/*
dispatch('/registrations/membership', 'registrations_list_membership');
  function registrations_list_membership()
  {
	return registrations_list(true);
  }

  function registrations_register($person_id)
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
  }*/

?>
