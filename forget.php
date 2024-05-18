<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = $_POST['email']; 

    $token = bin2hex(random_bytes(32));

    $_SESSION['reset_token'] = $token;


    $reset_link = "http://example.com/reset_password.php?token=" . $token; // Change example.com to your domain
    $to = $email;
    $subject = "Password Reset Link";
    $message = "Click the following link to reset your password: $reset_link";
    $headers = "From: your@example.com"; // Change your@example.com to your email address or use a valid one

    // Send the email
    mail($to, $subject, $message, $headers);

    // Redirect the user to a confirmation page
    header("Location: confirmation.php");
    exit;
}

// Display the form to request email
?>
<!DOCTYPE html>
<html lang="en">    
    <link rel="stylesheet" href="assets/css/login.css">
    <link rel="shortcut icon" href="assets/img/favicon.png" type="image/x-icon">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>  
<head>
    <meta charset="UTF-8">
    <title>Forgot Password</title>
</head>
<body>
    <div class="box">
        <span class="borderLine"></span>
        <form id="loginForm" style=" padding-top: 30px; "method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <h2><img src="assets/img/favicon.png" alt="" width="100"> </h2>
            <div class="inputBox">
                <input type="email" id="email" name="email" placeholder="Recovery mail" required autocomplete="off">
                <i></i>
            </div>

            <div class="links">
                <a href="login.html">Signin</a>
                <a href="reg.html">Signup</a>
            </div>

            <input type="submit" value="Forget">

        </form>
    </div>  
</body>
</html>
