<?php

  function operation_category_create()
  {
    $model = array(
        'label' => ''
    );
    return $model;
  }

  function operation_category_load()
  {
    $model = array(
        'id' => $_POST['Id'],
        'label' => $_POST['Label']
    );

    return $model;
  }

 function operation_category_save($conn, $id, &$model, &$errors)
  {
    $res = true;

    // Check data
    if($model['label'] == ""){
        $errors[] = "Label cannot be empty";
        $res = false;
    }

	// Prepare the query
	$stmt = null;
    if($res){
        if($id==0){
        	$sql =  'INSERT INTO accounting_operation_category (label) VALUES (:label)';
	    }else{
        	$sql =  'UPDATE accounting_operation_category SET label=:label WHERE id=:id';
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

dispatch('/accounting/operationcategories', 'accounting_operation_category_list');
  function accounting_operation_category_list()
  {
	$webuser = loadWebUser();
	if($webuser->is_anonymous){
		redirect_to('/login'); return;
	}

    $conn = $GLOBALS['db_connexion'];

	// Get foperation list
    $sql =  'SELECT id, label FROM accounting_operation_category';
	$sql .= ' ORDER BY label';
    $stmt = $conn->prepare($sql);
    $res = $stmt->execute();
    if ($res) {
        $results = $stmt->fetchAll();
        set('operationcategories', $results);

	}

	// Render data
	if($res){
        set('page_title', TS::AccountingOperationCategory_List);
        set('page_submenus', getSubMenus("accounting"));
        return html('accounting.operationcategory.list.html.php');
    }

    set('page_title', "Bad request");
    return html('error.html.php');
  }

dispatch('/accounting/operationcategories/add', 'operation_category_add');
  function operation_category_add()
  {
	$webuser = loadWebUser();
	if($webuser->is_anonymous){
		redirect_to('/login'); return;
	}

	$operationcategory = operation_category_create();
	set('operationcategory', $operationcategory);

    set('page_title', TS::AccountingOperationCategory_AddCategory);
    set('page_submenus', getSubMenus("members"));
    return html('accounting.operationcategory.html.php');
  }

dispatch('/accounting/operationcategories/:id', 'operation_category_view');
  function operation_category_view()
  {
	$webuser = loadWebUser();
	if($webuser->is_anonymous){
		redirect_to('/login'); return;
	}

    $id = params('id');
    $conn = $GLOBALS['db_connexion'];
    $sql = 'SELECT id, label FROM accounting_operation_category WHERE id='.$id;
    $results = $conn->query($sql);

    if(count($results) == 1){
        set('operationcategory', $results->fetch());

        set('page_title', sprintf(TS::AccountingOperationCategory_ViewCategory, $id));
        set('page_submenus', getSubMenus("accounting"));
        return html('accounting.operationcategory.html.php');
    }else{
        set('page_title', "Bad request");
        return html('error.html.php');
    }
  }

dispatch_post('/accounting/operationcategories/:id/edit', 'operation_category_edit');
  function operation_category_edit()
  {
	$webuser = loadWebUser();
	if($webuser->is_anonymous){
		redirect_to('/login'); return;
	}

	$res = false;

    $id = params('id');
    $conn = $GLOBALS['db_connexion'];

    $operationcategory = operation_category_load();
    $errors = array();

    $res = operation_category_save($conn, $id, $operationcategory, $errors);

	if($res){
		if($id == 0){
			$id = $conn->lastInsertId();
		}
		redirect_to('/accounting/operationcategories/'.$id);
		return;
	}else{
        set('operationcategory', $operationcategory);
        set('errors', $errors);

        set('page_title', TS::AccountingOperationCategory_ViewCategory);
        set('page_submenus', getSubMenus("accounting"));
        return html('accounting.operationcategory.html.php');
	}
  }

?>
