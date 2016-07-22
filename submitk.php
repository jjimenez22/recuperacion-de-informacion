<?php

    require 'tfidf.php';

    $kfile = fopen('kfile.txt', 'w');
    $k=$_POST['k'];
    fwrite($kfile, $k);
    fclose($kfile);
    kmeans();
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Set K</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
  		<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	</head>
	<body>
		<div class="container">
			<div class="page-header">
				<h1>Set K</h1>
			</div>
            <div class="alert alert-success">
                Number of centroids set to <?php echo $k; ?> and cluster rebuilt
            </div>
		</div>
	</body>
</html>
