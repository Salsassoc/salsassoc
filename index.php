<?php

require_once 'lib/limonade/lib/limonade.php';

require_once 'tools/tools.php';

require_once 'model/OperationMethod.php';

require_once 'controllers/PersonController.php';
require_once 'controllers/MembershipController.php';
require_once 'controllers/CotisationsController.php';
require_once 'controllers/FiscalYearController.php';
require_once 'controllers/AccountingAccountController.php';
require_once 'controllers/AccountingOperationCategoryController.php';
require_once 'controllers/AccountingController.php';

// Setup locale
$lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
$acceptLang = ['fr', 'en']; 
$lang = in_array($lang, $acceptLang) ? $lang : 'en';
require_once "ts/ts_{$lang}.php";
require_once "ts/ts_helper.php";


function getSubMenus($menu)
{
	$submenus = array();
	if($menu == "members"){
		$submenus["/members"] = TS::Person_CurrentMembers;
		$submenus["/members/all"] = TS::Person_AllMembers;
		$submenus["/members/add"] = TS::Person_AddMember;
	}
	if($menu == "memberships"){
		$submenus["/memberships"] = TS::Membership_MembershipAll;
		$submenus["/memberships/add"] = TS::Membership_AddMembership;
	}
	if($menu == "cotisations"){
		$submenus["/cotisations"] = TS::Cotisation_CotisationAll;
		$submenus["/cotisations/membership"] = TS::Cotisation_CotisationMembership;
	}
	if($menu == "accounting"){
		$submenus["/accounting/operations"] = TS::Accounting_OperationAll;
		$submenus["/accounting/accounts"] = TS::Accounting_Accounts;
		$submenus["/accounting/accounts/add"] = TS::Accounting_AccountAdd;
		$submenus["/accounting/operationcategories"] = TS::Accounting_OperationCategoryList;
		$submenus["/accounting/operationcategories/add"] = TS::Accounting_OperationCategoryAdd;
	}
	if($menu == "fiscalyears"){
		//$submenus["/fiscalyears"] = TS::FiscalYears_FiscalYears;
	}
	return $submenus;
}

function configure()
{
/*
    $env = $_SERVER['HTTP_HOST'] == "localhost" ? ENV_DEVELOPMENT : ENV_PRODUCTION;

    option('env', $env);
    if(option('env') > ENV_PRODUCTION)
	{
		options('dsn', 'sqlite:db/db.sqlite'));
	}
	else
	{
	    options('dsn', 'sqlite:db/db.sqlite'));
	}
*/
	option('dsn', 'sqlite:db/db.sqlite');
    $GLOBALS['db_connexion'] = new PDO(option('dsn'));
}

function before($route)
{
	layout('layout.html.php');
}

dispatch('/', 'index');
  function index()
  {
	$webuser = loadWebUser();
	if($webuser->is_anonymous){
		redirect_to('/login'); return;
	}
    set('page_title', "Home");
    return html('index.html.php');
  }

dispatch('/login', 'login');
dispatch_post('/login', 'login');
  function login()
  {
	if(isset($_POST['Username'])){
		$_SESSION['username'] = $_POST['Username'];
		redirect_to('/');
	}else{
       set('page_title', "Login");
   	   return html('login.html.php');
	}
  }

dispatch('/logout', 'logout');
  function logout()
  {
	if(isset($_SESSION['username'])){
		unset($_SESSION['username']);
	}
	redirect_to('/');
  }

dispatch('/style.css', 'getcss');
function getcss()
{
    return css('style.css.php', null);
}

dispatch('/print.css', 'getprintcss');
function getprintcss()
{
    return css('print.css.php', null);
}

run();

?>
