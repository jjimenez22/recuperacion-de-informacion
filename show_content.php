<?php
$title $_GET['title'];
$content = json_decode(file_get_contents('showablecontent.json'), true);
$content = $content[$title]['content'];
 ?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Query Response</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
  		<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	</head>
	<body>
		<div class="container">
			<div class="page-header">
				<h1><?php echo $title; ?></h1>
				<a href="index.php">Back to Search Engine</a>
			</div>
         <p>
            <?php echo $content; ?>
         </p>
	</body>
</html>
