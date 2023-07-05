<?php

include("connect.php");

if(isset($_POST["login"]))
{
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Check if the user is an admin
    $select_admin = "SELECT * FROM companies WHERE email='$email'";
    $admin_login = mysqli_query($connect, $select_admin);

    if(mysqli_num_rows($admin_login) > 0)
    {
        $adminAccess = mysqli_fetch_assoc($admin_login);
        $hashPassword = $adminAccess["user_password"];
        $isVerified = $adminAccess["is_verified"];

        if(password_verify($password, $hashPassword))
        {
            if($isVerified == 1)
            {
                session_start();
                $_SESSION["email"] = $adminAccess["email"];
                $_SESSION["company_name"] = $adminAccess["company_name"];
                $_SESSION["company_id"] = $adminAccess["company_id"]; // Add the company_id to the session

                $company_id = $adminAccess["company_id"];
                $select_company_data = "SELECT * FROM companies WHERE company_id='$company_id'";
                $company_data = mysqli_query($connect, $select_company_data);
                $company_row = mysqli_fetch_assoc($company_data);

                // Admin user
                header("location: dash.php"); // Redirect to the dashboard
            }
            else
            {
                echo '<div class="alert alert-danger" role="alert">
                Your account is not verified. Please check your email for verification instructions.
                </div>';
            }
        }
        else
        {
            echo '<div class="alert alert-danger" role="alert">
            E-mail or Password is Wrong!
            </div>';
        }
    }
    else
    {
        // Check if the user is a regular user
        $select_user = "SELECT * FROM user WHERE email='$email'";
        $user_login = mysqli_query($connect, $select_user);

        if(mysqli_num_rows($user_login) > 0)
        {
            $userAccess = mysqli_fetch_assoc($user_login);
            $hashPassword = $userAccess["password"];

            if(password_verify($password, $hashPassword))
            {
                session_start();
                $_SESSION["email"] = $userAccess["email"];
                $_SESSION["user_name"] = $userAccess["name"];
                $_SESSION["user_id"] = $userAccess["user_id"]; // Add the user_id to the session

                // Regular user added by admin
                header("location: dash.php"); // Redirect to the dashboard
            }
            else
            {
                echo '<div class="alert alert-danger" role="alert">
                E-mail or Password is Wrong!
                </div>';
            }
        }
        else
        {
            echo '<div class="alert alert-danger" role="alert">
            E-mail is not found!
            </div>';
        }
    }
}

mysqli_close($connect);
?>






<!DOCTYPE html>
<html>
  <head>
    <title>RW Inventory</title>
    <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <style>
      /* CSS for login page */
      body {
  font-family: Arial, sans-serif;
  background-color: #f5f5f5;
}

      #login-container {
        background-color: white;
        border-radius: 10px;
        box-shadow: 0px 0px 10px #888888;
        margin: auto;
        margin-top: 50px;
        padding: 60px;
        width: 500px;
      }

      input[type=email], 
      input[type=password] {
        padding: 11px;
        border: 1px solid black;
        border-radius: 8px;
        margin-bottom: 30px;
        width: 100%;
      }

      input[type=submit] {
        background-color: #39A4E0;
        border: none;
        border-radius: 5px;
        color: white;
        cursor: pointer;
        padding: 10px;
        width: 100%;
      }

      input[type=submit]:hover {
        background-color: #49A4E0;
      }

      label {
        padding: 2px;
      
        font-size: 16px;
        font-weight: bold;
      }

      h1 {
        text-align: center;
      }
      
      


.container {
  max-width: 1200px;
  margin: auto;
  padding: 20px;
}

header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 40px;
}

nav {
  display: flex;
}

nav ul {
  list-style: none;
  margin: 0;
  padding: 0;
  display: flex;
}

nav ul li {
  margin-right: 20px;
}

nav ul li a {
  color: #555;
  text-decoration: none;
  font-size: 18px;
  font-weight: bold;
}

nav ul li a:hover {
  color: #222;
}

h1 {
  font-size: 48px;
  font-weight: bold;
  margin-bottom: 40px;
  text-align: center;
}

.features {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 40px;
}

.feature {
  flex-basis: calc(33.33% - 20px);
  padding: 20px;
  background-color: #fff;
  border-radius: 8px;
  box-shadow: 0px 0px 10px #888888;
}


