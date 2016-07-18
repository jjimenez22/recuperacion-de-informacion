<?php
	// functions for cleaning content
	require 'text_processor.php';
	require 'tfidf.php';

	function numerize_query($query) {
		$words = extract_words($query);
		$charvec = array();
		foreach ($words as $word) // for each word in query
		{
			$clean_word = clean_word($word);
			if($clean_word != '')
			{
				if (!empty($charvec) && array_key_exists($clean_word, $charvec)) // has this stem already been counted before?
				{
					$charvec[$clean_word]++; // aparitions of that word
				}else {
					$charvec[$clean_word]=1;
				}
			}
		}
		return $charvec;
	}

	function calculate_weights($tf) {
		$amnt = count($tf); //amount of words in query
		$qdata = json_decode(file_get_contents('qdata.json', true));
		foreach ($tf as $stem => $aprt) {
			$tf[$stem] /= $amnt;
			if (array_key_exists($stem, $qdata['stem'])) {
				$tf[$stem] *= log($qdata['docnum']/$qdata['stem'][$stem]);
			} else {
				$tf[$stem] *= log($qdata['docnum']);
			}
		}
		return $tf;
	}

	function process_query($query) {
		$aprt = numerize_query($query);
		$vec = calculate_weights($aprt);
		$cluster = json_decode(file_get_contents('cluster.json'), true);
		$min = PHP_INT_MAX;

		foreach ($cluster as $i => $centroid) {
			$dist = distance_cos($vec, $centroid['centroid']);
			if ($dist < $min) {
				$min = $dist;
				$mini = $i;
			}
		}
		return $cluster[$mini]['document'];
	}

	$user_query = $_POST['query'];
	$titles = process_query($user_query);
	$documents = json_decode(file_get_contents('shoeablecontent.json'), true);
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
				<h1>News Recovery</h1>
				<a href="index.php">Back to Search Engine</a>
			</div>
			<ul class="">
				<?php
				foreach ($titles as $title => $distance) {
					echo '<a href=\"'.$documents[$title]['link'].'\"><li><h3>'.$title.'</h3><p>'.$documents[$title]['description'].'</p></li></a>';
					echo '<a href=\"show_content.php?title='.$title.'\"><button type=\"button\" name=\"button\">Broken link</button></a>';
				}
				 ?>
			</ul>
	</body>
</html>
