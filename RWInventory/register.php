<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/Exception.php';

include("connect.php");

if (isset($_POST["register"])) {
    $email = $_POST["email"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
    $repassword = $_POST["repassword"];
    $companyname = $_POST["companyname"];

    // Check if email already exists in the database
    $check_email = "SELECT * FROM companies WHERE email = '$email'";
    $result = mysqli_query($connect, $check_email);
    if (mysqli_num_rows($result) > 0) {
        echo '<div class="alert alert-danger" role="alert">
        Email is already taken.
        </div>';
    } else if ($_POST["password"] != $_POST["repassword"]) {
        echo '<div class="alert alert-danger" role="alert">
        Passwords do not match.
        </div>';
    } else if (strlen($_POST["password"]) < 6) {
        echo '<div class="alert alert-danger" role="alert">
        Passwords must be at least 6 characters long.
        </div>';
    } else {
        // Insert a new record into the database
        $insert = "INSERT INTO companies (email, user_password, company_name) VALUES ('$email', '$password', '$companyname')";
        $insertorder = mysqli_query($connect, $insert);

        if ($insertorder) {
            // Retrieve the company_id of the newly inserted record
            $company_id = mysqli_insert_id($connect);

            // Create a new row in the dashboard table for the company
            $insert_dashboard = "INSERT INTO dashboard (company_id, total_product, total_sales, total_purchases, total_members, balance) VALUES ($company_id, 0, 0, 0, 0, 0)";
            mysqli_query($connect, $insert_dashboard);

            // Generate a unique verification token
            $verificationToken = md5(uniqid());

            // Save the verification token in the database
            $update_token = "UPDATE companies SET verification_token = '$verificationToken' WHERE company_id = $company_id";
            mysqli_query($connect, $update_token);

            // Send registration email with the verification link
            $mail = new PHPMailer(true);

            try {
                // Configure email settings
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'rwinventory1@gmail.com'; // Replace with your email
                $mail->Password = 'dblpkaqfhflozolb'; // Replace with your password
                $mail->Port = 465;
                $mail->SMTPSecure = 'ssl';

                // Set email content
                $mail->setFrom('rwinventory1@gmail.com', 'Rw Inventory'); // Replace with your email and name
                $mail->addAddress($email);

                $mail->isHTML(true);
                $mail->Subject = 'Registration Successful';
                $mail->Body = 'Thank you for registering with us! Click the following link to verify your email: <a href="http://localhost:8080/RWInventory/RWInventory/verify.php?token=' . $verificationToken . '">Verify Email</a>';

                // Send the email
                $mail->send();

                echo '<div class="alert alert-success" role="alert">
                Registration is successful. Please check your email for the verification link.
                </div>';
            } catch (Exception $e) {
                echo '<div class="alert alert-danger" role="alert">
                Registration failed. Unable to send email confirmation.
                </div>';
            }
        } else {
            echo '<div class="alert alert-danger" role="alert">
            Registration failed.
            </div>';
        }
    }
}

// Verify account if the verification token is provided in the URL
if(isset($_GET["token"])) {
    $verificationToken = $_GET["token"];

    // Find the company with the matching verification token
    $select_company = "SELECT * FROM companies WHERE verification_token = '$verificationToken'";
    $company = mysqli_query($connect, $select_company);

    if(mysqli_num_rows($company) > 0) {
        $userAccess = mysqli_fetch_assoc($company);
        $company_id = $userAccess["company_id"];

        // Update the is_verified field to 1
        $update_verified = "UPDATE companies SET is_verified = 1 WHERE company_id = $company_id";
        mysqli_query($connect, $update_verified);

        echo '<div class="alert alert-success" role="alert">
        Account verified successfully. You can now <a href="login.php">login</a> to your account.
        </div>';
    } else {
        echo '<div class="alert alert-danger" role="alert">
        Invalid verification token.
        </div>';
    }
}

mysqli_close($connect);
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <title>RW Inventory Registration</title>
     <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <style>

      /* CSS for registration page */
      body {
        background-color: #f5f5f5;
        font-family: Arial, sans-serif;
      }

      #register-container {
        background-color: white;
        border-radius: 10px;
        box-shadow: 0px 0px 10px #888888;
        margin: auto;
        padding: 40px;
        width: 500px;
      }

      input[type=text], 
      input[type=email],
      input[type=password],
      textarea {
        padding: 11px;
        border: 1px solid black;
        border-radius: 10px;
        margin-bottom: 30px;
        width: 100%;
      }

      img {
  border-radius: 50%;

  padding: 5px;
  width: 75px;
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

      input[type=submit]:hover {
        background-color: #49A4E0;
      }

      label {
        padding: 2px;
        font-size: 16px;
        font-weight: bold;
      }

      h1 {
        font-size: 48px;
  font-weight: bold;
  margin-bottom: 40px;
  text-align: center;
      }
    </style>
  </head>
 

  <body>
  
  <header>
      <a href="login.php">
        <img src="images/rwlog.png" alt="RW Inventory">
      </a>
    
    </header>


    <div id="register-container">
      <h1>RW Inventory Registration</h1>

      <form action="register.php" method="POST">
        <label for="companyname">Company Name</label>
        <input type="text" id="companyname" name="companyname" required>

        <label for="email">E-mail</label>
        <input type="email" id="email" name="email" required>

        <label for="password">Password</label>
<input type="password" id="password" name="password" required minlength="6">

        <label for="password">Confirm Password</label>
        <input type="password" id="repassword" name="repassword" required minlength="6">
     

        <button type="submit" name="register" class="btn btn-primary">Register</button>
      </form>
    </div>

   
  </body>
</html>
