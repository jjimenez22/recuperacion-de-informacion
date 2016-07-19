<?php
session_start();
$filename = 'usrvec/'.$_SESSION['username'].'.json';
file_put_contents($filename, json_encode($_SESSION['vec']));

session_unset();
session_destroy();
header('Location: //localhost/recuperacion-de-informacion/index.php');
 ?>
