<?php

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
