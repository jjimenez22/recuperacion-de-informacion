<?php
   require 'update.php';
   require 'tfidf.php';
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Update</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
  		<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	</head>
	<body>
		<div class="container">
			<div class="page-header">
				<h1>Update</h1>
			</div>
         <?php
         if (update_index()) {
            update_vecs();
            echo '<div class="alert alert-success">Updated documents, recalculated weights and rebuilt cluster</div>';
         } else {
            echo '<div class="alert alert-warning">There was nothing to update</div>';
         }
         ?>
		</div>
	</body>
</html>
