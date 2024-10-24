<?php

@include 'db_connect.php';

session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

if(isset($_POST['submit'])){

    $email = mysqli_real_escape_string($conn,$_POST['email']);
    $password = md5($_POST['password']);

    $select = "SELECT * FROM `users_form` WHERE email = '$email' && password = '$password'";

    $result = mysqli_query($conn, $select);

    if(mysqli_num_rows($result) > 0){

        $row = mysqli_fetch_array($result);

        if($row['user_type'] == 'admin'){

                $_SESSION['admin_name'] = $row ['name'];
                header('location: admin\admin.php'); 
        }
        elseif($row['user_type'] == 'user'){

            $_SESSION['user_name'] = $row ['name'];
            header('location: user\user.php');
        }
        elseif($row['user_type'] == 'customer'){

            $_SESSION['customer_name'] = $row ['name'];
            header('location: customer\menu.html');
        }
    }
    else{
        $error[] = 'incorrect email or password!'; 
    }
};
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="form_container">
        <form action="" method = "post">
        <h2>Login Now</h2><br>
        <?php
        if(isset($error)){
            foreach($error as $error){
                echo '<span class ="error-msg">'.$error.'</span>';
            };
        };
        ?>
        <input type="email" name="email" required placeholder = "Enter Your Email"> 
        <input type="password" name="password" required placeholder = "Enter Your password"> 
        <input type="submit" name="submit" value="Login Now" class="form_button">
        <p>Don't have an account? <a href="registerForm.php">Register Now</a></p>

        </form>

    </div>
</body>
</html>