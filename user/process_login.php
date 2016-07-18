<?php
require 'user_model.php';
if (empty($_POST['username']) || empty($_POST['password']) || !user_exists($_POST['username']) || !correctpss($_POST['username'], $_POST['password'])) {
   header('Location: failed_login.html');
} else {
   session_start();
   $_SESSION['username'] = $_POST['username'];
   $_SESSION['type'] = get_usertype($_POST['username']);
   header('Location: ../index.php');
}
 ?>
