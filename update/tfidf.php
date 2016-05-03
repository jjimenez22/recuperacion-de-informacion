<?php

   // load persistent data of #aparitions od a word
   $tfs = json_decode(file_get_contents('docsvecs.json'), true);

   $docnum = count($tfs); // number of docs

   
   foreach ($tfs as $doc => $stemvec) {
      $stemnum = count($stemvec); // number of stems in a doc

      foreach ($stemvec as $stem => $num) {
         $tfs[$doc][$stem] /= $stemnum;

         if ($idfs != NULL && array_key_exists($stem, $idfs)) {
            $idfs[$stem]++;
         } else {
            $idfs[$stem] = 1;
         }
      }
   }

   foreach ($idfs as $stem => $ndocs) {
      $idfs[$stem] = log($docnum/$ndocs);
   }

   foreach ($tfs as $doc => $stemvec) {

      foreach ($stemvec as $stem => $num) {

         $tfs[$doc][$stem] *= $idfs[$stem];
      }
   }

   file_put_contents('tfidf.json', json_encode($tfs));

 ?>