button {
        background-color: #39A4E0;
        border: none;
        border-radius: 5px;
        color: white;
        cursor: pointer;
        padding: 10px;
        width: 100%;
      }

.feature {
  flex-basis: calc(33.33% - 20px);
  padding: 20px;
  background-color: #fff;
  border-radius: 8px;
  box-shadow: 0px 0px 10px #888888;
}

.feature h2 {
  font-size: 24px;
  margin-bottom: 20px;
}

.feature p {
  font-size: 18px;
  line-height: 1.5;
}

.get-started-button {
  text-align: center;
}

.get-started-button a {
  display: inline-block;
  padding: 20px 40px;
  background-color: #39A4E0;
  color: #fff;
  border-radius: 5px;
  font-size: 20px;
  font-weight: bold;
  text-decoration: none;
}

.get-started-button a:hover {
  background-color: #49A4E0;
  cursor: pointer;

}
img {
  border-radius: 50%;

  padding: 5px;
  width: 75px;
}

      #register {
        text-decoration: none;
        margin-left: 196px;
      }

      #forgot {
        text-decoration: none;
        margin-right: 10px;
      }

      .tableSize{
			background-color:red; width:100px; height:100px; align:center; text-align: center;
		}
		.blue-area{
			background-color:#ecf5f8; width:100%; height:700px; padding-top:1px;
		}
		.white-area{
			background-color:#f5f5f5; width:100%; height:700px; padding-top:1px;
		}
		.td1{ width:5%; height:100%; }
		.td2{ width:90%;height:100%; text-align: center;margin-left:100px;}
		
		
		table {
        border-collapse: collapse;
        width: 100%;
        max-width: 800px;
        margin: auto;
			background-color:#f4fbfd;
		
      }

      th, td {
        border: 0px solid #ddd;
        padding: 8px;
        text-align: center;
        
		  font-size:14px;
      }
		
      th {
        background-color:white ;
		  
      }

      td {
        font-weight: bold;
		  font-size:17px;
      }
		tr{
			height:70px;
		}

      .price {
        color: black;
      }

      .range {
		color:grey;
      }
    
  

    </style>


  </head>

  <body>

    
  <header>
  <a href="login.php">
    <img src="images/rwlog.png" alt="RW Inventory">
  </a>
  <nav>
    <ul>
    <li><a href="#RW">Features</a></li>
    <li><a href="#RW">Contact Us</a></li>
    </ul>
  </nav>
</header>

    <div class="white-area" style="background-image: url('images/bg.png');background-size: 100% 200px; height: 200px;">
	
	<h2 style="text-align:center; align:center; font-size:40px;">
	Automate your Inventory Tracking

	</h2>
	<p style="align:center; text-align: center; color:grey;">
