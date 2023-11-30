<?php session_start();
if (isset($_SESSION['un']))
{
   unset($_SESSION['un']);
   session_destroy();
   header('Location: Login.php');
}
exit();