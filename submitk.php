<?php 

    $kfile = fopen('kfile.txt', 'w');
    $k=$_POST['k'];
    fwrite($kfile, $k);
    fclose($kfile);

?>

<h3>Done</h3>