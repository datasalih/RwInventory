<?php
include("connect.php");

if (isset($_POST["report"])) {
    $reportType = $_POST["category"];
    $startDate = $_POST["start-date"];
    $endDate = $_POST["end-date"];

    // Retrieve data from the selected table based on report type and date range
    $table = "";
    $columnNames = "";

    if ($reportType == "purchases") {
        $table = "purchases";
        $columnNames = "customer_name,date,product_name,quantity,purchase_price,status,total";
    } elseif ($reportType == "sales") {
        $table = "sales";
        $columnNames = "product_name,date,quantity,total_price";
    }

    $query = "SELECT $columnNames FROM $table WHERE date BETWEEN '$startDate' AND '$endDate'";

    // Execute the query and fetch data
    $result = mysqli_query($connect, $query);

    // Build the CSV content
    $csvContent = $columnNames . "\n";

    while ($data = mysqli_fetch_assoc($result)) {
        // Escape special characters and enclose values in double quotes
        $rowData = [];
        foreach ($data as $value) {
            $rowData[] = '"' . str_replace('"', '""', $value) . '"';
        }
        $csvContent .= implode(",", $rowData) . "\n";
    }

    // Set the appropriate headers for the file download
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="report.csv"');
    header('Cache-Control: max-age=0');

    // Output the CSV content
    echo $csvContent;
    exit;
}
?>




<!DOCTYPE html>
<html>
<head>
	<title>Select Date Interval</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
	<style>

body {
  font-family: Arial, sans-serif;
  background-color: #f5f5f5;
}
  
        .sidebar {
    
    height: 100%;
   width: 250px;
   position: fixed;
   z-index: 1;
   top: 0;
   left: 0;
   background-color: #111;
   overflow-x: hidden;
   padding-top: 20px;
 
 
       }
 
       .sidebar ul {
         list-style-type: none;
         margin: 10px;
         padding: 10px;
       }
       .sidebar ul li {
         border-bottom: 2px solid #444;
         padding: 15px;
         text-align: center;
       }
 
       .sidebar ul li a {
         color: #fff;
         display: block;
         font-size: 20px;
         text-decoration: none;
       }
 
       .sidebar ul li a:hover {
         background-color: #444;
       }
 
     
       .dropdown-menu
         {
             display: none;
            
               
       
         }


  h1{
    text-align: center;
  }
    
table {
  border-collapse: collapse;
  width: 100%;
  margin-bottom: 30px;
}

th, td {
  padding: 12px;
  text-align: left;
  border-bottom: 1px solid #ddd;
}

th {
  background-color: #f2f2f2;
  font-weight: bold;
}

td img {
  max-width: 100px;
  height: auto;
}

td button {
  padding: 8px 12px;
  border-radius: 5px;
  border: none;
  color: white;
  font-weight: bold;
  cursor: pointer;
}

button {
	background-color: #39A4E0;
	color: white;
	border: none;
	padding: 8px 16px;
	text-align: center;
	text-decoration: none;
	display: inline-block;
	font-size: 22px;
	margin: 4px 2px;
	cursor: pointer;
	border-radius: 4px;
  display: block;
  margin: 0 auto;
}



td.availability.out-of-stock {
  color: red;
}

/* Form styles */
form {
  width: 60%;
  
  margin: 0 auto;
}

label {
			font-weight: bold;
			margin-bottom: 10px;
		}

input[type="text"], select {
  width: 100%;
  padding: 12px;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;
  margin-bottom: 20px;
}

input[type="submit"] {
  background-color: #428bca;
  color: white;
  font-weight: bold;
  padding: 12px 20px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
}

form {
			display: flex;
			flex-direction: column;
			align-items: center;
			margin-top: 50px;
		}
		label {
			font-weight: bold;
			margin-bottom: 10px;
		}
		input[type="submit"] {
			margin-top: 20px;
			padding: 10px;
			border: none;
			background-color: #1E90FF;
			color: #fff;
			font-size: 16px;
			border-radius: 5px;
			cursor: pointer;
		}
	</style>
</head>
<body>
<div class="sidebar">
    <ul>
        <li><a href="dash.php">Dashboard</a></li>
  
        <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            Roles <i class="fa fa-caret-down"></i>
        </a>
        <ul class="dropdown-menu">
            <li><a href="addrole.php">Add Role</a></li>
            <li><a href="manageroles.php">Manage Roles</a></li>
        </ul>
    </li>

    <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            Users <i class="fa fa-caret-down"></i>
        </a>
        <ul class="dropdown-menu">
            <li><a href="adduser.php">Add User</a></li>
            <li><a href="manageuser.php">Manage Users</a></li>
        </ul>
    </li>



    <li><a href="categories.php">Categories</a></li>




    <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            Products <i class="fa fa-caret-down"></i>
        </a>
        <ul class="dropdown-menu">
            <li><a href="addproduct.php">Add Product</a></li>
            <li><a href="manageproduct.php">Manage Products</a></li>
        </ul>
    </li>


    <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            Sales <i class="fa fa-caret-down"></i>
        </a>
        <ul class="dropdown-menu">
            <li><a href="addsales.php">Add Sales</a></li>
            <li><a href="managesales.php">Manage Sales</a></li>
        </ul>
    </li>

    <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            Purchases <i class="fa fa-caret-down"></i>
        </a>
        <ul class="dropdown-menu">
            <li><a href="addpurchases.php">Add Purchase</a></li>
            <li><a href="managepurchases.php">Manage Purchases</a></li>
        </ul>
    </li>


    <li><a href="report.php">Report</a></li>
    <li><a href="profile.php">Profile</a></li>
    <li class="signout"><a href="logout.php"><i class="fa fa-sign-out"></i>Sign Out</a></li>

</ul>

	</div>
	<h1>Select Sale Dates</h1>
  <form action="report.php" method="POST">

  <label for="report-type">Select The Report Type:</label>
  <select id="category" name="category">
    <option value="purchases">Purchases</option>
    <option value="sales">Sales</option>
  </select>

  <label for="start-date">Select a start date:</label>
  <input type="date" id="start-date" name="start-date" required><br><br>

  <label for="end-date">Select an end date:</label>
  <input type="date" id="end-date" name="end-date" required><br><br>

  <button type="submit" name="report" class="btn btn-primary">Show Report</button>
</form>


</body>
</html>