<?php

dispatch('/members', 'person_list');
  function person_list()
  {
	$webuser = loadWebUser();
	if($webuser->is_anonymous){
		redirect_to('/login'); return;
	}

    $conn = $GLOBALS['db_connexion'];
    $sql =  'SELECT id, firstname, lastname, birthdate, email, phonenumber, image_rights, creation_date FROM person ORDER BY lastname, firstname';
    $results = $conn->query($sql);
   
    set('personlist', $results);

    set('page_title', "Members");
    return html('person.list.html.php');
  }

?>
