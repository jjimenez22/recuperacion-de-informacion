<?php
require 'user_model.php';
if (empty($_POST['username']) || empty($_POST['password']) || !user_exists($_POST['username']) || !correctpss($_POST['username'], $_POST['password'])) {
   header('Location: //localhost/recuperacion-de-informacion/user/failed_login.html');
} else {
   session_start();
   $_SESSION['username'] = $_POST['username'];
   $_SESSION['type'] = get_usertype($_POST['username']);
   $filename = 'usrvec/'.$_SESSION['username'].'.json';
   $_SESSION['vec'] = json_decode(file_get_contents($filename), true);
   $_SESSION['recdoc'] = json_decode(file_get_contents('usrdoc/usrdoc.json'), true);
   header('Location: //localhost/recuperacion-de-informacion/index.php');
}
 ?>
