<?php
include("connect.php");

$sql = "SELECT * FROM categories";
$result = mysqli_query($connect, $sql);

if (isset($_POST["add_product"])) {
    $product_name = $_POST["product_name"];
    $price = $_POST["price"];
    $quantity = $_POST["quantity"];
    $category = $_POST["category"];
    $availability = $_POST["availability"];

    $image_path = "";
    $image_name = "";
    
    if ($_FILES["product-image"]["error"] == UPLOAD_ERR_OK) {
        $image_name = $_FILES["product-image"]["name"];
        $image_tmp_name = $_FILES["product-image"]["tmp_name"];
        $file_ext = strtolower(pathinfo($image_name, PATHINFO_EXTENSION));
        $unique_name = uniqid() . "_" . time() . "." . $file_ext;
        $image_path = "images/" . $unique_name;
        move_uploaded_file($image_tmp_name, $image_path);
    }

    if (isset($product_name) && isset($price) && isset($quantity) && isset($category) && isset($availability)) {
        session_start(); // Start the session

        // Get the company_id from the session
        $company_id = $_SESSION["company_id"];

        $insert = "INSERT INTO products (product_name, price, quantity, category, availability, image_path, company_id) 
                    VALUES ('$product_name', '$price', '$quantity', '$category', '$availability', '$image_path', '$company_id')";
        $insert_result = mysqli_query($connect, $insert);

        if ($insert_result) {
            // Update the total_product count in the dashboard table
            $update_dashboard = "UPDATE dashboard SET total_product = total_product + 1 WHERE company_id = '$company_id'";
            mysqli_query($connect, $update_dashboard);

            echo '<div class="alert alert-success" role="alert">
                    Product added successfully!
                  </div>';
        } else {
            echo '<div class="alert alert-danger" role="alert">
                    Failed to add product!
                  </div>';
        }
    } else {
        $update_dashboard = "UPDATE dashboard SET total_members = total_members + 1 WHERE company_id = '$company_id'";
        mysqli_query($connect, $update_dashboard);

        echo '<div class="alert alert-danger" role="alert">
            Failed! Please fill all blank areas. 
        </div>';
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
	<h1>Add Product</h1> <br>
  <form action="addproduct.php" method="POST" enctype="multipart/form-data">

    <label for="product-name">Product Name:</label>
    <input type="text" id="product_name" name="product_name" required><br><br>

    <label for="product-image">Image:</label>
    <input type="file" id="product-image" name="product-image" style="display: none;" onchange="showFileName()" required>
    <button type="button" onclick="document.getElementById('product-image').click();" style="background-color: #39A4E0; color: white; border: none; padding: 8px 16px; text-align: center; text-decoration: none; display: inline-block; font-size: 14px; margin: 4px 2px; cursor: pointer; border-radius: 4px;">Add Image</button>
    <span id="file-name"></span><br><br>

    <script>
        function showFileName() {
            var fileInput = document.getElementById('product-image');
            var fileNameSpan = document.getElementById('file-name');
            fileNameSpan.innerHTML = fileInput.files[0].name;
        }
    </script>

    <label for="product-price">Selling Price:</label>
    <input type="text" id="price" name="price" required><br><br>

    <label for="product-quantity">Quantity:</label>
    <input type="text" id="quantity" name="quantity" required><br><br>

    <label for="product-category">Category:</label>
    <select name="category" id="category" title="Role" aria-placeholder="Choose Category" required>
        <option value="" disabled selected>Select Category</option>
        <?php
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<option value='" . $row["category_name"] . "'>" . $row["category_name"] . "</option>";
            }
        } else {
            echo "<option value='' disabled>No categories found</option>";
        }
        ?>
    </select>
    <br><br>

    <label for="product-availability">Availability:</label>
    <input type="radio" id="product-availability-in" name="availability" value="in-stock" style="display: inline-block;" required>
    <label for="product-availability-in" style="display: inline-block;">In Stock</label>
    <input type="radio" id="product-availability-out" name="availability" value="out-stock" style="display: inline-block;" required>
    <label for="product-availability-out" style="display: inline-block;">Out of Stock</label><br><br>

    <button type="submit" name="add_product" class="btn btn-primary" required>Add Product</button>

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
