<form method="POST" name="FormLogin" action="<?php echo url_for('/login')?>">
<fieldset>
	<legend>Authentication</legend>

	<label>Username:</label><input type="text" size="10" name="Username" value="admin">
	<br/>
	<label>Password:</label><input type="password" size="10" name="Password" value="password">
	<br/>
	<input type="submit" value="Login">
</fielset>

</form>
