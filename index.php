<?php

require_once 'lib/limonade/lib/limonade.php';

require_once 'tools/tools.php';

require_once 'controllers/PersonController.php';

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

run();

?>
