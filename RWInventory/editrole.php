<?php
      /*if (!isset($_GET['id']))
      {
        die('Id not provided');
      }*/
    require_once('connect.php');
    $id = $_GET["id"];

    

      $sql = "SELECT * FROM roles WHERE role_id = ?";
      $stmt = $connect->prepare($sql);
      $stmt->bind_param("i", $id);
      $stmt->execute();
      $result = $stmt->get_result();

if ($result->num_rows != 1) {
  die('id not in database');
}

      $data = $result->fetch_assoc();
      //print_r($data);
      $name = $data['role_name'];
      //$submitId = $data['category_name'];

      ////// updating value
      

    if (isset($_POST["edit_role"])) {
      $category_name = $_POST["product-name"];
  
      if (isset($category_name)) {
          session_start(); // Start the session
  
          // Get the company_id from the session
          $company_id = $_SESSION["company_id"];
  
          $update = "UPDATE roles SET role_name = ? WHERE role_id = ?";
          $stmt = $connect->prepare($update);
          $stmt->bind_param("si", $category_name, $id);
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
            $notification = 'Role edited successfully!';
            $notification_class = 'success';
        } else {
            $notification = 'Failed to edit role!';
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

	<title>Edit Role - RW Inventory</title>
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

	<h1>Edit Role</h1> <br> <br>
	<form action="editrole.php?id=<?php echo $id; ?>" method="post">
		<label for="product-name">Role Name:</label>
		<input type="text" id="product-name" name="product-name" value="<?php echo $name; ?>"><br><br>

        <form class="Permissions">
            <h3>Permissions</h3>
            <table>
                <thead>
                    <tr>
                        <th></th>
                        <th>Create</th>
                        <th>View</th>
                        <th>Update</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><b>Roles</b></td>
                        <td><input type="checkbox" id="C1"></td>
                        <td><input type="checkbox" id="V1"></td>
                        <td><input type="checkbox" id="U1"></td>
                        <td><input type="checkbox" id="D1"></td>
                    </tr>
    
                    <tr>
                        <td><b>Users</b></td>
                        <td><input type="checkbox" id="C2"></td>
                        <td><input type="checkbox" id="V2"></td>
                        <td><input type="checkbox" id="U2"></td>
                        <td><input type="checkbox" id="D2"></td>
                    </tr>
    
                    <tr>
                        <td><b>Categories</b></td>
                        <td><input type="checkbox" id="C3"></td>
                        <td><input type="checkbox" id="V3"></td>
                        <td><input type="checkbox" id="U3"></td>
                        <td><input type="checkbox" id="D3"></td>
                    </tr>
    
                    <tr>
                        <td><b>Products</b></td>
                        <td><input type="checkbox" id="C4"></td>
                        <td><input type="checkbox" id="V4"></td>
                        <td><input type="checkbox" id="U4"></td>
                        <td><input type="checkbox" id="D4"></td>
                    </tr>
    
                    <tr>
                        <td><b>Sales</b></td>
                        <td><input type="checkbox" id="C5"></td>
                        <td><input type="checkbox" id="V5"></td>
                        <td><input type="checkbox" id="U5"></td>
                        <td><input type="checkbox" id="D5"></td>
                    </tr>
    
                    <tr>
                        <td><b>Purchases</b></td>
                        <td><input type="checkbox" id="C6"></td>
                        <td><input type="checkbox" id="V6"></td>
                        <td><input type="checkbox" id="U6"></td>
                        <td><input type="checkbox" id="D6"></td>
                    </tr>
    
                    <tr>
                        <td><b>Report</b></td>
                        <td><input type="checkbox" id="C7"></td>
                        <td><input type="checkbox" id="V7"></td>
                        <td><input type="checkbox" id="U7"></td>
                        <td><input type="checkbox" id="D7"></td>
                    </tr>
                </tbody>
            </table>
		
                <br><br>

		<button type="submit" name="edit_role">Edit and Save Role</button>
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
      <?php
  // Check if the form was submitted and the role name was updated
  if (isset($_POST['edit_role'])) {
    $newName = $_POST['product-name'];
    // Update the role name in the database

    // Show the updated value in the input field
    echo "<script>document.getElementById('product-name').value = '$newName';</script>";
  }
  ?>
</body>
</html>
