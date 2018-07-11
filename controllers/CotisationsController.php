<?php

dispatch('/cotisations', 'cotisation_list');
  function cotisation_list()
  {
	$webuser = loadWebUser();
	if($webuser->is_anonymous){
		redirect_to('/login'); return;
	}

    $conn = $GLOBALS['db_connexion'];

    $sql =  'SELECT id, label, start_date, end_date, cotisation.amount AS amount, COUNT(cotisation_id) AS cotisation_count, SUM(cotisation_member.amount) AS cotisation_totalamount
        FROM cotisation LEFT JOIN cotisation_member ON cotisation.id=cotisation_id
        GROUP BY cotisation.id
        ORDER BY start_date';
    $stmt = $conn->prepare($sql);
    $res = $stmt->execute();
    if ($res) {
        $results = $stmt->fetchAll();
        set('cotisationlist', $results);

        set('page_title', "Cotisations");
        return html('cotisation.list.html.php');
    }

    set('page_title', "Bad request");
    return html('error.html.php');
  }

dispatch('/cotisation/:id/members', 'cotisation_members_list');
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
           WHERE cotisation.id = cotisation_id AND cotisation.fiscal_year_id < (SELECT fiscal_year_id FROM cotisation WHERE id=10)
           GROUP BY person_id
          ) AS CotisationCount ON CotisationCount.person_id=person.id
        WHERE person.id=cotisation_member.person_id AND cotisation_id=10
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
