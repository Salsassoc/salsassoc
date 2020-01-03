<?php

  function person_create()
  {
    $person = array(
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
        'comments' => null 
    );
    return $person;
  }

  function person_load()
  {
    $valueGender = 0;
    $valueImagerights = ($_POST['Imagerights'] != "" ? $_POST['Imagerights'] : null);
	$valueComments = ($_POST['Comments'] != "" ? $_POST['Comments'] : null);
    $person = array(
        'id' => $_POST['PersonId'],
        'firstname' => $_POST['Firstname'],
        'lastname' => $_POST['Lastname'],
        'gender' => $valueGender,
        'birthdate' => $_POST['Birthdate'],
        'address' => $_POST['Address'],
        'zipcode' => $_POST['Zipcode'],
        'city' => $_POST['City'],
        'email' => $_POST['Email'],
        'phonenumber' => $_POST['Phonenumber'],
        'phonenumber2' => $_POST['Phonenumber2'],
        'image_rights' => $valueImagerights,
        'comments' => $valueComments 
    );

    return $person;
  }

  function persons_db_load_from_id($conn, $id, &$person, &$errors)
  {
    $res = true;

    $sql =  'SELECT id, firstname, lastname, birthdate, address, zipcode, city, email, phonenumber, phonenumber2, image_rights, creation_date, comments FROM person WHERE id='.$id;
    $stmt = $conn->prepare($sql);
    if($stmt){
        $res = $stmt->execute();
        if ($res) {
            $person = $stmt->fetch();
        }else{
            $errors[] = TSHelper::pdoErrorText($stmt->errorInfo());
        }
    }else{
	    $res = false;
        $errors[] = TSHelper::pdoErrorText($conn->errorInfo());
    }

    return $res;
  }

  function persons_db_load_list($conn, $sql, &$persons, &$errors)
  {
    $res = true;

    $stmt = $conn->prepare($sql);
    if($stmt){
        $res = $stmt->execute();
        if ($res) {
            $persons = $stmt->fetchAll();
        }else{
            $errors[] = TSHelper::pdoErrorText($stmt->errorInfo());
        }
    }else{
	    $res = false;
        $errors[] = TSHelper::pdoErrorText($conn->errorInfo());
    }

    return $res;
  }

  function persons_db_load_list_from_fiscal_year($conn, $fiscalyear, &$persons, &$errors)
  {
    $sql =  "SELECT person.id AS id, person.firstname AS firstname, person.lastname AS lastname, person.birthdate AS birthdate, person.zipcode AS zipcode, person.city AS city, person.email AS email, person.phonenumber AS phonenumber, person.phonenumber2 AS phonenumber2, person.image_rights AS image_rights, creation_date, COUNT(DISTINCT fiscal_year_id) AS year_count, COUNT(membership.id) AS membership_count";
    $sql .= " FROM person LEFT JOIN membership ON person.id=person_id";
	$sql .= " WHERE fiscal_year_id=".$fiscalyear['id'];
    $sql .= ' GROUP BY person.id';
    $sql .= ' ORDER BY lastname, firstname';
    return persons_db_load_list($conn, $sql, $persons, $errors);
  }

  function persons_db_load_list_all($conn, &$persons, &$errors)
  {
    $sql =  "SELECT person.id AS id, person.firstname AS firstname, person.lastname AS lastname, person.birthdate AS birthdate, person.zipcode AS zipcode, person.city AS city, person.email AS email, person.phonenumber AS phonenumber, person.phonenumber2 AS phonenumber2, person.image_rights AS image_rights, creation_date, COUNT(DISTINCT fiscal_year_id) AS year_count, COUNT(membership.id) AS membership_count";
    $sql .= " FROM person LEFT JOIN membership ON person.id=person_id";
    $sql .= ' GROUP BY person.id';
    $sql .= ' ORDER BY lastname, firstname';
    return persons_db_load_list($conn, $sql, $persons, $errors);
  }

  function getPersonListQuery($bCurrentOnly, $currentDate)
  {
	$filter = "";
	if($bCurrentOnly){
		//$filter .= " WHERE fiscal_year_id = (SELECT id FROM fiscal_year WHERE is_current IS 'true' ORDER BY end_date DESC LIMIT 1)";
		$filter .= " AND '".$currentDate."' BETWEEN start_date AND end_date ";
	}

    $sql =  'SELECT person.id AS id, person.firstname AS firstname, person.lastname AS lastname, person.birthdate AS birthdate, person.zipcode AS zipcode, person.city AS city, person.email AS email, person.phonenumber AS phonenumber, person.phonenumber2 AS phonenumber2, person.image_rights AS image_rights, creation_date, COUNT(DISTINCT fiscal_year_id) AS year_count, COUNT(membership.id) AS membership_count';
    $sql .= ' FROM person LEFT JOIN membership ON person.id=person_id, fiscal_year';
    $sql .= ' WHERE fiscal_year.id = fiscal_year_id';
	$sql .= $filter;
    $sql .= ' GROUP BY person.id';
    $sql .= ' ORDER BY person.lastname, person.firstname';

    return $sql;
  }

  function person_list($bCurrentOnly)
  {
	$webuser = loadWebUser();
	if($webuser->is_anonymous){
		redirect_to('/login'); return;
	}

    $conn = $GLOBALS['db_connexion'];

    $res = true;

    // Load current fiscal year
    $fiscalyear = null;
    if($res){
       $res = fiscalyears_db_load_from_current($conn, $fiscalyear, $errors);
    }

    // Load the list of persons
    $persons = null;
    if($res){
      if($bCurrentOnly){
        $res = persons_db_load_list_from_fiscal_year($conn, $fiscalyear, $persons, $errors);
      }else{
        $res = persons_db_load_list_all($conn, $persons, $errors);
      }
    }

    if ($res) {
        set('personlist', $persons);
        set('page_id', "person_list");
        set('page_title', TS::Person_Members);
        set('page_submenus', getSubMenus("members"));
        return html('person.list.html.php');
    }

    set('page_title', "Bad request");
    return html('error.html.php');

  }

