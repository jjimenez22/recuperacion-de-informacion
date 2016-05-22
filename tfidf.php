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
      kmeans($tfs);

   //    echo '<table border="1">';
   //    echo '<tr>';
   //    echo '<th>doc/stem</th>';
   //  foreach ($tfs as $doc => $stem_list) {
   //        echo '<tr>';
   //       echo '<th>'.$doc.'</th>';
   //       foreach ($stem_list as $stem => $n_aparitions) {
   //          echo '<th>'.$stem.'</th>';
   //       }
   //       echo '</tr>';
   //       echo '<tr>';
   //       echo '<th> -> </th>';
   //       foreach ($stem_list as $stem => $n_aparitions) {
   //          echo '<td>'.$n_aparitions.'</td>';
   //       }
   //       echo '</tr>';
   //    }
   //    echo '</table>';
   }
   
   function kmeans($tfs)
   {
      $ndocs = count($tfs);
      $k  = ($ndocs > 10)?intdiv($ndocs, 10):$ndocs; // so there are about 10 docs per centroid
      $cluster = array();
      $centroids = array();
      $i = 0;
      foreach ($tfs as $doc) // assign the first k docs as centroids
      {
         if ($i >= $k)
            break;
         
         $centroid[$i] = $doc;
         
         $counter++;
      }
      
      foreach ($tfs as $doc)
      {
         for ($i=0;$i<$k;$i++)
         {
            
         }
      }
   }
   
   function distance_cos(&$vec1, &$vec2) // calculates the cosin of the distance between the two vecs
   {
      foreach ($vec1 as $stem => $weight)
      {
         
      }
   }
 ?>
