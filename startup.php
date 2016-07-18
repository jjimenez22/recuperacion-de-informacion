<?php
   require 'update.php';
   require 'tfidf.php';

   function startup()
   {
      if (update_index())
         update_vecs();
   }
?>
