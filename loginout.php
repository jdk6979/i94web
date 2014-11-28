<?php
unset($_SESSION['login']);
// setcookie('login','',time()-1);
header("location:index.php");
?>