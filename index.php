<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<title>RI</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
  		<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	</head>
	<body>
		<div class="container">
			<div class="page-header">
				<h1>News Recovery</h1>
				<a href="user/<?php if(isset($_SESSION['username'])): echo 'logout.php\">'.$_SESSION['username'].' LogOut'; else: echo 'login.php\">LogIn'; endif;?></a>
			</div>
			<form role="form" action="process_query.php" method="post">
				<div class="form-group">
					<label for="userQuery">Your Query:</label>
					<input type="text" class="form-control" id="userQuery" name="query"/>
				</div>
				<button type="submit" class="btn btn-success">Search!</button>
			</form>
			<button type="button" class="btn btn-info" onclick="window.open('check_cluster.php', '_blank')">Check Cluster</button>
			<button type="button" class="btn btn-info" onclick="window.open('check_weights.php', '_blank')">Check Weights</button>
			<button type="button" class="btn btn-info" onclick="window.open('setk.php', '_blank')">Set K</button>
		</div>

	</body>
</html>
