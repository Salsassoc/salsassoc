<?php

  function getSubMenus()
  {
	$submenus = array();
	$submenus["/members"] = TS::Person_CurrentMembers;
	$submenus["/members/all"] = TS::Person_AllMembers;
	$submenus["/members/add"] = TS::Person_AddMember;
	return $submenus;
  }

  function person_list($bCurrentOnly)
  {
	$webuser = loadWebUser();
	if($webuser->is_anonymous){
		redirect_to('/login'); return;
	}

	// Compute filter
	$filter = "";
	if($bCurrentOnly){
		$filter .= " WHERE fiscal_year_id = (SELECT id FROM fiscal_year ORDER BY end_date LIMIT 1)";
	}

    $conn = $GLOBALS['db_connexion'];

    $sql =  'SELECT person.id as id, firstname, lastname, birthdate, email, phonenumber, image_rights, creation_date, COUNT(DISTINCT fiscal_year_id) AS year_count, COUNT(cotisation_id) AS cotisation_count
        FROM person LEFT JOIN cotisation_member ON person.id=person_id LEFT JOIN cotisation ON cotisation.id = cotisation_id';
	$sql .= $filter;
    $sql .= ' GROUP BY person.id';
    $sql .= ' ORDER BY lastname, firstname';

    $stmt = $conn->prepare($sql);
    $res = $stmt->execute();
    if ($res) {
        $results = $stmt->fetchAll();
        set('personlist', $results);
        set('page_id', "person_list");
        set('page_title', TS::Person_Members);
        set('page_submenus', getSubMenus());
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

dispatch('/members/add', 'person_add');
  function person_add()
  {
	$webuser = loadWebUser();
	if($webuser->is_anonymous){
		redirect_to('/login'); return;
	}

	$person = array('firstname' => '', 'lastname' => '', 'birthdate' => '', 'email' => '', 'phonenumber' => '', 'image_rights' => '', 'comments' => '');
	set('person', $person);

    set('page_title', TS::Person_AddMember);
    set('page_submenus', getSubMenus());
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
    $sql =  'SELECT id, firstname, lastname, birthdate, email, phonenumber, image_rights, creation_date, comments FROM person WHERE id='.$id;
    $results = $conn->query($sql);

    $sql =  'SELECT id, label, cotisation.amount AS cotisation_amount, start_date, end_date, date, cotisation_member.amount as amount, payment_method FROM cotisation, cotisation_member WHERE cotisation.id=cotisation_id AND person_id='.$id;
    $results2 = $conn->query($sql);

    if(count($results) == 1){
        set('person', $results->fetch());
        set('cotisations', $results2);

        set('page_title', sprintf(TS::Person_MemberNum, $id));
        set('page_submenus', getSubMenus());
        return html('person.html.php');
    }else{
        set('page_title', "Bad request");
        return html('error.html.php');
    }
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
	if($id==0){
    	$sql =  'INSERT INTO person (firstname, lastname, gender, birthdate, email, phonenumber, image_rights, comments, creation_date, is_member) VALUES (:firstname, :lastname, :gender, :birthdate, :email, :phonenumber, :image_rights, :comments, date(\'now\'), 1)';
	}else{
    	$sql =  'UPDATE person SET firstname=:firstname, lastname=:lastname, gender=:gender, birthdate=:birthdate, email=:email, phonenumber=:phonenumber, image_rights=:image_rights, comments=:comments WHERE id=:id';
	}

	$stmt = $conn->prepare($sql);
	if(!$stmt){
		print_r($conn->errorInfo());
	}else{
		if($id!=0){
			$stmt->bindParam(':id', $id, PDO::PARAM_INT);
		}else{
			//$stmt->bindParam(':creation_date', $id, PDO::PARAM_INT);
		}
		$stmt->bindParam(':firstname', $_POST['Firstname'], PDO::PARAM_STR, 50);
		$stmt->bindParam(':lastname', $_POST['Lastname'], PDO::PARAM_STR, 50);
		$valueGender = 0;
		$stmt->bindParam(':gender', $valueGender, PDO::PARAM_INT);
		$stmt->bindParam(':birthdate', $_POST['Birthdate'], PDO::PARAM_STR, 10);
		$stmt->bindParam(':email', $_POST['Email'], PDO::PARAM_STR, 100);
		$stmt->bindParam(':phonenumber', $_POST['Phonenumber'], PDO::PARAM_STR, 50);
		$valueImagerights = ($_POST['Imagerights'] != "" ? $_POST['Imagerights'] : null);
		$stmt->bindParam(':image_rights', $valueImagerights, PDO::PARAM_STR);
		$valueComments = ($_POST['Comments'] != "" ? $_POST['Comments'] : null);
		$stmt->bindParam(':comments', $valueComments, PDO::PARAM_STR);
		$res = $stmt->execute();
		print_r($stmt->errorInfo());
	}

	if($res){
		if($id == 0){
			$id = $conn->lastInsertId();
		}
		redirect_to('/members/'.$id);
		return;
	}else{
        set('page_title', "Bad request");
        return html('error.html.php');
	}
}



?>
