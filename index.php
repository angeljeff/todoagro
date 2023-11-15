<?php
session_start();
session_destroy();
header("location:login-todoagro.php");
exit;
?>
