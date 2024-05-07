<?php 
include_once("connections/connection.php");

$con = connection();


$id = $_GET['ID'];

$sql = "SELECT * FROM student_list WHERE id='$id'";
$student = $con->query($sql) or die ($con->error); 
$row = $student->fetch_assoc();

if(isset($_POST['submit'])) {
    $fname = $_POST['first_name'];
    $lname = $_POST['last_name'];
    $gender = $_POST['gender'];

    $sql = "UPDATE `student_list` SET first_name = '$fname', last_name = '$lname', gender = '$gender' WHERE id = '$id'";
    $con->query($sql) or die ($con->error);

    echo header("Location: details.php?ID=".$id); 
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="./css/styles.css">
    <title>Student Management System</title>
</head>
<body>
    <div class="form_container">
        <h1>Edit user</h1>
        <form action="" method="post">
            <label for="first_name">First Name
                <input type="text" name="first_name" id="first_name" placeholder="Sponge Bob" value="<?php echo $row['first_name']?>">
            </label>
            <label for="last_name">Last Name
                <input type="text" name="last_name" id="first_name" placeholder="Squarepants" value="<?php echo $row['last_name']?>">
            </label>
            <label for="gender">Gender
                <div class="custom_select">
                    <select name="gender" id="gender">
                        <option value="Male" <?php echo ($row['gender'] == 'Male')? 'selected' : '';?> >Male</option>
                        <option value="Female" <?php echo ($row['gender'] == 'Female')? 'selected' : '';?> >Female</option>
                    </select>
                </div>
            </label>
            <input type="submit" name="submit" value="Update">
        </form>
    </div>
</body>
</html>