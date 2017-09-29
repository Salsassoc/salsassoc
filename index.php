<?php

require_once 'lib/limonade/limonade.php';

require_once 'tools/tools.php';

function configure()
{

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

dispatch('/people', 'list_people');
  function list_people()
  {
       set('page_title', "Login");
   	   return html('people.html.php');
  }

run();

?>
