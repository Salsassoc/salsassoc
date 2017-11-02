<?php

dispatch('/members', 'person_list');
  function person_list()
  {
	$webuser = loadWebUser();
	if($webuser->is_anonymous){
		redirect_to('/login'); return;
	}

    $conn = $GLOBALS['db_connexion'];

    $sql =  'SELECT id, firstname, lastname, birthdate, email, phonenumber, image_rights, creation_date, COUNT(cotisation_id) AS cotisation_count
        FROM person LEFT JOIN cotisation_member ON person.id=person_id
        GROUP BY person.id
        ORDER BY lastname, firstname';
    $stmt = $conn->prepare($sql);
    $res = $stmt->execute();
    if ($res) {
        $results = $stmt->fetchAll();
        set('personlist', $results);

        set('page_title', "Members");
        return html('person.list.html.php');
    }

    set('page_title', "Bad request");
    return html('error.html.php');

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


   

/*$sql = "SELECT * FROM fruit WHERE calories > :calories";
$sth->bindParam(':calories', 100, PDO::PARAM_INT);*/

    if(count($results) == 1){
        set('person', $results->fetch());
        set('cotisations', $results2);

        set('page_title', "Member #$id");
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
    $sql =  'UPDATE person SET firstname=:firstname, lastname=:lastname, birthdate=:birthdate, email=:email, phonenumber=:phonenumber, image_rights=:image_rights, comments=:comments WHERE id=:id';

	$stmt = $conn->prepare($sql);
	if(!$stmt){
		//print_r($conn->errorInfo());
	}else{
		$stmt->bindParam(':id', $id, PDO::PARAM_INT);
		$stmt->bindParam(':firstname', $_POST['Firstname'], PDO::PARAM_STR, 50);
		$stmt->bindParam(':lastname', $_POST['Lastname'], PDO::PARAM_STR, 50);
		$stmt->bindParam(':birthdate', $_POST['Birthdate'], PDO::PARAM_STR, 10);
		$stmt->bindParam(':email', $_POST['Email'], PDO::PARAM_STR, 100);
		$stmt->bindParam(':phonenumber', $_POST['Phonenumber'], PDO::PARAM_STR, 50);
		$valueImagerights = ($_POST['Imagerights'] != "" ? $_POST['Imagerights'] : null);
		$stmt->bindParam(':image_rights', $valueImagerights, PDO::PARAM_STR);
		$valueComments = ($_POST['Comments'] != "" ? $_POST['Comments'] : null);
		$stmt->bindParam(':comments', $valueComments, PDO::PARAM_STR);
		$res = $stmt->execute();
		//print_r($stmt->errorInfo());
	}

	if($res){
		redirect_to('/members/'.$id);
		return;
	}else{
        set('page_title', "Bad request");
        return html('error.html.php');
	}
}



?>
