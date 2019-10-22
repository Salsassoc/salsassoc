<?php

require_once 'model/WebUser.php';

function loadWebUser()
{
	if(isset($_SESSION['username'])){
		return new WebUser($_SESSION['username']);
	}
	return new WebUser();
}

function findItemInListById($list, $key, $value)
{
    foreach($list as $item)
    {
        if($item[$key] == $value){
            return $item;
        }
    }
    return null;
}

?>
