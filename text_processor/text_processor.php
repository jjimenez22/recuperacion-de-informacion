<?php
   require 'porter.php';

   $file_content = file_get_contents("../text_processor/stopwords.txt");
   $STOPWORDS = preg_split('/[\s]+/', $file_content, -1, PREG_SPLIT_NO_EMPTY);


   function extract_words($content)
   {
      return preg_split('/[\s]+/', $content, -1, PREG_SPLIT_NO_EMPTY);
   }

   function clean_word($word)
   {
      global $STOPWORDS;

      $word = preg_replace('/[^A-Za-z0-9\-]/', '', $word); // erase special characters
      if($word != '')
      {
         $word = strtolower($word); // to lower
         if(in_array($word, $STOPWORDS)) // is a stop word?
         {
            $word = '';
         }else {
            $word = PorterStemmer::Stem($word); // stemming
         }
      }
      return $word;
   }
?>
