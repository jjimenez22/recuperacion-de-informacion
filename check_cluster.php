<?php
   include 'startup.php';

   startup();

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

               foreach ($cluster as $i => $centroid)
               {
                  /*echo '
                  <table class="table table-bordered">
                     <thead>
                        <tr>
                           <th>
                              Centroid '.$i.'
                           </th>
                        </tr>
                     </thead>
                     <tr>
                        <th>
                           Stems
                        </th>
                        <th>
                           Weight
                        </th>
                     </tr>';
                  foreach ($centroid['centroid'] as $stem => $weight)
                  {
                     echo '
                     <tr>
                        <td>
                           '.$stem.'
                        </td>
                        <td>
                           '.$weight.'
                        </td>
                     </tr>';
                  }
                     echo '</table>';*/
                     if(array_key_exists('document', $centroid))
                     {
                        
                        echo '<h2>Documents in centroid '.$i.' :</h2>';
                        echo '<table class="table table-bordered>';
                        foreach ($centroid['document'] as $title => $distance)
                        {
                           echo '<tr><td>'.$title.'</td><td>'.$distance.'</td></tr>';
                        }
                        echo '</table>';
                     }
               }
            } else
            {
               echo "<h1>There's no cluster</h1>";
            }
         ?>
      </section>
   </body>
</html>
