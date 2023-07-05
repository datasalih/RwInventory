<?php
include("connect.php");

session_start(); // Start the session

// Fetch company_id from the session
if (isset($_SESSION["company_id"])) {
    $company_id = $_SESSION["company_id"];

    // Fetch data from sales table for the specific company_id
    $sql = "SELECT * FROM sales WHERE company_id = '$company_id'";
    $result = mysqli_query($connect, $sql);

if (isset($_POST["delete_sale"])) {
    $sale_id = $_POST["sale_id"];

    // Retrieve the sale information
    $select_sale = "SELECT * FROM sales WHERE sale_id = '$sale_id'";
    $sale_result = mysqli_query($connect, $select_sale);

    if (mysqli_num_rows($sale_result) > 0) {
        $sale_row = mysqli_fetch_assoc($sale_result);
        $product_name = $sale_row["product_name"];
        $quantity = $sale_row["quantity"];
        $total_price = $sale_row["total_price"];

        // Delete the sale from the sales table
        $delete = "DELETE FROM sales WHERE sale_id = '$sale_id'";
        $delete_result = mysqli_query($connect, $delete);

        if ($delete_result) {
            // Update the product quantity
            $update_product = "UPDATE products SET quantity = quantity + $quantity WHERE product_name = '$product_name'";
            mysqli_query($connect, $update_product);

            // Update the total_sales in the dashboard
            $select_dashboard = "SELECT * FROM dashboard";
            $dashboard_result = mysqli_query($connect, $select_dashboard);

            if (mysqli_num_rows($dashboard_result) > 0) {
                $dashboard_row = mysqli_fetch_assoc($dashboard_result);
                $total_sales = $dashboard_row["total_sales"] - $total_price;

                $update_dashboard = "UPDATE dashboard SET total_sales = '$total_sales'";
                mysqli_query($connect, $update_dashboard);
            }

            echo '<div class="alert alert-success" role="alert">
                    Sale deleted successfully!
                  </div>';
        } else {
            echo '<div class="alert alert-danger" role="alert">
                    Failed to delete sale!
                  </div>';
        }
    } else {
        echo '<div class="alert alert-danger" role="alert">
                Sale not found!
              </div>';
    }
} elseif (isset($_POST["add_sale"])) {
    // Existing code for adding a sale

    // ...
}}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Inventory Management System</title>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

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
    <h1 style="text-align: center; font-weight: bold; font-size:35px;">Manage Sales</h1>
    <a href="addsales.php">
		<button style="margin-left: 290px; margin-bottom: 30px;">Add Sale</button>
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

  
	
	<!--Purchases PAGE-->
	<input type="text" id="search-input" placeholder="Search products...">

	<table>
		<thead>
			<tr>
        
				<th>Sale no.  <img src="images/filter_icon.png" width="10px" style="margin-left:10px;"></th>
        <th>Product name. <img src="images/filter_icon.png" width="10px" style="margin-left:10px;"></th>
				<th>Quantity <img src="images/filter_icon.png" width="10px" style="margin-left:10px;"></th>
				<th>Total Price <img src="images/filter_icon.png" width="10px" style="margin-left:10px;"></th>
				<th>Date Time <img src="images/filter_icon.png" width="10px" style="margin-left:10px;"></th>
				
				
				<th>Actions</th>
			</tr>
		</thead>
		<tbody>
		<?php
    $sql = "SELECT * FROM sales where company_id = $company_id";
    $result = mysqli_query($connect, $sql);

    if (mysqli_num_rows($result) > 0) {
      $count = 1;
      while ($row = mysqli_fetch_assoc($result)) {
        $id =  $row["sale_id"];
        echo "<td>" . $row["sale_id"] . "</td>";
        echo "<td>" . $row["product_name"] . "</td>";
        echo "<td>" . $row["quantity"] . "</td>";
        echo "<td>" . $row["total_price"] . "$</td>";
        echo "<td>" . $row["date"] . "</td>";
        echo "<td>";
        echo "<a href='editsales.php?id=" . urlencode($id) . "''><button>Edit</button></a>";
       
        echo "<form action='managesales.php' method='POST' style='display:inline;'>
        <input type='hidden' name='sale_id' value='" . $row["sale_id"] . "'>
        <button type='submit' name='delete_sale' style='background-color:red;'>Remove</button>
      </form>";

        echo "</td>";
        echo "</tr>";
        $count++;
      }
    } else {
      echo "<tr><td colspan='7'>No Sales Found</td></tr>";
    }
    mysqli_close($connect);

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