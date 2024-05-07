<?php
include_once("connections/connection.php");
$con = connection();

if(!isset($_SESSION)) {
    session_start();
}

if(isset($_SESSION['UserLogin'])) {
    echo "Welcome " . $_SESSION['UserLogin'];
}else {
    echo "Welcome Guest";
}
$search = $_GET['search'];
$sql = "SELECT * FROM student_list WHERE first_name LIKE '%$search%' || last_name LIKE '%$search%'  ORDER BY id DESC";
$student = $con->query($sql) or die ($con->error); 
$row = $student->fetch_assoc();
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
    <h1>Student Management System</h1>
    <br>
    <br>
    <div class="container">
        <div class="links">
            <?php if(isset($_SESSION['UserLogin'])) {?>
            <a href="logout.php">Logout</a>
            <?php } else {?>
                <a href="login.php">Login</a>
            <?php }?>
            <a href="add.php">Add New</a>
        </div>
        <form action="result.php" method="get">
            <input type="text" name="search" id="search">
            <button type="submit">Search</button>
        </form>
    </div>
    <table>
        <thead>
            <th></th>
            <th>First Name</th>
            <th>Last  Name</th>
            <th>Birthday</th>
            <th>Added At</th>
            <th>Gender</th>
        </thead>
        <tbody>
            <?php do {?>
            <tr>
                <td>
                    <a href="details.php?ID=<?php echo $row['id'];?>">view</a>
                </td>
                <td><?php echo $row['first_name'] ?></td>
                <td><?php echo $row['last_name'] ?></td>
                <td><?php echo $row['birth_day'] ?></td>
                <td><?php echo $row['added_at'] ?></td>
                <td><?php echo $row['gender'] ?></td>
            </tr>
            <?php } while($row=$student->fetch_assoc()) ?>
        </tbody>
    </table>
</body>
</html> 