<?php
	class Person
	{
		public $firstname = null;
		public $lastname = null;

		function __construct($username = null)
		{
			$this->is_anonymous = ($username == null);
			$this->username = $username;
		}
	}
?>
