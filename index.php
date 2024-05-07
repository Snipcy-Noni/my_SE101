<?php
include_once("connections/connection.php");
$con = connection();

if (!isset($_SESSION)) {
    session_start();
}

if (isset($_SESSION['UserLogin'])) {
    echo "Welcome " . $_SESSION['UserLogin'];
} else {
    echo "Welcome Guest";
}

//get page number
if (isset($_GET['page_no']) && $_GET['page_no'] !== "") {
    $page_no = $_GET['page_no'];
} else {
    $page_no = 1;
}
if (isset($_POST['rows_per_page'])) {
    $total_records_per_page = $_POST['rows_per_page'];
} else {
    // Default number of rows per page
    $total_records_per_page = 5;
}

//get the page offset for LIMIT query
$offset = ($page_no - 1) * $total_records_per_page;

//get previous page
$previous_page = $page_no - 1;

//get next page 
$next_page = $page_no + 1;

$sql = "SELECT * FROM student_db.student_list  ORDER BY id ASC LIMIT $offset, $total_records_per_page";
$student = $con->query($sql) or die($con->error);
$row = $student->fetch_assoc();


//get the total count of records
$result_count = mysqli_query($con, "SELECT COUNT(*) as total_records FROM student_db.student_list") or die(mysqli_error($conn));
//total records
$records = mysqli_fetch_array($result_count);
//store total_records to variable
$total_records = $records['total_records'];
//get the total pages
$total_no_of_pages = ceil($total_records / $total_records_per_page);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="./bootstrap-offlinecss/css/bootstrap.css">
    <script src="./bootstrap-offlinejs/js/jquery-3.6.0.js"></script>
    <script src="./bootstrap-offlinejs/js/bootstrap.js"></script>
    <link rel="stylesheet" href="./css/styles.css">
    <title>Student Management System</title>
</head>

<body>
    <h1>Student Management System</h1>
    <br>
    <br>
    <div class="container-fluid d-flex justify-content-between align-items-center p-0 mb-2">
        <div class="links">
            <?php if (isset($_SESSION['UserLogin'])) { ?>
                <a href="logout.php" class="btn btn-sm">Logout</a>
            <?php } else { ?>
                <a href="login.php" class="btn btn-sm">Login</a>
            <?php } ?>
            <a href="add.php" class="btn btn-sm">Add New</a>
        </div>
        <!-- <form action="" method="get">
                <div class="input-group-sm">
                    <label for="num-rows"></label>
                    <input type="number" name="num-rows" id="num-rows" class="form-control" >
                </div>
            </form> -->

        <form method="POST" action="" id="myForm" oninput="changeRowNumber()">
            <input type="hidden" id="rows_per_page_hidden" name="rows_per_page_hidden">
            <label for="rows_per_page">Rows per page:</label>
            <select name="rows_per_page" id="rows_per_page" class="btn btn-primary btn-sm">
                <option value="5" <?php if ($total_records_per_page == 5) echo "selected"; ?>>5</option>
                <option value="10" <?php if ($total_records_per_page == 10) echo "selected"; ?>>10</option>
                <option value="20" <?php if ($total_records_per_page == 20) echo "selected"; ?>>20</option>
                <!-- Add more options as needed -->
            </select>
            <!-- <input type="submit" value="Apply"> -->
        </form>

        <form action="" method="get">
            <div class="input-group-sm">
                <input type="text" name="search" id="search" placeholder="Search" class="form-control">
            </div>
            <!-- <button type="submit">Search</button> -->
        </form>
    </div>
    <table>
        <thead>
            <th></th>
            <th>ID</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Gender</th>
        </thead>
        <tbody>
            <?php do { ?>
                <tr>
                    <td>
                        <a href="details.php?ID=<?php echo $row['id']; ?>" class="btn btn-sm">view</a>
                    </td>
                    <td><?php echo $row['id'] ?></td>
                    <td><?php echo $row['first_name'] ?></td>
                    <td><?php echo $row['last_name'] ?></td>
                    <td><?php echo $row['gender'] ?></td>
                </tr>
            <?php } while ($row = $student->fetch_assoc()) ?>
        </tbody>
    </table>
    <nav aria-label="Page navigation example" class="d-flex justify-content-between align-items-center mt-2">

        <ul class="pagination pagination-sm mt-3">
            <li class="page-item"><a class="page-link <?= ($page_no <= 1) ? 'disable' : '' ?>" <?= ($page_no > 1) ? 'href=?page_no=' . $previous_page : '' ?>>Previous</a></li>

            <?php
            // Always add the first page
            if ($page_no > 5) {
                echo '<li class="page-item"><a class="page-link" href="?page_no=1">1</a></li>';
                echo '<li class="page-item"><a class="page-link">...</a></li>';
            }

            // Add the pages
            for ($counter = max(1, $page_no - 4); $counter <= min($total_no_of_pages, $page_no + 4); $counter++) {
                if ($page_no != $counter) {
                    echo '<li class="page-item"><a class="page-link" href="?page_no=' . $counter . '">' . $counter . '</a></li>';
                } else {
                    echo '<li class="page-item active"><a class="page-link">' . $counter . '</a></li>';
                }
            }

            // Always add the last page
            if ($page_no < $total_no_of_pages - 4) {
                echo '<li class="page-item"><a class="page-link">...</a></li>';
                echo '<li class="page-item"><a class="page-link" href="?page_no=' . $total_no_of_pages . '">' . $total_no_of_pages . '</a></li>';
            }
            ?>

            <li class="page-item"><a class="page-link <?= ($page_no >= $total_no_of_pages) ? 'disable' : '' ?>" <?= ($page_no < $total_no_of_pages) ? 'href=?page_no=' . $next_page : '' ?>>Next</a></li>
        </ul>
        <div class="p-10">
            <strong>Page <?= $page_no; ?> of <?= $total_no_of_pages; ?></strong>
        </div>
    </nav>

    <script>
        // function changeRowNumber() {
        //     var form = document.getElementById("myForm"); 
        //     form.submit();
        // }

        document.getElementById("rows_per_page").addEventListener("change", function() {
            // Get the value of the selected option
            var selectedRowsPerPage = this.value;

            // Get the form element
            var form = document.getElementById("myForm");

            // Set the value of the hidden input field to the selected option
            document.getElementById("rows_per_page_hidden").value = selectedRowsPerPage;

            // Submit the form
            form.submit();
        });

        document.getElementById("search").addEventListener("input", function() {
            // Get the value of the search input
            var searchText = this.value.toLowerCase();

            // Get all rows of the table
            var rows = document.querySelectorAll("tbody tr");

            // Loop through each row and check if it matches the search text
            rows.forEach(function(row) {
                // Get the columns within the row
                var columns = row.getElementsByTagName("td");

                var found = false;

                // Loop through each column
                Array.from(columns).forEach(function(column) {
                    // Check if the column contains the search text
                    if (column.textContent.toLowerCase().includes(searchText)) {
                        found = true;
                    }
                });

                // Show or hide the row based on the search result
                if (found) {
                    row.style.display = "";
                } else {
                    row.style.display = "none";
                }
            });
        });


        function changePageSize(size) {
            // Redirect to the first page when changing page size
            window.location.href = "?page_no=1&size=" + size;
        }
    </script>
</body>

</html>