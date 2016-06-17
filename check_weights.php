<?php
   include 'startup.php';

   startup();

   $json_file = file_get_contents('tfidf.json');
?>

<!DOCTYPE html>
<html>
   <head>
      <meta charset="utf-8">
      <title>Vectores caracteristicos</title>
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
                $tfs = json_decode($json_file, true);
                
                echo '<table class="table table-bordered">';
                echo '<tr>';
                echo '<th>doc/stem</th>';
                foreach ($tfs as $doc => $stem_list) {
                    echo '<tr>';
                    echo '<th>'.$doc.'</th>';
                    
                    foreach ($stem_list as $stem => $n_aparitions) {
                        echo '<th>'.$stem.'</th>';
                    }
                    echo '</tr>';
                    echo '<tr>';
                    echo '<th> -> </th>';
                    
                    foreach ($stem_list as $stem => $n_aparitions) {
                        echo '<td>'.$n_aparitions.'</td>';
                    }
                echo '</tr>';
                }
                echo '</table>';
                
            } else
            {
               echo "<h1>There are no documents</h1>";
            }
         ?>
      </section>
   </body>
</html>