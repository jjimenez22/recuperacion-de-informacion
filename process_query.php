<?php
	require 'update.php';
	require 'tfidf.php';

	if (update_index());
		update_vecs();
	
	$user_query = $_POST['query'];
?>