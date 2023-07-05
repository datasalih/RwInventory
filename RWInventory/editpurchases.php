<?php
      if (!isset($_GET['id']))
      {
        die('Id not provided');
      }
    require_once('connect.php');
    $id = $_GET["id"];

    

      $sql = "SELECT * FROM purchases WHERE purchase_id = ?";
      $stmt = $connect->prepare($sql);
      $stmt->bind_param("i", $id);
      $stmt->execute();
      $result = $stmt->get_result();

if ($result->num_rows != 1) {
  die('id not in database');
}

      $data = $result->fetch_assoc();
      //print_r($data);
      $customer_name = $data['customer_name'];
      $date = $data['date'];
      $product_name = $data['product_name'];
      $status = $data['status'];
      $quantity = $data['quantity'];


    
      ////// updating value
      

    if (isset($_POST["edit_purchase"])) {
      $input_Cname = $_POST["customer-name"];
      $input_date = $_POST["purchase-date"];
      $input_quantity = $_POST["product-quantity"];
      $input_status = $_POST["product-availability"];
      $input_Pname = $_POST["product-name"];
  
      if (isset($input_Cname)) {
          session_start(); // Start the session
  
          // Get the company_id from the session
          $company_id = $_SESSION["company_id"];
  
          $update = "UPDATE purchases SET customer_name = ?,date = ?,quantity = ?,product_name = ?,status = ? WHERE purchase_id = ?";
          $stmt = $connect->prepare($update);
          $stmt->bind_param("sssssi", $input_Cname,$input_date,$input_quantity,$input_Pname,$input_status, $id);
          $stmt->execute();
  
          
          if ($stmt->affected_rows > 0) {
            // Update the $quantity variable with the new quantity value
            $quantity = $input_quantity;

            $notification = 'Purchase edited successfully!';
            $notification_class = 'success';
        } else {
            $notification = 'Failed to edit sale!';
            $notification_class = 'error';
        }
      }
  }

  ?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

	<title>Edit Purchase - RW Inventory</title>
</head>

<style>
    /* Table styles */

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

.notification {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    padding: 10px;
    color: #ffffff;
    text-align: center;
    }

    .success {
        background-color: #28a745;
    }

    .error {
        background-color: #dc3545;
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

	<h1>Edit Purchase</h1>
	<form action="editpurchases.php?id=<?php echo $id; ?>" method="POST" enctype="multipart/form-data">
		<label for="customer-name">Customer Name:</label>
		<input type="text" id="customer-name" name="customer-name" value="<?php echo $customer_name; ?>"><br><br>

    <label for="customer-address">Customer Adress:</label>
		<input type="text" id="customer-address" name="customer-address"><br><br>


    <label for="purchase-date">Date:</label>
		<input type="date" id="purchase-date" name="purchase-date" value="<?php echo $date; ?>"><br><br>

    <label for="product-name">Product:</label>
		<select name="product-name" id="product-name" title="product-name" aria-placeholder="Choose product" value="<?php echo $product_name; ?>">
        <option value="" disabled>Select Category</option>
        <?php
        // Fetch data from table
        $sql = "SELECT * FROM products";
        $result = mysqli_query($connect, $sql);
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<option value="' . $row['product_name'] . '"' . ($row['product_name'] == $name ? 'selected' : '') . '>' . $row['product_name'] . '</option>';
        }
        ?>
    </select><br><br>
        

		<label for="product-quantity">Quantity:</label>
		<input type="text" id="product-quantity" name="product-quantity" value="<?php echo $quantity; ?>"><br><br>

		

        <label for="product-availability">Paid Status:</label>
        <input type="radio" id="product-availability-in" name="product-availability" value="Paid"  style="display: inline-block;">
        <label for="product-availability-in" style="display: inline-block;">Paid</label>
        <input type="radio" id="product-availability-out" name="product-availability" value="Not paid" checked="checked" style="display: inline-block;">
        <label for="product-availability-out" style="display: inline-block;">Not Paid</label><br><br>
        



		<button type="submit" name="edit_purchase">Edit and Save Purchase</button>
	</form>

      <!-- Notification message -->
      <?php if (isset($notification)) : ?>
        <div class="notification <?php echo $notification_class; ?>">
            <?php echo $notification; ?>
        </div>
    <?php endif; ?>

    <script>
        // Check if the notification message is set and display it
        var notification = document.querySelector(".notification");
        if (notification !== null) {
            notification.style.display = "block";
        }
    </script>


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
