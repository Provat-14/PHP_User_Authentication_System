<?php 

session_start();
require "db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate the input
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Check individual fields for errors
    if (empty($name)) {
        $error=[
            'error_code' => 1, 
            'error_text' => 'Name is required!'
        ];
        
        exit(json_encode($error));
    }
    if (empty($email)) { 
        $error=[
            'error_code' => 1, 
            'error_text' => 'Email is required!'
        ];
        
        exit(json_encode($error));
    }else{
        $sql = "SELECT * FROM `users_login` WHERE `email` LIKE '%$email%'";
        $result = mysqli_query($con, $sql); 
        if (mysqli_num_rows($result) > 0) {
            $error=[
                'error_code' => 1, 
                'error_text' => 'this email already exists',
                'error_email' => $email
            ];
            
            exit(json_encode($error));
        }
    }
    if (empty($password)) {
        $error=[
            'error_code' => 1, 
            'error_text' => 'Password is required!'
        ];
        
        exit(json_encode($error));
    }
    if (empty($confirm_password)) {
        $error=[
            'error_code' => 1, 
            'error_text' => 'Confirm Password is required!'
        ];
        
        exit(json_encode($error));
    }
    

    if ($password !== $confirm_password) {        
        $error=[
            'error_code' => 1, 
            'error_text' => 'Passwords do not match'
        ];
        exit(json_encode($error));
    } else {   
        function generateUserID() {
            return mt_rand(100000, 999999);
        }
        do {
            $userid = generateUserID();
            $sql = "SELECT * FROM `users_login` WHERE `userid` = $userid";
            $result = mysqli_query($con, $sql);
        } while (mysqli_num_rows($result) > 0);



        if (!empty($name) && !empty($email) && !empty($password) ) {
            $sql = "INSERT INTO `users_login`( `userid`, `name`, `email`, `password`) VALUES ('$userid','$name',' $email','$password')";
            $result = mysqli_query($con, $sql); 

            $adminsEmail= 'web@arprovat.com';
            $to = $email;
            $subject = $name.' || arprovat github- @Provat-14 ';
            
            $headers = "From: ".$adminsEmail."\r\n";
            $headers .= "Reply-To: ".$adminsEmail."\r\n";
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
            
            $body = "
            <html>
                <head>
                    <title>Your Email Title</title>
                </head>
                <body>            
                    <table style='border: none;'>
                        <tr>
                            <td>Name:</td>
                            <td>".$name."</td>
                        </tr>
                        <tr>
                            <td>userId:</td>
                            <td>".$userid."</td>
                        </tr>
                        <tr>
                            <td>Email:</td>
                            <td>".$email."</td>
                        </tr>
                    </table>
                </body>
            </html>
            ";
            
            if (mail($to, $subject, $body, $headers)) {
                
                exit('success');
            }
            exit('success');
        }else {
            $error=[
                'error_code' => 1, 
                'error_text' => 'something is missing'
            ];
            exit(json_encode($error));
        }
        
    }
    
} else {
    $error=[
        'error_code' => 2, 
        'error_text' => 'Please type all requre data'
    ];
    
    exit(json_encode($error));
}

