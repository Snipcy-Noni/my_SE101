<?php
include_once("connections/connection.php");
$con = connection();

if(!isset($_SESSION)) {
    session_start();
}

if(isset($_POST['login'])) {
    $username  = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM student_user WHERE username = '$username' AND password = '$password'";

    $user = $con->query($sql) or die($con->error);
    $row = $user->fetch_assoc();
    $total = $user->num_rows;

    if($total > 0) {
        $_SESSION['UserLogin'] = $row['username'];
        $_SESSION['Access'] = $row['access'];

        echo header("Location: index.php");
    }else {
        echo "No user found.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible"  content="ie=edge">
    <link rel="stylesheet" href="./css/styles.css">
    <title>Student Management System</title>
    <style>
        body {
            background-image: linear-gradient(to right, black, white);
        }
    </style>
</head>
<body>
        <div class="form_container">
            <h1>Login Page</h1>
            <br>
            <div class="img-container">
                <img src="./images/cat.png" alt="">
            </div>
            <form action="" method="POST">
                <label for="username">Username
                    <input type="text" name="username" id="username" placeholder="Bobthebuilder00312" autocomplete="off">
                </label>
                <label for="password">Password
                    <input type="password" name="password" id="password" placeholder="12345" autocomplete="off">
                </label>
                <button type="submit" name="login">Login</button>
            </form>
        </div>
</body>
</html>