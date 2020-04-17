<?php

  function accounting_operation_create()
  {
    $operation = array(
        'label' => '',
        'date_value' => '',
        'category' => 0,
        'op_method' => OperationMethod::Unknown,
        'op_method_number' => '',
        'amount_debit' => '',
        'amount_credit' => '',
        'fiscalyear_id' => 0,
        'date_effective' => '',
        'label_bank'=>'',
        'account_id'=> 0,
        'checked'=> false
    );
    return $operation;
  }

  function accounting_operation_load()
  {
    $accounting = array(
        'id' => $_POST['Id'],
        'label' => $_POST['Label'],
        'date_value' => $_POST['DateValue'],
        'category' => $_POST['CategoryId'],
        'op_method' => $_POST['OpMethod'],
        'op_method_number' => $_POST['OpMethodNumber'],
        'amount_debit' => formatFloat($_POST['AmountDebit']),
        'amount_credit' => formatFloat($_POST['AmountCredit']),
        'fiscalyear_id' => $_POST['FiscalYearId'],
        'date_effective' => $_POST['DateEffective'],
        'label_bank' => $_POST['LabelBank'],
        'account_id' => $_POST['AccountId'],
        'checked' => false,
    );

    return $accounting;
  }

dispatch('/accounting', 'accounting_operation_list');
dispatch('/accounting/operations', 'accounting_operation_list');
dispatch_post('/accounting/operations', 'accounting_operation_list');
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

    // Load data
    $iAccountId = null;
    if(isset($_POST['AccountId'])){
        $iAccountId = $_POST['AccountId'];
    }
    $iFiscalYearId = null;
    if(isset($_POST['FiscalYearId'])){
        $iFiscalYearId = $_POST['FiscalYearId'];
    }
    $iCategoryId = null;
    if(isset($_POST['CategoryId'])){
        $iCategoryId = $_POST['CategoryId'];
    }

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

    // Load filters
    $filters = array();
    if($iAccountId != null){
       $filters['account_id'] = $iAccountId;
    }
    if($iFiscalYearId != null){
       $filters['fiscal_year_id'] = $iFiscalYearId;
    }
    if($iCategoryId != null){
       $filters['category_id'] = $iCategoryId;
    }

    // Load operation list
    $listAccountingOperation = null;
    if($res){
        $res = $dbController->getAccountingOperationList($listAccountingOperation, $filters);
    }

	// Render data
	if($res){
        // Pass data
        set('listFiscalYear', $listFiscalYear);
        set('listAccountingAccount', $listAccountingAccount);
        set('listAccountingOperationCategory', $listAccountingOperationCategory);
        set('listAccountingOperation', $listAccountingOperation);
        set('filters', $filters);

        set('page_title', "Accounting");
        set('page_submenus', getSubMenus("accounting"));
        return html('accounting.operation.list.html.php');
    }

    set('page_title', "Bad request");
    return html('error.html.php');
  }

dispatch('/accounting/operations/add', 'accounting_operation_add');
  function accounting_operation_add()
  {
	$webuser = loadWebUser();
	if($webuser->is_anonymous){
		redirect_to('/login'); return;
	}

    $res = true;

    $conn = $GLOBALS['db_connexion'];
    $errors = array();
    $dbController = new DatabaseController($conn, $errors);

    // Initialize operation
	$operation = accounting_operation_create();

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

	// Render data
	if($res){
        // Pass data
        set('listFiscalYear', $listFiscalYear);
        set('listAccountingAccount', $listAccountingAccount);
        set('listAccountingOperationCategory', $listAccountingOperationCategory);
	    set('operation', $operation);

        set('page_title', TS::AccountingOperationCategory_AddCategory);
        set('page_submenus', getSubMenus("accounting"));
        return html('accounting.operation.html.php');
    }

    set('page_title', "Bad request");
    return html('error.html.php');
  }

dispatch('/accounting/operations/:id', 'accounting_operation_view');
  function accounting_operation_view()
  {
	$webuser = loadWebUser();
	if($webuser->is_anonymous){
		redirect_to('/login'); return;
	}

    $res = true;

    $conn = $GLOBALS['db_connexion'];
    $errors = array();
    $dbController = new DatabaseController($conn, $errors);

    // Load params 
    $id = params('id');

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

    // Initialize operation
    $operation = null;
    if($res){
        $res = $dbController->getAccountingOperationById($id, $operation);
    }

    if($res){
        // Pass data
        set('listFiscalYear', $listFiscalYear);
        set('listAccountingAccount', $listAccountingAccount);
        set('listAccountingOperationCategory', $listAccountingOperationCategory);
	    set('operation', $operation);

        set('page_title', sprintf(TS::AccountingOperationCategory_ViewCategory, $id));
        set('page_submenus', getSubMenus("accounting"));
        return html('accounting.operation.html.php');
    }else{
        set('page_title', "Bad request");
        return html('error.html.php');
    }
  }

dispatch_post('/accounting/operations/:id/edit', 'accounting_operation_edit');
  function accounting_operation_edit()
  {
	$webuser = loadWebUser();
	if($webuser->is_anonymous){
		redirect_to('/login'); return;
	}

    $res = true;

    $conn = $GLOBALS['db_connexion'];
    $errors = array();
    $dbController = new DatabaseController($conn, $errors);

    // Load params 
    $id = params('id');

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

    // Initialize operation
    $operation = accounting_operation_load();
    if($res){
        $res = $dbController->saveAccountingOperation($operation);
    }

	if($res){
		if($id == 0){
			$id = $conn->lastInsertId();
		}
		redirect_to('/accounting/operations/'.$id);
		return;
	}else{
        // Pass data
        set('listFiscalYear', $listFiscalYear);
        set('listAccountingAccount', $listAccountingAccount);
        set('listAccountingOperationCategory', $listAccountingOperationCategory);
	    set('operation', $operation);

        set('errors', $errors);

        set('page_title', TS::AccountingOperation_View);
        set('page_submenus', getSubMenus("accounting"));
        return html('accounting.operation.html.php');
	}
  }
?>
