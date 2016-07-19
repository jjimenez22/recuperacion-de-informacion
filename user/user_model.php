<?php
function start_model() {
   $con = new mysqli('localhost', 'root', '', 'ri');
   if($con->connect_error)
   {
      die('error: '.$com->connect_error);
   }
   return $con;
}

function user_exists($username) {
   $con = start_model();
   $res = $con->query('select * from user where username = \''.$username.'\'');
   $con->close();
   return ($res->num_rows > 0);
}

function get_usertype($username) {
   $con = start_model();
   $res = $con->query('select type from user where username = \''.$username.'\'');
   $con->close();
   $res = $res->fetch_assoc();
   return $res['type'];
}

function correctpss($usr, $pss) {
   $con = start_model();
   $res = $con->query('select password from user where username = \''.$usr.'\'');
   $con->close();
   return ($res->fetch_assoc()['password']===$pss);
}
 ?>
