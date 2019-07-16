<?php

  function accounting_operation_create()
  {
    $operation = array(
        'label' => '',
        'start_date' => '',
        'end_date' => '',
        'is_current' => false,
    );
    return $operation;
  }

  function accounting_operation_load()
  {
    $title = ($_POST['Title'] != "" ? $_POST['Title'] : null);
    $accounting = array(
        'id' => $_POST['FiscalYearId'],
        'title' => $title,
        'start_date' => $_POST['StartDate'],
        'end_date' => $_POST['EndDate'],
        'is_current' => $_POST['IsCurrent']
    );

    return $accounting;
  }

dispatch('/accounting', 'accounting_operation_list');
dispatch('/accounting/operations', 'accounting_operation_list');
  function accounting_operation_list()
  {
	$webuser = loadWebUser();
	if($webuser->is_anonymous){
		redirect_to('/login'); return;
	}

    $conn = $GLOBALS['db_connexion'];

	// Get foperation list
    $sql =  'SELECT id, label, category, date_value, amount FROM accounting_operation';
	$sql .= ' ORDER BY date_value DESC';
    $stmt = $conn->prepare($sql);
    $res = $stmt->execute();
    if ($res) {
        $results = $stmt->fetchAll();
        set('operations', $results);

	}

	// Render data
	if($res){
        set('page_title', "Accounting");
        set('page_submenus', getSubMenus("accounting"));
        return html('accounting.operation.list.html.php');
    }

    set('page_title', "Bad request");
    return html('error.html.php');
  }

?>
