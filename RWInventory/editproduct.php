<?php
    include("connect.php");
    $id = $_GET["id"];

    

      $sql = "SELECT * FROM products WHERE product_id = ?";
      $stmt = $connect->prepare($sql);
      $stmt->bind_param("i", $id);
      $stmt->execute();
      $result = $stmt->get_result();

if ($result->num_rows != 1) {
  die('id not in database');
}

      $data = $result->fetch_assoc();
      //print_r($data);
      $name = $data['product_name'];
      $price = $data['price'];
      $quantity = $data['quantity'];
      $availability = $data['availability'];
      $category = $data['category'];
      $image_path = $data['image_path'];
      
      
      $notification = "";
      $notification_class = "";
      ////// updating value
      

    if (isset($_POST["edit_product"])) {
      $input_name = $_POST["product-name"];
      $input_price = $_POST["product-price"];
      $input_quantity = $_POST["product-quantity"];
      $input_category = $_POST["product-category"];
      $input_availability = $_POST["product-availability"];
      //$input_image_path = $_POST["product-image"];

      // Handle file upload
    $input_image_path = $image_path; // Default to the existing image path

    if ($_FILES["product-image"]["error"] === UPLOAD_ERR_OK) {
        $file_name = $_FILES["product-image"]["name"];
        $file_tmp = $_FILES["product-image"]["tmp_name"];
        $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);

        // Generate a unique file name to avoid conflicts
        $unique_name = uniqid() . "." . $file_ext;

        // Specify the upload directory
        $upload_dir = "images/";

        // Move the uploaded file to the desired location
        if (move_uploaded_file($file_tmp, $upload_dir . $unique_name)) {
            // Set the new image path
            $input_image_path = $upload_dir . $unique_name;
        } else {
            // Error occurred during file upload
            die('Failed to upload the image');
        }
    }
  
      if (isset($input_name) && isset($input_price) && isset($input_category)) {
          session_start(); // Start the session
  
          // Get the company_id from the session
          $company_id = $_SESSION["company_id"];
  
          $update = "UPDATE products SET product_name = ?, price = ?, quantity = ?, category = ?, availability = ?, image_path = ? WHERE product_id = ?";
          $stmt = $connect->prepare($update);
          $stmt->bind_param("ssssssi", $input_name, $input_price,$input_quantity,$input_category,$input_availability,$input_image_path, $id);
          $stmt->execute();
  
          /*if ($stmt->affected_rows > 0) {
              echo '<div class="alert alert-success" role="alert">
              Category edited successfully!
              </div>';
          } else {
              echo '<div class="alert alert-danger" role="alert">
              Failed to edit category!
              </div>';
          }*/

          if ($stmt->affected_rows > 0) {
            $notification = 'Product edited successfully!';
            $notification_class = 'success';
            $name = $input_name; 
        } else {
            $notification = 'Failed to edit product!';
            $notification_class = 'error';
        }
      }}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

	<title>Edit Product - RW Inventory</title>
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
    
	<h1>Edit Product</h1> <br>
	<form action="editproduct.php?id=<?php echo $id; ?>" method="POST" enctype="multipart/form-data">
		<label for="product-name">Product Name:</label>
		<input type="text" id="product-name" name="product-name" value="<?php echo $name; ?>"><br><br>

        
		<label for="product-image">Image:</label>
<input type="file" id="product-image" name="product-image" value="<?php echo $image_path; ?>" style="display: none;">
<button type="button" onclick="document.getElementById('product-image').click();" style="background-color: #39A4E0; color: white; border: none; padding: 8px 16px; text-align: center; text-decoration: none; display: inline-block; font-size: 14px; margin: 4px 2px; cursor: pointer; border-radius: 4px;">Add Image</button>
<br> <br> <br>



		<label for="product-price">Price:</label>
		<input type="text" id="product-price" name="product-price" value="<?php echo $price; ?>"><br><br>

		<label for="product-quantity">Quantity:</label>
		<input type="text" id="product-quantity" name="product-quantity" value="<?php echo $quantity; ?>"><br><br>

		<label for="product-category">Category:</label>
		<select name="product-category" id="product-category" title="product-category" aria-placeholder="Choose Category">
        <option value="" disabled>Select Category</option>
        <?php
        // Fetch data from table
        $sql = "SELECT * FROM categories";
        $result = mysqli_query($connect, $sql);
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<option value="' . $row['category_name'] . '"' . ($row['category_name'] == $category ? 'selected' : '') . '>' . $row['category_name'] . '</option>';
        }
        ?>
    </select><br><br>

        <label for="product-availability">Availability:</label>
        <input type="radio" id="product-availability-in" name="product-availability" value="in-stock" style="display: inline-block;">
        <label for="product-availability-in" style="display: inline-block;">In Stock</label>
        <input type="radio" id="product-availability-out" name="product-availability" value="out-stock" style="display: inline-block;">
        <label for="product-availability-out" style="display: inline-block;">Out of Stock</label><br><br>
        



		<button type="submit" name="edit_product">Edit and Save Product</button>
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
