<?php

  function cotisation_create()
  {
    $cotisation = array(
        'label' => '',
        'amount' => '',
        'start_date' => '',
        'end_date' => '',
        'fiscal_year_id' => '',
        'type' => 0,
    );
    return $cotisation;
  }

  function cotisation_load()
  {
    $label = ($_POST['Label'] != "" ? $_POST['Label'] : null);
    $cotisation = array(
        'id' => $_POST['Id'],
        'label' => $label,
        'amount' => $_POST['Amount'],
        'start_date' => $_POST['StartDate'],
        'end_date' => $_POST['EndDate'],
        'fiscal_year_id' => $_POST['FiscalYearId'],
        'type' => $_POST['Type']
    );

    return $cotisation;
  }

  function cotisation_list($bMembershipOnly)
  {
	$webuser = loadWebUser();
	if($webuser->is_anonymous){
		redirect_to('/login'); return;
	}

    $res = true;

    $conn = $GLOBALS['db_connexion'];
    $errors = array();
    $dbController = new DatabaseController($conn, $errors);

    // Load cotisation list
    $listCotisation = null;
    if($res){
        $res = $dbController->getCotisationList($bMembershipOnly, $listCotisation);
    }

    // Load membership cotsation per cotisation list
    $listMembershipSummaryPerCotisation = null;
    if($res){
        $res = $dbController->getMembershipSummaryPerCotisation($listMembershipSummaryPerCotisation);
    }

    if ($res) {
        set('listCotisation', $listCotisation);
        set('listMembershipSummaryPerCotisation', $listMembershipSummaryPerCotisation);

        set('page_title', "Cotisations");
        set('page_submenus', getSubMenus("cotisations"));
        return html('cotisation.list.html.php');
    }

    set('page_title', "Bad request");
    set('errors', $errors);
    return html('error.html.php');
  }

dispatch('/cotisations', 'cotisation_list_all');
  function cotisation_list_all()
  {
	return cotisation_list(false);
  }

dispatch('/cotisations/add', 'cotisation_add');
  function cotisation_add()
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
	$cotisation = cotisation_create();

    // Load fiscal year list
    $listFiscalYear = null;
    if($res){
        $res = $dbController->getFiscalYearList($listFiscalYear);
    }

	// Render data
	if($res){
        // Pass data
        set('listFiscalYear', $listFiscalYear);
	    set('cotisation', $cotisation);

        set('page_title', TS::Cotisation_AddNew);
        set('page_submenus', getSubMenus("cotisations"));
        return html('cotisation.html.php');
    }

    set('page_title', "Bad request");
    return html('error.html.php');
  }

dispatch('/cotisations/:id', 'cotisation_view');
  function cotisation_view()
  {
	$webuser = loadWebUser();
	if($webuser->is_anonymous){
		redirect_to('/login'); return;
	}

    $id = params('id');

    $res = true;

    $conn = $GLOBALS['db_connexion'];
    $errors = array();
    $dbController = new DatabaseController($conn, $errors);

    // Load cotisation
    $cotisation = null;
    if($res){
        $res = $dbController->getCotisationById($id, $cotisation);
    }

    // Load fiscal year list
    $listFiscalYear = null;
    if($res){
        $res = $dbController->getFiscalYearList($listFiscalYear);
    }

    if($cotisation != null){
        set('cotisation', $cotisation);
        set('listFiscalYear', $listFiscalYear);

        set('page_title', sprintf(TS::Cotisation_CotisationTitle, $id));
        set('page_submenus', getSubMenus("cotisations"));
        return html('cotisation.html.php');
    }else{
        set('page_title', "Bad request");
        return html('error.html.php');
    }
  }


  function cotisation_save($dbController, $id, &$cotisation)
  {
    $res = true;

    // Check data
    if($cotisation['start_date'] == ""){
        $errors[] = "Start date cannot be empty";
        $res = false;
    }
    if($cotisation['end_date'] == ""){
        $errors[] = "End date cannot be empty";
        $res = false;
    }

	// Save the cotisation
	$stmt = null;
    if($res){
        $res = $dbController->saveCotisation($id, $cotisation);
	}

    return $res;
  }

dispatch_post('/cotisations/:id/edit', 'cotisation_edit');
  function cotisation_edit()
  {
	$webuser = loadWebUser();
	if($webuser->is_anonymous){
		redirect_to('/login'); return;
	}

	$res = false;

    $id = params('id');

    $conn = $GLOBALS['db_connexion'];
    $errors = array();
    $dbController = new DatabaseController($conn, $errors);

    // Load cotisation
    $cotisation = cotisation_load();

    // Load fiscal year list
    $listFiscalYear = null;
    if($res){
        $res = $dbController->getFiscalYearList($listFiscalYear);
    }

    // Save the cotisation
    $res = cotisation_save($dbController, $id, $cotisation);

	if($res){
		if($id == 0){
			$id = $cotisation["id"];
		}
		redirect_to('/cotisations/'.$id);
		return;
	}else{
        set('cotisation', $cotisation);
        set('listFiscalYear', $listFiscalYear);
        set('errors', $errors);

        set('page_title', TS::FiscalYear_EditFiscalYear);
        set('page_submenus', getSubMenus("cotisations"));
        return html('cotisation.html.php');
	}
  }

dispatch('/cotisations/membership', 'cotisation_list_membership');
  function cotisation_list_membership()
  {
	return cotisation_list(true);
  }

dispatch('/cotisations/:id/membership', 'cotisation_membership_list');
  function cotisation_membership_list()
  {
	$webuser = loadWebUser();
	if($webuser->is_anonymous){
		redirect_to('/login'); return;
	}

    $res = true;

    $conn = $GLOBALS['db_connexion'];
    $errors = array();
    $dbController = new DatabaseController($conn, $errors);
    
    $id = params('id');

    // Load cotisation list
    $listMembership = null;
    if($res){
        $res = $dbController->getMembershipListByCotisationId($id, $listMembership);
    }

    if ($res) {
        set('listMembership', $listMembership);

        set('page_title', "Members");
        return html('cotisation.person.list.html.php');
    }

    set('page_title', "Bad request");
    set('errors', $errors);
    return html('error.html.php');
  }


?>
