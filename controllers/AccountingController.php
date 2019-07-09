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
/*
dispatch('/fiscalyears/:id', 'fiscalyear_view');
  function accounting_operation_view()
  {
	$webuser = loadWebUser();
	if($webuser->is_anonymous){
		redirect_to('/login'); return;
	}

    $id = params('id');
    $conn = $GLOBALS['db_connexion'];
    $sql = 'SELECT id, title, start_date, end_date, is_current FROM fiscal_year WHERE id='.$id;
    $results = $conn->query($sql);

    if(count($results) == 1){
        set('fiscalyear', $results->fetch());

        set('page_title', sprintf(TS::FiscalYear_YearTitle, $id));
        set('page_submenus', getSubMenus("fiscalyears"));
        return html('fiscalyear.html.php');
    }else{
        set('page_title', "Bad request");
        return html('error.html.php');
    }
  }

  function accounting_operation_save($conn, $id, &$fiscalyear, &$errors)
  {
    $res = true;

    // Check data
    if($fiscalyear['start_date'] == ""){
        $errors[] = "Start date cannot be empty";
        $res = false;
    }
    if($fiscalyear['end_date'] == ""){
        $errors[] = "End date cannot be empty";
        $res = false;
    }

	// Prepare the query
	$stmt = null;
    if($res){
        if($id==0){
        	$sql =  'INSERT INTO fiscal_year (title, start_date, end_date, is_current) VALUES (:title, :start_date, :end_date, :is_current)';
	    }else{
        	$sql =  'UPDATE fiscal_year SET title=:title, start_date=:start_date, end_date=:end_date, is_current=:is_current WHERE id=:id';
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
	    $stmt->bindParam(':title', $fiscalyear['title'], PDO::PARAM_STR, 50);
	    $stmt->bindParam(':start_date', $fiscalyear['start_date'], PDO::PARAM_STR, 10);
	    $stmt->bindParam(':end_date', $fiscalyear['end_date'], PDO::PARAM_STR, 10);
	    $stmt->bindParam(':is_current', $fiscalyear['is_current'], PDO::PARAM_STR);
	    $res = $stmt->execute();
        if($res){
            if($id==0){
		        $person["id"] = $conn->lastInsertId();
            }
        }else{
	        $errors[] = TSHelper::pdoErrorText($stmt->errorInfo());
        }
    }

    return $res;
  }

dispatch_post('/fiscalyears/:id/edit', 'fiscalyear_edit');
  function accounting_operation_edit()
  {
	$webuser = loadWebUser();
	if($webuser->is_anonymous){
		redirect_to('/login'); return;
	}

	$res = false;

    $id = params('id');
    $conn = $GLOBALS['db_connexion'];

    $fiscalyear = fiscalyear_load();
    $errors = array();

    $res = fiscalyear_save($conn, $id, $fiscalyear, $errors);

	if($res){
		if($id == 0){
			$id = $conn->lastInsertId();
		}
		redirect_to('/fiscalyears/'.$id);
		return;
	}else{
        set('fiscalyear', $fiscalyear);
        set('errors', $errors);

        set('page_title', TS::FiscalYear_EditFiscalYear);
        set('page_submenus', getSubMenus("fiscalyear"));
        return html('fiscalyear.html.php');
	}
}
*/
?>
