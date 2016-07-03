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
   }

   function kmeans($tfs)
   {
      $ndocs = count($tfs);
      //$k  = ($ndocs > 10)?floor($ndocs/10):$ndocs; // so there are about 10 docs per centroid
      $k=2;
      $cluster = array();
      $centroids = array();
      $i = 0;
      foreach ($tfs as $doc) // assign the first k docs as centroids
      {
         if ($i >= $k)
            break;

         $centroids[$i] = $doc;

         $i++;
      }

      $iterations=0;
      do
      {
         for ($i=0;$i<$k;$i++)
         {
            $cluster[$i]['centroid']=$centroids[$i];
         }
         foreach ($tfs as $title => $doc)
         {
            $min_distance = array('distance' => PHP_INT_MAX, 'centroid' => 0);
            for ($i=0;$i<$k;$i++)
            {
               $distance = distance_cos($doc, $centroids[$i]);
               if($distance > $min_distance['distance'])
               {
                  $min_distance['distance']=$distance;
                  $min_distance['centroid']=$i;
               }
            }
            $cluster[$min_distance['centroid']]['document'][$title]=$min_distance['distance'];
            erase_from_other($cluster, $min_distance['centroid'], $title);
         }
         recalculate_centroids($centroids, $cluster, $tfs);
         $iterations++;
      } while(has_cluster_changed($cluster, $centroids) && $iterations<100);
      file_put_contents('cluster.json', json_encode($cluster));
   }

   function distance_cos(&$vec1, &$vec2) // calculates the distance between the two vecs
   {
      $already=array();
      $acc=0;

      foreach ($vec1 as $stem => $weight)
      {
         $already[]=$stem;
         if(array_key_exists($stem, $vec2))
         {
            $acc += pow($weight-$vec2[$stem], 2);
         }else
         {
            $acc += pow($weight, 2);
         }
      }
      foreach($vec2 as $stem => $weight)
      {
         if(!array_key_exists($stem, $vec1))
         {
            $acc += pow($weight, 2);
         }
      }
      return $acc;
   }

   function recalculate_centroids(&$centroids, &$cluster, &$docs)
   {
      foreach ($centroids as $i => $centroid)
      {
         foreach ($centroid as $stem => $weight) // initialize new accumulate values
         {
            $centroids[$i][$stem]=0;
            $ndocs[$stem]=0;
         }
         foreach ($cluster[$i]['document'] as $title => $doc) // for each vector
         {
            foreach ($docs[$title] as $stem => $weight) // for each stem in vector
            {
               if (array_key_exists($stem, $centroids[$i]))
               {
                  $centroids[$i][$stem] += $weight;
                  $ndocs[$stem]++;
               } else
               {
                  $centroids[$i][$stem] = $weight;
                  $ndocs[$stem] = 1;
               }
            }
         }
         foreach ($centroids[$i] as $stem => $weight)
         {
            if($ndocs[$stem] !== 0)
            {
               $centroids[$i][$stem] /= $ndocs[$stem];
            }else {
               unset($centroids[$i][$stem]);
            }
         }
      }
   }

   function has_cluster_changed(&$cluster, &$centroids)
   {
      $result = true;
      foreach ($cluster as $i => $centroid)
      {
         $result = ($centroid['centroid'] != $centroids[$i]);
         if($result)
            break;
      }
      return $result;
   }
   
   function erase_from_other(&$cluster, $actual_centroid, $title)
   {
      foreach ($cluster as $i => $centroid)
      {
         if($i === $actual_centroid)
            continue;
            
         if (!empty($cluster[$i]['document']) && array_key_exists($title, $cluster[$i]['document']))
            unset($cluster[$i]['document'][$title]);
      }
   }
 ?>
