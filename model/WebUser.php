<?php
	class WebUser
	{
		public $is_anonymous = true;
		public $username = null;

		function __construct($username = null)
		{
			$this->is_anonymous = ($username == null);
			$this->username = $username;
		}
	}
?>
