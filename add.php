<?php 
include_once("connections/connection.php");

$con = connection();

if(isset($_POST['submit'])) {
    $fname = $_POST['first_name'];
    $lname = $_POST['last_name'];
    $gender = $_POST['gender'];

    $sql = "INSERT INTO `student_list`(first_name, last_name, gender) VALUES ('$fname', '$lname', '$gender')";
    $con->query($sql) or die ($con->error);

    echo header("Location: index.php"); 
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="./css/user.css">
    <title>Student Management System</title>
</head>
<body>
    <div class="form_container">
        <h1>Add new data</h1>
        <form action="" method="post">
            <label for="first_name">First Name
                <input type="text" name="first_name" id="first_name" placeholder="Sponge Bob">
            </label>
            <label for="last_name">Last Name
                <input type="text" name="last_name" id="first_name" placeholder="Squarepants">
            </label>
            <label for="gender">Gender
                <div class="custom_select">
                    <select name="gender" id="gender">
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select>
                </div>
            </label>
            <input type="submit" name="submit" value="Submit Form">
        </form>
    </div>
</body>
</html>