
<?php
include("connect.php");

$sql = "SELECT * FROM products";
$result = mysqli_query($connect, $sql);

if (isset($_POST["add_purchase"])) {
    $customer_name = $_POST["customer_name"];
    $date = $_POST["date"];
    $product_name = $_POST["product_name"];
    $quantity = $_POST["quantity"];
    $paid_status = $_POST["status"];
    $purchase_price = $_POST["purchase_price"];

    if (isset($customer_name) && isset($date) && isset($product_name) && isset($quantity) && isset($paid_status) && isset($purchase_price)) {
        // Check if product exists
        $select_product = "SELECT * FROM products WHERE product_name = '$product_name'";
        $product_result = mysqli_query($connect, $select_product);

        if (mysqli_num_rows($product_result) > 0) {
            // Get the product information
            $product_row = mysqli_fetch_assoc($product_result);
            $product_id = $product_row["product_id"];

            // Calculate the purchase total
            $total = $purchase_price * $quantity;

            // Get the company_id from the session
            session_start(); // Start the session
            $company_id = $_SESSION["company_id"];

            // Insert the purchase into the purchases table with company_id
            $insert = "INSERT INTO purchases (customer_name, product_name, date, quantity, purchase_price, total, status, company_id) 
                       VALUES ('$customer_name', '$product_name', '$date', $quantity, $purchase_price, $total, '$paid_status', '$company_id')";
            $insert_result = mysqli_query($connect, $insert);

            if ($insert_result) {
                // Update the product quantity
                $new_quantity = $product_row["quantity"] + $quantity;
                $update = "UPDATE products SET quantity = $new_quantity WHERE product_id = $product_id";
                $update_result = mysqli_query($connect, $update);

                if ($update_result) {
                    echo '<div class="alert alert-success" role="alert">
                            Purchase added successfully!
                          </div>';

                    // Update the total_purchases and balance in the dashboard
                    $select_dashboard = "SELECT * FROM dashboard";
                    $dashboard_result = mysqli_query($connect, $select_dashboard);

                    if (mysqli_num_rows($dashboard_result) > 0) {
                        $dashboard_row = mysqli_fetch_assoc($dashboard_result);
                        $total_purchases = $dashboard_row["total_purchases"] + $total;

                        $update_dashboard = "UPDATE dashboard SET total_purchases = $total_purchases WHERE company_id = '$company_id'";
                        mysqli_query($connect, $update_dashboard);
                    }
                } else {
                    echo '<div class="alert alert-danger" role="alert">
                            Failed to update product quantity!
                          </div>';
                }
            } else {
                echo '<div class="alert alert-danger" role="alert">
                        Failed to add purchase!
                      </div>';
            }
        } else {
            echo '<div class="alert alert-danger" role="alert">
                    Product does not exist!
                  </div>';
        }
    }
}

mysqli_close($connect);
?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

	<title>RW Inventory</title>
</head>

<style>
    /* Table styles */

    body {
  font-family: Arial, sans-serif;
  background-color: #f5f5f5;
}
  .alert {
  padding: 10px;
  margin-bottom: 15px;
  border: 1px solid transparent;
  border-radius: 4px;
	 margin-left:14%;
	  width: 85%;
	  padding-top:10px;
}

.alert-success {
  color: #155724;
  background-color: #d4edda;
  border-color: #c3e6cb;
	
	height: 40px;
}

.alert-danger {
  color: #721c24;
  background-color: #f8d7da;
  border-color: #f5c6cb;
	height: 40px;
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

td button.edit {
  background-color: #428bca;
  margin-right: 10px;
}

td button.remove {
  background-color: #d9534f;
}

td.availability {
  font-weight: bold;
  color: green;
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
  display: block;
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



</style>

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
    <li class="signout"><a href="login.php"><i class="fa fa-sign-out"></i>Sign Out</a></li>

</ul>

	</div>

	<h1>Add Purchase</h1>
<form action="addpurchases.php" method="POST">

    <label for="customer-name">Customer/Supplier Name:</label>
    <input type="text" id="customer-name" name="customer_name" required><br><br>

    <label for="customer-address">Customer/Supplier Address:</label>
    <input type="text" id="customer-address" name="customer_address" required><br><br>

    <label for="date">Date:</label>
    <input type="date" id="date" name="date" required><br><br>

    <label for="product">Product:</label>
    <select name="product_name" id="product" title="Product" aria-placeholder="Choose Product" required>
        <option value="" disabled selected>Select Product</option>

        <?php
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<option value='" . $row["product_name"] . "'>" . $row["product_name"] . "</option>";
            }
        } else {
            echo "<option value='' disabled>No product found</option>";
        }
        ?>
    </select><br><br>

    <label for="quantity">Quantity:</label>
    <input type="text" id="quantity" name="quantity" required><br><br>

    <label for="purchase-price">Purchase Price:</label>
    <input type="text" id="purchase-price" name="purchase_price" required><br><br>

    <label for="paid-status">Paid Status:</label>
    <input type="radio" id="paid-status-paid" name="status" value="paid" style="display: inline-block;" required>
    <label for="paid-status-paid" style="display: inline-block;">Paid</label>
    <input type="radio" id="paid-status-notpaid" name="status" value="notpaid" style="display: inline-block;" required>
    <label for="paid-status-notpaid" style="display: inline-block;">Not Paid</label><br><br>

    <button type="submit" name="add_purchase" class="btn btn-primary">Add Purchase</button>
</form>


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
