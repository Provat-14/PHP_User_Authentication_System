<?php 

session_start();
require "db.php";

if (isset($_POST["userId"])){
    $userId = $_POST["userId"];
    if (isset($_POST["pass"])){
        $pass = $_POST["pass"];
        if (!empty($userId) && !empty($pass)) {
            $sql = "SELECT id FROM users_login WHERE userId=? AND password=?";
            $stmt = mysqli_prepare($con, $sql);
            if ($stmt) {
                mysqli_stmt_bind_param($stmt, "ss", $userId, $pass);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_store_result($stmt);
                $test = mysqli_stmt_num_rows($stmt);
                if ($test) {
                    mysqli_stmt_bind_result($stmt, $id);
                    mysqli_stmt_fetch($stmt);
                    $_SESSION['uId'] = $id;
                    $_SESSION['loginTime'] = time();
                    setcookie('login', $id, time() + (86400 * 30), "/");
                    setcookie('login', $id, time() + (86400 * 30), "../");
                    
                    $sql = "SELECT * FROM `users_login` WHERE `id` = $id LIMIT 1";
                    $result = mysqli_query($con, $sql);
                    $data = [];
                    if (mysqli_num_rows($result) == 1) {
                        $row = mysqli_fetch_assoc($result);
                        $data = [
                            "id" => $row["id"],
                            "Name" => $row["name"], 
                            "email" => $row["email"],
                            "userid" => $row["userid"],
                            "sId" => $_SESSION["uId"]
                        ];
                    }
                   exit(json_encode($data));

                }else{                    
                    $error=[
                        'error_code' => 2, 
                        'error_text' => 'invalid userId or password'
                    ];
                    
                    exit(json_encode($error));
                }
                
                mysqli_stmt_close($stmt);
            }else{                        
                $error=[
                    'error_code' => 2, 
                    'error_text' => 'invalid userId or password'
                ];
                
                exit(json_encode($error));
            }
        }else{
            $error=[
                'error_code' => 2, 
                'error_text' => 'Please type all requre data'
            ];
            
            exit(json_encode($error));
        }
    }else{
        $error=[
            'error_code' => 2, 
            'error_text' => 'Please type your valid password'
        ];
        
        exit(json_encode($error));
    }
}else{
    $error=[
        'error_code' => 2, 
        'error_text' => 'Please type your UserId'
    ];
    
    exit(json_encode($error));
}
?>
