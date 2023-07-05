<?php



include("connect.php");

// Fetch the total_product count from the dashboard table using company_id
session_start(); // Start the session
$company_id = $_SESSION["company_id"];

$sql = "SELECT * FROM dashboard WHERE company_id = '$company_id'";
$result = mysqli_query($connect, $sql);
$row = mysqli_fetch_assoc($result);
$total_product = $row['total_product'];
$total_sales = $row['total_sales'];
$total_purchases = $row['total_purchases'];
$total_members = $row['total_members'];

// Calculate the balance
$balance = $total_sales - $total_purchases;

$update_dashboard = "UPDATE dashboard SET balance = $balance WHERE company_id = '$company_id'";
$update_result = mysqli_query($connect, $update_dashboard);

if ($update_result) {
    echo '<div class="alert alert-success" role="alert">
    </div>';
} else {
    echo '<div class="alert alert-danger" role="alert">
        Failed to update balance!
    </div>';
}

mysqli_close($connect);
?>
<!DOCTYPE html>
<html>
  <head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>RW Inventory Dashboard</title>

    <style>
      /* CSS for dashboard page */
      body {
        font-family: Arial, sans-serif;
  background-color: #f5f5f5;
        
  
      }

     

     

      /* CSS for sidebar */
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
		


	
		
		.container{
			
			margin-left:260px;
			margin-top:-10px;
		}
		
		.itemBox1{
			
			width: 450px;
			height: 180px;
			border:1px solid #e2e2e2;
  			box-shadow: 0.5px 0.5px 2px #aaaaaa;
			float: left;
			margin-left: 30px;
			margin-top:20px;
			color:white;
						background-image: url('images/products.jpg');
		background-size: 100% 100%;
			border-radius: 10px;


		}
		.itemBox2{
			margin-top:20px;
			width: 450px;
			height: 180px;
			color:white;
			border:1px solid #e2e2e2;
  			box-shadow: 0.5px 0.5px 2px #aaaaaa;
			float: left;
			margin-left: 30px;
			background-image: url('images/sales.jpg');
		background-size: 100% 100%;
			border-radius: 10px;

		}
		.itemBox3{
			margin-top:20px;
			width: 450px;
			height: 180px;
			border:1px solid #e2e2e2;
  			box-shadow: 0.5px 0.5px 2px #aaaaaa;
			float: left;
			margin-left: 30px;
			background-color:#ed6e85;
			color:white;
			background-image: url('images/purchaces.jpg');
		background-size: 100% 100%;
			border-radius: 10px;

		}
		.itemBox4{
			margin-top:20px;
			width: 450px;
			height: 180px;
			border:1px solid #e2e2e2;
  			box-shadow: 0.5px 0.5px 2px #aaaaaa;
			float: left;
			margin-left: 30px;
			background-color:#ed6e85;
			color:white;
			background-image: url('images/instock.jpg');
		background-size: 100% 100%;
			border-radius: 10px;

		}.itemBox5{
			margin-top:20px;
			width: 450px;
			height: 180px;
			border:1px solid #e2e2e2;
  			box-shadow: 0.5px 0.5px 2px #aaaaaa;
			float: left;
			margin-left: 30px;
			background-color:#ed6e85;
			color:white;
			background-image: url('images/soldout.jpg');
		background-size: 100% 100%;
			border-radius: 10px;

		}
		
		.itemBox6{
			margin-top:20px;
			width: 450px;
			height: 180px;
			border:1px solid #e2e2e2;
  			box-shadow: 0.5px 0.5px 2px #aaaaaa;
			float: left;
			margin-left: 30px;
			background-color:#ed6e85;
			color:white;
			background-image: url('images/notification.jpg');
		background-size: 100% 100%;
			border-radius: 10px;

		}
		
		
		
		.itemBox1:hover{
			background-color:#BA4861;
			background-image: none;
		}
		.itemBox2:hover{
		
			background-color:#3D6892;
			background-image: none;
		}
		.itemBox3:hover{
			 background-color:#C5A141;
			background-image: none;
		}
		.itemBox4:hover{
			 background-color:#2C6132;
			background-image: none;
		}
			.itemBox5:hover{
			 background-color:#871C22;
			background-image: none;
		}.itemBox6:hover{
			 background-color:#235466;
			background-image: none;
		}
		.itemBox .p{
			font-family: Tahoma, Verdana, Segoe, sans-serif; font-weight: 400;}

		
		
		.btnDash{
			
			text-align:center;
			   display: flex;
			color:white;
			border-radius: 4px;
			border: none;
			margin-left:40%;
			margin-top:38px; 
			text-align: center;
			background:none;
		}
