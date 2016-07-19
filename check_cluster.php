<?php

   // include 'startup.php';
   //
   // startup();

   $json_file = file_get_contents('cluster.json');
?>

<!DOCTYPE html>
<html>
   <head>
      <meta charset="utf-8">
      <title>Cluster</title>
      <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
      <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
   </head>
   <body>
      <section class="container-fluid">
         <!--<button type="button" name="button"></button>-->
      </section>
      <section class="container">
         <?php
            if ($json_file !== false)
            {
               $cluster = json_decode($json_file, true);

               foreach ($cluster as $i => $centroid) {
                  if ($centroid['ignore']) {
                     continue;
                  }

                  echo '<h4>centroid '.$i.':</h4><br>';
                  echo 'Vector:<br>';
                  echo '<table class="table table-bordered">';
                  echo '<tr>';
                  foreach ($centroid['centroid'] as $stem => $weight) {
                     echo '<th>'.$stem.'</th>';
                  }
                  echo '</tr>';
                  echo '<tr>';
                  foreach ($centroid['centroid'] as $stem => $weight) {
                     echo '<td>'.$weight.'</td>';
                  }
                  echo '</tr>';
                  echo '</table>';

                  echo '<hr>Documents:<br>';
                  echo '<table class="table table-bordered">';
                  foreach ($centroid['document'] as $title => $weight) {
                     echo '<tr>';
                     echo '<th>'.$title.'</th><td>'.$weight.'</td>';
                     echo '</tr>';
                  }
                  echo '</table>';
                  echo '<hr>';
               }
            } else
            {
               echo "<h1>There's no cluster</h1>";
            }
         ?>
      </section>
   </body>
</html>
