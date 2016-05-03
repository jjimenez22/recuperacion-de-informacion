<?php

   function tf_ifd(&$tfs)
   {
      $docnum = count($tfs); // number of docs
      $idfs = array();

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
   }

   function update_vecs()
   {
      // load persistent data of #aparitions od a word
      $tfs = json_decode(file_get_contents('docsvecs.json'), true);
      tf_ifd($tfs);
      file_put_contents('tfidf.json', json_encode($tfs));

      echo '<table border="1">';
      echo '<tr>';
      echo '<th>doc/stem</th>';
      foreach ($tfs as $doc => $stem_list) {
         foreach ($stem_list as $stem => $n_aparitions) {
            echo '<th>'.$stem.'</th>';
         }
      }
      echo '</th>';
      foreach ($tfs as $doc => $stem_list) {
         echo '<tr>';
         echo '<th>'.$doc.'</th>';
         foreach ($stem_list as $stem => $n_aparitions) {
            echo '<td>'.$n_aparitions.'</td>';
         }
         echo '</tr>';
      }
      echo '</table>';
   }
 ?>