.button-63:hover {
  outline: 0;
}
		
		
		.pie {
  --p:20;
  --b:22px;
  --c:darkred;
  --w:150px;
  
  width:var(--w);
  aspect-ratio:1;
  position:relative;
  display:inline-grid;
  margin:5px;
  place-content:center;
  font-size:25px;
  font-weight:bold;
  font-family:sans-serif;
}
	
		
		.itemBoxText{
			text-align:center; color:white; font-size:38px;
			font-family: Tahoma, Verdana, Segoe, sans-serif; font-weight: 400; margin-bottom: 0px; margin-top:30px; 
		}
		
		
	
		.notificationArea{
			
			
			border:1px solid #e2e2e2;
  			box-shadow: 0.5px 0.5px 2px #aaaaaa;
			float: left;
			
			background-color:#ed6e85;
			
			background-color: #f2f2f2;
		
			width: 97%;
			height: 200px;
			
			 background-color: #f2f2f2;
 			 color: #333;
  			 padding: 10px 20px;
  			 border-radius: 5px;
  			 box-shadow: 0 0 5px rgba(0, 0, 0, 0.3);
			
		}
		
		
		.soluna-div {
  display: absolute;
			height: 110%;
			float:left;
}

.dikey-cubuk {

margin-top:-10px;
  width: 5px;
  height: 100%;
  background-color:#2687A6;
	float:left;
	margin-left: -20px;
}
		
		.notificationDiv{
			 margin-top:50px;
			margin-top:50px;
			width:100%;
			height: 200px;
			float:left;
			margin-left:30px;
			width: 96%;
			height: 180px;
		}
		
		.notificationP{
			
			font-size:18px;
			font-family: Georgia, Times, "Times New Roman", serif;


			
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
    
    <div class="container">
	  <h1>Dashboard</h1>
		
		<hr style="margin-top:-15px; margin-bottom: 5px;">
		
		<a href="manageproduct.php">
		
		<a href="manageproduct.php">
    <div class="itemBox1">
        <p style="text-align:center; font-size:18px; font-weight:100;">All Products</p>
        <p class="itemBoxText"><?php echo $total_product; ?> Product</p>
        <button class="btnDash">Details <img src="images/right-arrow.png" width="20px" style="margin-top:-1px; margin-left:3px;"></button>
    </div>
</a>
		
<a href="managesales.php">
    <div class="itemBox2">
        <p style="text-align:center; font-size:18px; font-weight:100;">Total Sales</p>
        <p class="itemBoxText"><?php echo $total_sales; ?> $</p>
        <button class="btnDash">Details <img src="images/right-arrow.png" width="20px" style="margin-top:-1px; margin-left:3px;"></button>
    </div>
</a>
		
<a href="managepurchases.php">
    <div class="itemBox3">
        <p style="text-align:center; font-size:18px; font-weight:100;">Total Purchases</p>
        <p class="itemBoxText"><?php echo $total_purchases; ?> $</p>
        <button class="btnDash">Details <img src="images/right-arrow.png" width="20px" style="margin-top:-1px; margin-left:3px;"></button>
    </div>
</a>


<a href="manageuser.php">
    <div class="itemBox4">
        <p style="text-align:center; font-size:18px; font-weight:100;">All Members</p>
        <p class="itemBoxText"><?php echo $total_members; ?> Member</p>
        <button class="btnDash">Details <img src="images/right-arrow.png" width="20px" style="margin-top:-1px; margin-left:3px;"></button>
    </div>
</a>



    <div class="itemBox5">
        <p style="text-align:center; font-size:18px; font-weight:100;">Total Balance</p>
        <p class="itemBoxText"><?php echo $balance; ?> $</p>
        <button class="btnDash">Details <img src="images/right-arrow.png" width="20px" style="margin-top:-1px; margin-left:3px;"></button>
    </div>
</a>


		
		<div class="itemBox6" style="margin-bottom:30px;">
			<p style="text-align:center;  font-size:18px; font-weight: 100;">Notification</p>
			<p class="itemBoxText"> 2 </p>
			<button class="btnDash" stylE=""> Details <img src="images/right-arrow.png" width="20px" style="margin-top:-1px; margin-left:3px; margin-bottom:0px;"> </button>
		
		</div>
		

		
	<!--Notification area
-->  
		
		
		
	<div class="notificationDiv">	

<div class="notificationArea">
				<div class="soluna-div">
  <div class="dikey-cubuk"></div>
		
	<p class="notificationP">	❕<strong style="color:red;">Out Of Stock! </strong> 27 products were out of stock. Check your products</p>
	<p class="notificationP">	❕<strong style="color:green">New Products Added  </strong> 12 new products added to your store. Check out the products page to make sure you're arranging and pricing your products right </p>				
		</div>
		</div>	
		
</div>
 
</script>

		
		
<script type="text/javascript">


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

