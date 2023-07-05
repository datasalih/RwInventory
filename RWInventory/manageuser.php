<?php
include("connect.php");

session_start(); // Start the session

// Fetch data from user table for a specific company_id
$company_id = $_SESSION["company_id"]; // Assuming you have the company_id stored in the session

$sql = "SELECT * FROM user WHERE company_id = '$company_id'";
$result = mysqli_query($connect, $sql);

// Delete category if remove button is clicked
if (isset($_POST['delete_user'])) {
    $user_id = $_POST['user_id'];

    $delete = "DELETE FROM user WHERE user_id = '$user_id'";
    $delete_result = mysqli_query($connect, $delete);

    $update_dashboard = "UPDATE dashboard SET total_members = total_members - 1";
          mysqli_query($connect, $update_dashboard);

    if ($delete_result) {
        // Category deleted successfully
        header("Location: manageuser.php"); // Redirect to the categories page to reflect the changes
        exit();
    } else {
        echo '<div class="alert alert-danger" role="alert">
            Failed to delete role!
            </div>';
    }
}

?>

<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

	<title>Inventory Management System</title>

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
		
		
		
		
		
	/* Style for sales page */

		
		.container{
			
			background-color:white;
			margin-left:290px;
			margin-right:30px;
			margin-top:2px;
		}
		
	body {
	font-family: Arial, sans-serif;
	background-color:#e7e7e7;
}

h1 {
	text-align: center;
}

table {
	margin: auto;
	border-collapse: collapse;
	width: 100%;
}

th, td {
	padding: 8px;
	text-align: left;
	border-bottom: 1px solid #ddd;
}

th {
	background-color: #f2f2f2;
	color: #333;
}

button {
	background-color: #39A4E0;
	color: white;
	border: none;
	padding: 8px 16px;
	text-align: center;
	text-decoration: none;
	display: inline-block;
	font-size: 14px;
	margin: 4px 2px;
	cursor: pointer;
	border-radius: 4px;
}

button:hover {
	background-color: #49A4E0;
}
		
		#search-input {
  background-image: url('/css/searchicon.png'); /* Add a search icon to input */
  background-position: 10px 12px; /* Position the search icon */
  background-repeat: no-repeat; /* Do not repeat the icon image */
  width: 95%; /* Full-width */
  font-size: 16px; /* Increase font-size */
  padding: 12px 20px 12px 40px; /* Add some padding */
  border: 0px solid #ddd; /* Add a grey border */
  margin-bottom: 12px; /* Add some space below the input */
}
	</style>
</head>
<body>
	
  
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
  
    
    
	
	<div class="headerl">
    <h1 style="text-align: center; font-weight: bold; font-size:35px;">Manage Users</h1>
    <a href="adduser.php">
		<button style="margin-left: 290px; margin-bottom: 30px;">Add User</button>
	  </a>

    <div style="clear: both;"></div>
    <hr style="margin-top:-15px; margin-bottom: 5px;">
  </div>
  <div class="container">
	
	
    <div id="add-category-popup" style="display: none;">
      <form>
        <label for="category-name">Category Name:</label>
        <input type="text" id="category-name" name="category-name"><br><br>
        <button type="submit" id="submit-category" style="background-color: blue; color: white; border: none; padding: 10px 20px; border-radius: 5px;">Submit</button>
      </form>
    </div>

  
	<input type="text" id="search-input" placeholder="Search products...">
	 
    <table>
	<thead>
		<tr>
			<th># <img src="images/filter_icon.png" width="10px" style="margin-left:10px;"></th>
		
			<th>Email <img src="images/filter_icon.png" width="10px" style="margin-left:10px;"></th>
			<th>Name <img src="images/filter_icon.png" width="10px" style="margin-left:10px;"></th>
			<th>Phone <img src="images/filter_icon.png" width="10px" style="margin-left:10px;"> </th>
			<th>Role <img src="images/filter_icon.png" width="10px" style="margin-left:10px;"></th>
			<th>Actions</th>
		</tr>
	</thead>
	<tbody>
		<?php
     $sql = "SELECT * FROM user where company_id = $company_id";
     $result = mysqli_query($connect, $sql);
		if (mysqli_num_rows($result) > 0) {
			$count = 1;
			while ($row = mysqli_fetch_assoc($result)) {
        $id =  $row["user_id"];
				echo "<tr>";
				echo "<td>" . $count . "</td>";
				echo "<td>" . $row["email"] . "</td>";
				echo "<td>" . $row["name"] . "</td>";
				echo "<td>" . $row["phone"] . "</td>";
				echo "<td>" . $row["role"] . "</td>";
				echo "<td>";
				echo "<a href='edituser.php?id=" . urlencode($id) . "''><button>Edit</button></a>";
				
        echo "<form action='manageuser.php' method='POST' style='display:inline;'>
        <input type='hidden' name='user_id' value='" . $row["user_id"] . "'>
        <button type='submit' name='delete_user' style='background-color:red;'>Remove</button>
      </form>";

				echo "</td>";
				echo "</tr>";
				$count++;
			}
		} else {
			echo "<tr><td colspan='7'>No users found</td></tr>";
		}
		?>
	</tbody>
</table>
 <script src="filtering.js"></script>
<script src="search.js"></script>
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
     
    const addCategoryBtn = document.getElementById("add-category-btn");
  const addCategoryPopup = document.getElementById("add-category-popup");

  // show the popup when the "Add Categories" button is clicked
  addCategoryBtn.addEventListener("click", () => {
    addCategoryPopup.style.display = "block";
  });

  // hide the popup when the "Submit" button is clicked
  const submitCategoryBtn = document.getElementById("submit-category");
  submitCategoryBtn.addEventListener("click", () => {
    addCategoryPopup.style.display = "none";
  });

    </script>

</body>
</html>