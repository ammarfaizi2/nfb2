<!DOCTYPE html>
<html>
<head>
	<title>New User</title>
</head>
<body>
<center>
		<form method="post" action="<?php print router_url()."/newuser/create_new_user" ?>">
			<label>Username : </label><br>
			<input required type="text" name="username"><br><br>
			<label>Email : </label><br>
			<input required type="text" name="email"><br><br>
			<label>Password</label><br>
			<input required type="password" name="password"><br><br>
			<input required type="submit" name="Submit" value="Submit">
		</form>
</center>
</body>
</html>