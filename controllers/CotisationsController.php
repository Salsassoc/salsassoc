<?php

dispatch('/cotisations', 'cotisation_list');
  function cotisation_list()
  {
	$webuser = loadWebUser();
	if($webuser->is_anonymous){
		redirect_to('/login'); return;
	}

    $conn = $GLOBALS['db_connexion'];
    $sql =  'SELECT id, label, start_date, end_date, COUNT(cotisation_id) AS cotisation_count
        FROM cotisation LEFT JOIN cotisation_member ON cotisation.id=cotisation_id
        GROUP BY cotisation.id
        ORDER BY start_date';
    $results = $conn->query($sql);
   
    set('cotisations', $results);

    set('page_title', "Cotisations");
    return html('cotisation.list.html.php');
  }

?>
