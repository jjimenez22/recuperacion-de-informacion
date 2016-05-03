<?php
   $file_content = file_get_contents("text.txt") or die("not openned");
   $words = preg_split('/[\s]+/', $file_content, -1, PREG_SPLIT_NO_EMPTY); //probar esto
   foreach ($words as $word) {
      echo $word.'<br>';
   }
?>
