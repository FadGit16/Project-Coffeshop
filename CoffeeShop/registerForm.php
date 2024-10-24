<?php

@include 'db_connect.php';

if(isset($_POST['submit'])){

    $name = mysqli_real_escape_string($conn,$_POST['name']);
    $email = mysqli_real_escape_string($conn,$_POST['email']);
    $password = md5($_POST['password']);
    $cpassword = md5($_POST['cpassword']);
    $user_type = $_POST['user_type'];

    $select = "SELECT * FROM `users_form` WHERE email = '$email' && password = '$password'";

    $result = mysqli_query($conn, $select);

    if(mysqli_num_rows($result) > 0){
        $error[] = 'User already exist!';
    }
    else{
        if($password != $cpassword){
            $error[] = 'Password do not match!';
        }
        else{
            $insert = "INSERT INTO users_form(name, email, password, user_type) VALUES ('$name', 
            '$email', '$password', '$user_type')";
            mysqli_query($conn, $insert);
            header('Location: loginForm.php');
        }
    }
};

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Form</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="form_container">
        <form action="" method = "post">
        <h2>Register Now</h2><br>
        <?php
        if(isset($error)){
            foreach($error as $error){
                echo '<span class ="error-msg">'.$error.'</span>';
            };
        };
        ?>
        <input type="text" name="name" required placeholder = "Enter Your Name"> 
        <input type="email" name="email" required placeholder = "Enter Your Email"> 
        <input type="password" name="password" required placeholder = "Enter Your password"> 
        <input type="password" name="cpassword" required placeholder = "Confirm Your password"> 
        <select name="user_type">
            <option value="admin">Admin</option>
            <option value="user">User</option>
            <option value="customer">Customer</option>
        </select>
        <input type="submit" name="submit" value="Register Now" class="form_button">
        <p>Already have an account? <a href="loginForm.php">Login Now</a></p>
        </form>
    </div>
</body>
</html>