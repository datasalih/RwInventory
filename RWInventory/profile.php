<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Inventory Management - Profile</title>
    <style>
      /* CSS for profile page */
      body {
        background-color: #f5f5f5;
        font-family: Arial, sans-serif;
      }
      #profile-container {
    background-color: white;
    border-radius: 10px;
    box-shadow: 0px 0px 10px #888888;
    margin: auto;
    margin-top: 50px;
    padding: 100px;
    width: 600px;
  }

  h1 {
    text-align: center;
    font-size: 25px;
  }

  table {
    border-collapse: collapse;
    margin: auto;
    margin-top: 60px;
    width: 90%;
  }

  th {
    background-color: #f5f5f5;
    border: 1px solid black;
    color: rgb(0, 0, 0);
 
    padding: 22px;
    text-align: left;
  }

  td {
    border: 1px solid black;
    font-weight: bold;
    padding: 22px;
  }

  .btn {
    background-color: #39A4E0;
    border: none;
    border-radius: 5px;
    color: white;
    cursor: pointer;
    padding: 10px;
    margin-top: 50px;
    margin-left: 30px;
  }

  .btn:hover {
    background-color: #49A4E0;
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

  

</style>
<<head>
<!-- Your head content here -->
</head>
<body>
<div id="profile-container">
    <h1>Profile</h1>
    <table>
        <?php
        include("connect.php");

        session_start(); // Start the session
        $company_id = $_SESSION["company_id"];

        $sql = "SELECT * FROM companies WHERE company_id = '$company_id'";
        $result = mysqli_query($connect, $sql);

        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            echo "<tr>";
            echo "<th>Company Name</th>";
            echo "<td>" . $row['company_name'] . "</td>";
            echo "</tr>";
            echo "<tr>";
            echo "<th>Email</th>";
            echo "<td>" . $row['email'] . "</td>";
            echo "</tr>";
        } else {
            echo "<tr><td colspan='2'>No company found</td></tr>";
        }

        mysqli_close($connect);
        ?>
    </table>
    <!--<button >Change Password</button> -->
</div>
<!-- Rest of your body content here -->
</body>

 <!-- Menu Side-->
	
	

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

  
  <script 
  type="text/javascript">

  var dropdown = document.getElementsByClassName("dropdown-toggle");
    var i;
    
    for (i = 0; i < dropdown.length; i++) {
      dropdown[i].addEventListener("click", function() {
        this.classList.toggle("active");
        var dropdownContent = this.nextElementSibling;
        if (dropdownContent.style.display === "block") {
          dropdownContent.style.display = "none";
        } else {
          dropdownContent.style.display = "block";
        }
      });
    }
     
    </script>
    
</body>
</html>