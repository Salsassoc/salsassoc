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

    $res = true;

    $conn = $GLOBALS['db_connexion'];
    $errors = array();
    $dbController = new DatabaseController($conn, $errors);

    // Load fiscal year list
    $listFiscalYear = null;
    if($res){
        $res = $dbController->getFiscalYearList($listFiscalYear);
    }

    // Load account list
    $listAccountingAccount = null;
    if($res){
        $res = $dbController->getAccountingAccountList($listAccountingAccount);
    }

    // Load category list
    $listAccountingOperationCategory = null;
    if($res){
        $res = $dbController->getAccountingOperationCategoryList($listAccountingOperationCategory);
    }

    // Load operation list
    $listAccountingOperation = null;
    if($res){
        $res = $dbController->getAccountingOperationList($listAccountingOperation);
    }

	// Render data
	if($res){
        // Pass data
        set('listFiscalYear', $listFiscalYear);
        set('listAccountingAccount', $listAccountingAccount);
        set('listAccountingOperationCategory', $listAccountingOperationCategory);
        set('listAccountingOperation', $listAccountingOperation);

        set('page_title', "Accounting");
        set('page_submenus', getSubMenus("accounting"));
        return html('accounting.operation.list.html.php');
    }

    set('page_title', "Bad request");
    return html('error.html.php');
  }

?>
