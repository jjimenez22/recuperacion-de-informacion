<?php
	require 'update.php';
	require 'tfidf.php';

	update_index();
	update_vecs();
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<title>RI</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
  		<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	</head>
	<body>
		<div class="container">
			<div class="page-header">
				<h1>News Recovery</h1>
			</div>
			<form role="form">
				<div class="form-group">
					<label for="userQuery">Your Query:</label>
					<input type="text" class="form-control" id="userQuery"/>
				</div>
				<button type="submit" class="btn btn-default">Search!</button>
			</form>
		</div>
		
	</body>
</html>