dispatch('/members', 'person_list_current');
  function person_list_current()
  {
	 return person_list(true);
  }

dispatch('/members/all', 'person_list_all');
  function person_list_all()
  {
	 return person_list(false);
  }

  function person_list_print($bCurrentOnly)
  {
	$webuser = loadWebUser();
	if($webuser->is_anonymous){
		redirect_to('/login'); return;
	}

    $conn = $GLOBALS['db_connexion'];

    $currentDate = date("Y-m-d");

    $sql = getPersonListQuery($bCurrentOnly, $currentDate);
    $stmt = $conn->prepare($sql);
    $res = $stmt->execute();
    if ($res) {
        $results = $stmt->fetchAll();
        set('personlist', $results);
        set('page_id', "person_list");
        set('page_title', TS::Person_Members);
        set('page_submenus', getSubMenus("members"));
        return render('person.list.print.html.php', "layout.print.html.php");
    }

    set('page_title', "Bad request");
    return html('error.html.php');

  }

dispatch('/members/print', 'person_list_current_print');
  function person_list_current_print()
  {
	 return person_list_print(true);
  }

dispatch('/members/add', 'person_add');
  function person_add()
  {
	$webuser = loadWebUser();
	if($webuser->is_anonymous){
		redirect_to('/login'); return;
	}

	$person = person_create();
	set('person', $person);

    set('page_title', TS::Person_AddMember);
    set('page_submenus', getSubMenus("members"));
    return html('person.html.php');
  }

dispatch('/members/:id', 'person_view');
  function person_view()
  {
	$webuser = loadWebUser();
	if($webuser->is_anonymous){
		redirect_to('/login'); return;
	}

    $id = params('id');
    $conn = $GLOBALS['db_connexion'];

    $res = true;

    // Load person
    $person = null;
    if($res){
       $res = persons_db_load_from_id($conn, $id, $person, $errors);
    }

    // Load memberships
    $memberships = null;
    if($res){
       $res = memberships_db_load_list_from_person_id($conn, $person['id'], $memberships, $errors);
    }
 
    if($res){
        set('person', $person);
        set('listMembership', $memberships);

        set('page_title', sprintf(TS::Person_MemberNum, $id));
        set('page_submenus', getSubMenus("members"));
        return html('person.html.php');
    }else{
        set('page_title', "Bad request");
        return html('error.html.php');
    }
  }

  function person_save($conn, $id, &$person, &$errors)
  {
    $res = true;

    // Check data
    if($person['firstname'] == ""){
        $errors[] = "Firstname cannot be empty";
        $res = false;
    }
    if($person['lastname'] == ""){
        $errors[] = "Lastname cannot be empty";
        $res = false;
    }

	// Prepare the query
	$stmt = null;
    if($res){
        if($id==0){
        	$sql =  'INSERT INTO person (firstname, lastname, gender, birthdate, address, zipcode, city, email, phonenumber, phonenumber2, image_rights, comments, creation_date, is_member) VALUES (:firstname, :lastname, :gender, :birthdate, :address, :zipcode, :city, :email, :phonenumber, :phonenumber2, :image_rights, :comments, date(\'now\'), 1)';
	    }else{
        	$sql =  'UPDATE person SET firstname=:firstname, lastname=:lastname, gender=:gender, birthdate=:birthdate, address=:address, zipcode=:zipcode, city=:city, email=:email, phonenumber=:phonenumber, phonenumber2=:phonenumber2, image_rights=:image_rights, comments=:comments WHERE id=:id';
	    }

	    $stmt = $conn->prepare($sql);
	    if(!$stmt){
			$res = false;
		    $errors[] = TSHelper::pdoErrorText($conn->errorInfo());
	    }

	}

	// Execute the query
	if($res){
	    if($id!=0){
		    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
	    }else{
		    //$stmt->bindParam(':creation_date', $id, PDO::PARAM_INT);
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
	    $stmt->bindParam(':comments', $person['comments'], PDO::PARAM_STR);
	    $res = $stmt->execute();
        if($res){
            if($id==0){
		        $person["id"] = $conn->lastInsertId();
            }
        }else{
	        $errors[] = TSHelper::pdoErrorText($stmt->errorInfo());
        }
    }

    return $res;
  }

dispatch_post('/members/:id/edit', 'person_edit');
  function person_edit()
  {
	$webuser = loadWebUser();
	if($webuser->is_anonymous){
		redirect_to('/login'); return;
	}

	$res = false;

    $id = params('id');
    $conn = $GLOBALS['db_connexion'];

    $person = person_load();
    $errors = array();

    $res = person_save($conn, $id, $person, $errors);

	if($res){
		if($id == 0){
			$id = $conn->lastInsertId();
		}
		redirect_to('/members/'.$id);
		return;
	}else{
        set('person', $person);
        set('errors', $errors);

        set('page_title', TS::Person_AddMember);
        set('page_submenus', getSubMenus("members"));
        return html('person.html.php');
	}
}



?>
