<?php

require_once 'lib/limonade/limonade.php';

require_once 'tools/tools.php';

function before($route)
{
	layout('layout.html.php');
}

dispatch('/', 'index');
  function index()
  {
	$webuser = loadWebUser();
	if($webuser->is_anonymous){
       set('page_title', "Login");
   	   return html('login.html.php');
	}
    set('page_title', "Home");
    return html('index.html.php');
  }
run();

?>
