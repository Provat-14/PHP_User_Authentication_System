<?php

session_start();
require "backend/db.php";

if (($_SESSION['uId'])==true) {
    echo '<script>localStorage.setItem("sessionID", "' . $_SESSION['uId'] . '");</script>';
   $text = 'wow! you are login successfully';

} else {
    echo '<script>localStorage.removeItem("sessionID");</script>';
    header('location:logout.php');
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="assets/img/favicon.png" type="image/x-icon">
    <title>main page</title>
</head>
<body>
    <h1><?=$text?></h1>
    <button type="submit" name="logout" onclick="logout()">Logout</button>
    <script>
        function logout() {
            localStorage.removeItem('sessionID');         
            var xhr = new XMLHttpRequest();
            xhr.open('GET', 'logout.php', true);
            xhr.onload = function () {
                window.location.href = 'login.html';            
            };
            xhr.send();
        }
    </script>
</body>
</html>