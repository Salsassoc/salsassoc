<?php

  function account_create()
  {
    $model = array(
        'label' => '',
        'type' => ''
    );
    return $model;
  }

  function account_load()
  {
    $title = ($_POST['Title'] != "" ? $_POST['Title'] : null);
    $model = array(
        'id' => $_POST['AccountId'],
        'label' => $_POST['Label'],
        'type' => $_POST['Type'],
    );

    return $model;
  }

 function account_save($conn, $id, &$model, &$errors)
  {
    $res = true;

    // Check data
    if($model['label'] == ""){
        $errors[] = "Label cannot be empty";
        $res = false;
    }
    if($model['type'] == ""){
        $errors[] = "Type cannot be empty";
        $res = false;
    }

	// Prepare the query
	$stmt = null;
    if($res){
        if($id==0){
        	$sql =  'INSERT INTO accounting_account (label, type) VALUES (:label, :type)';
	    }else{
        	$sql =  'UPDATE accounting_account SET label=:label, type=:type WHERE id=:id';
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
	    $stmt->bindParam(':label', $model['label'], PDO::PARAM_STR, 50);
	    $stmt->bindParam(':type', $model['type'], PDO::PARAM_INT);
	    $res = $stmt->execute();
        if($res){
            if($id==0){
		        $model["id"] = $conn->lastInsertId();
            }
        }else{
	        $errors[] = TSHelper::pdoErrorText($stmt->errorInfo());
        }
    }

    return $res;
  }

dispatch('/accounting/accounts', 'accounting_account_list');
  function accounting_account_list()
  {
	$webuser = loadWebUser();
	if($webuser->is_anonymous){
		redirect_to('/login'); return;
	}

    $conn = $GLOBALS['db_connexion'];

	// Get foperation list
    $sql =  'SELECT id, label, type FROM accounting_account';
	$sql .= ' ORDER BY type, label';
    $stmt = $conn->prepare($sql);
    $res = $stmt->execute();
    if ($res) {
        $results = $stmt->fetchAll();
        set('accounts', $results);

	}

	// Render data
	if($res){
        set('page_title', TS::AccountingAccount_List);
        set('page_submenus', getSubMenus("accounting"));
        return html('accounting.account.list.html.php');
    }

    set('page_title', "Bad request");
    return html('error.html.php');
  }

dispatch('/accounting/accounts/add', 'account_add');
  function account_add()
  {
	$webuser = loadWebUser();
	if($webuser->is_anonymous){
		redirect_to('/login'); return;
	}

	$account = account_create();
	set('account', $account);

    set('page_title', TS::Accounting_AccountAdd);
    set('page_submenus', getSubMenus("accounting"));
    return html('accounting.account.html.php');
  }

dispatch('/accounting/accounts/:id', 'account_view');
  function account_view()
  {
	$webuser = loadWebUser();
	if($webuser->is_anonymous){
		redirect_to('/login'); return;
	}

    $id = params('id');
    $conn = $GLOBALS['db_connexion'];
    $sql = 'SELECT id, label, type FROM accounting_account WHERE id='.$id;
    $results = $conn->query($sql);

    if(count($results) == 1){
        set('account', $results->fetch());

        set('page_title', sprintf(TS::AccountingAccount_View, $id));
        set('page_submenus', getSubMenus("accounting"));
        return html('accounting.account.html.php');
    }else{
        set('page_title', "Bad request");
        return html('error.html.php');
    }
  }

dispatch_post('/accounting/accounts/:id/edit', 'account_edit');
  function account_edit()
  {
	$webuser = loadWebUser();
	if($webuser->is_anonymous){
		redirect_to('/login'); return;
	}

	$res = false;

    $id = params('id');
    $conn = $GLOBALS['db_connexion'];

    $account = account_load();
    $errors = array();

    $res = account_save($conn, $id, $account, $errors);

	if($res){
		if($id == 0){
			$id = $conn->lastInsertId();
		}
		redirect_to('/accounting/accounts/'.$id);
		return;
	}else{
        set('account', $account);
        set('errors', $errors);

        set('page_title', TS::AccountingAccount_Add);
        set('page_submenus', getSubMenus("accounting"));
        return html('accounting.account.html.php');
	}
  }

?>
