<?php

require_once 'model/WebUser.php';

function loadWebUser()
{
	if(isset($_SESSION['username'])){
		return new WebUser($_SESSION['username']);
	}
	return new WebUser();
}

?>
