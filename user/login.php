<?php
session_start();
if (isset($_SESSION['username'])){
	header('Location: //localhost/recuperacion-de-informacion/index.php');
}
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<title>RI login</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
  		<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	</head>
	<body>
		<div class="container">
			<div class="page-header">
				<h1>Log In</h1>
			</div>
			<form role="form" action="//localhost/recuperacion-de-informacion/user/process_login.php" method="post">
				<div class="form-group">
					<label for="user">Username:</label>
					<input type="text" class="form-control" id="user" name="username"/>
				</div>
				<div class="form-group">
					<label for="psswrd">Password:</label>
					<input type="password" class="form-control" id="psswrd" name="password"/>
				</div>
				<button type="submit" class="btn btn-success">LogIn!</button>
			</form>
		</div>
	</body>
</html>
