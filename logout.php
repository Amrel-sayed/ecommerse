<?php 


session_start(); // must start session in every bage 
session_unset();
session_destroy();

header('location:index.php');
exit();
?>