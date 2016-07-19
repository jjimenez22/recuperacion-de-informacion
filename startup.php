<?php
   require 'update.php';
   require 'tfidf.php';

   if (update_index())
      update_vecs();
   header('Location: index.php');
?>
