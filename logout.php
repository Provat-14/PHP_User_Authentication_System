<?php
session_start();

session_destroy();
echo '<script>localStorage.removeItem("sessionID");</script>';
header('location:login.html');
exit();
?>