Provide our customers with the products they need by regularly tracking the stock of the products in your store.	</p>
	  
	  </div>
	<div class="blue-area">

    <div id="login-container">
      <h1>RW Inventory Login</h1>
      <form action="login.php" method="POST">

        <label for="mail">E-mail</label> 
        <input type="email" id="email" name="email" required>

        <label for="password">Password</label>
        <input type="password" id="password" name="password" required>

        <button type="submit" name="login" class="btn btn-primary">LOGIN</button>

        <br> <br> <br>

         <a  href="forgot.php" id="forgot">Forgot Password?</a>

         <a href="register.php" id = register>Sign Up</a>

        </div>

      </form>
   </div>
  



    <div class="container">
      <h1>Inventory Tracking and Management Made Easy</h1> 
      <div class="features">
        <div class="feature">
          <h2>Track Inventory</h2>
          <p>Never run out of stock again. Keep track of your inventory levels and get alerts when items are running low.</p>
        </div>
        <div class="feature">
          <h2>Manage Sales and Purchases</h2>
          <p>Manage your sales and purchases in one place. Keep track of your income and expenses to make better business decisions.</p>
        </div>
        <div class="feature">
          <h2>Manage Team Members</h2>
          <p>Collaborate with your team members to manage inventory, sales, and purchases. Assign roles and permissions to control access to sensitive data.</p>
        </div>
        <div class="feature">
          <h2>Generate Reports</h2>
          <p>Get insights into your inventory, sales, and purchases with customizable reports. Export data to Excel or CSV for further analysis.</p>
        </div>
      </div>

      
      <div class="white-area" style="text-align: center; " >
	<h2 style="text-align: center; font-size:40px; align:center;" id="RW">Why RW Inventory?</h2>
			
   
		
		<table style=" width:40%; margin-left:30%; background-color:#f5f5f5">
		<tr >
			<td class="td1">
				<img src="images/update.png" width="100px" height="70px" style=""> 
     
			</td>
			<td class="td2">
			<h3 style="margin-bottom:10px; float:left;">Continuous improvements</h3>  <br> <br>

       <p style="float:left; text-align: left; color:grey;">New features will continue to be added with regular updates for life.</p>
			</td>
			</tr>
		
			
			
			
			
			<tr >
			<td class="td1">
			<img src="images/noprogramming.png" width="100px" height="70px" style=""> 
			</td>
			
      <td class="td2">
			<h3 style="margin-bottom:10px; float:left;">No programming skills needed </h3>
       <p style="float:left; text-align: left; color:grey;">do all the operations easily on the panel without knowing any programming language.</p>
			</td>
			</tr>

			

		

			
			
			
			<td class="td1">
			<img src="images/editable.png" width="100px" height="70px" style=""> 
			</td>
			<td class="td2">
			<h3 style="margin-bottom:10px; float:left;">Editable Stock Management</h3>
       <p style="float:left; text-align: left; color:grey;">All properties are editable. Editing / adding / removing to stock management can be done as you want</p>
			</td>
			</tr>
			
		</table>
		
		
		
		<br> <br>
		
	
		
	
		
		
    <div style="width:100%; height:300px; background-color:#353535; margin-bottom: -40px; text-align:center;">
    <div style="width:1000px; height:100px; margin:auto;">
        <div style="width:40%; height:300px; float:left; text-align: left;">
            <div style="display:flex; align-items:center;"> 
                <img src="images/location.png" width="10px" height="60px" style="margin-right: 10px; margin-top:25px">
                <div>
                    <p style="color:white; margin-top: 25px; font-size: 14px;">Ramadan Cemil Street</p>
                    <h3 style="color: grey; margin: 0; font-size: 16px;">TRNC, Kyrenia</h3>
                </div>
            </div>
            <div style="display:flex; align-items:center; margin-top: 25px;">
                <img src="images/phone.png" width="10px" height="60px" style="margin-right: 10px;">
                <div>
                    <p style="color:white; margin: 0; font-size: 14px;">+90 392 815 15 15</p>
                </div>
            </div>
            <div style="display:flex; align-items:center; margin-top: 25px;">
                <img src="images/mail.png" width="10px" height="60px" style="margin-right: 10px;">
                <div>
                    <p style="color:white; margin: 0; font-size: 14px;">rwinventory1@gmail.com</p>
                </div>
            </div>
        </div>
        <div style="width:40%; height:100px; float:right; text-align:left;">
            <h3 style="color:white; margin-bottom: 10px; font-size: 18px;">About Us</h3>
            <p style="color:white; margin-top: 0; font-size: 14px;">
                Track Inventory: Never run out of stock again. Keep track of your inventory levels and get alerts when items are running low.
                <br /><br />
                Manage Sales and Purchases: Manage your sales and purchases in one place. Keep track of your income and expenses to make better business decisions.
            </p>
        </div>
    </div>
</div>

				
<script>
// JavaScript for smooth scrolling to sections
// JavaScript for smooth scrolling to sections
function scrollToTop() {
  window.scrollTo({
    top: 0,
    behavior: "smooth" // smooth scrolling animation
  });
}
const getStartedButton = document.querySelector(".get-started-button a");


getStartedButton.addEventListener("click", scrollToTop);

function scrollToTop() {
  window.scrollTo({
    top: 0,
    behavior: "smooth" // smooth scrolling animation
  });
}

function scrollToBottom() {
  window.scrollTo({
    top: document.body.scrollHeight,
    behavior: "smooth" // smooth scrolling animation
  });
}

const featuresLink = document.querySelector("li a[href='#RW']");
const contactUsLink = document.querySelector("li a[href='#ContactUs']");

featuresLink.addEventListener("click", scrollToBottom);
contactUsLink.addEventListener("click", scrollToBottom);

const contactUsSection = document.getElementById("ContactUs");

contactUsLink.addEventListener("click", function(event) {
  event.preventDefault();
  contactUsSection.scrollIntoView({
    behavior: "smooth" // smooth scrolling animation
  });
});

</script>
  </body>
</html>