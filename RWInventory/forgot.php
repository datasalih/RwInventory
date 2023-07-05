<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/Exception.php';

include("connect.php");

$message = '';

if (isset($_POST["email"])) {
    $email = $_POST["email"];

    // Check if email exists in the database
    $check_email = "SELECT * FROM companies WHERE email = '$email'";
    $result = mysqli_query($connect, $check_email);
    if (mysqli_num_rows($result) > 0) {
        $userAccess = mysqli_fetch_assoc($result);
        $company_id = $userAccess["company_id"];

        // Generate a unique password reset token
        $resetToken = md5(uniqid());

        // Save the reset token in the database
        $update_token = "UPDATE companies SET reset_token = '$resetToken' WHERE company_id = $company_id";
        mysqli_query($connect, $update_token);

        // Send password reset email with the reset link
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
            $mail->setFrom('rwinventory1@gmail.com', 'RW Inventory'); // Replace with your email and name
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = 'Password Reset Request';
            $mail->Body = 'You have requested to reset your password. Click the following link to reset your password: <a href="http://localhost:8080/RWInventory/RWInventory/reset_password.php?token=' . $resetToken . '">Reset Password</a>';

            // Send the email
            $mail->send();

            $message = '<div class="alert alert-success" role="alert">
            A password reset link has been sent to your email address. Please check your inbox.
            </div>';
        } catch (Exception $e) {
            $message = '<div class="alert alert-danger" role="alert">
            Failed to send the password reset email.
            </div>';
        }
    } else {
        $message = '<div class="alert alert-danger" role="alert">
        Email not found.
        </div>';
    }
}

mysqli_close($connect);
?>

<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <title>RW Inventory Forgot Password</title>
  <style>
    /* CSS for forgot password page */
    body {
      background-color: #f5f5f5;
      font-family: Arial, sans-serif;
    }

    #forgot-password-container {
      background-color: white;
      border-radius: 10px;
      box-shadow: 0px 0px 10px #888888;
      margin: auto;
      margin-top: 150px;
      padding: 50px;
      width: 500px;
    }

    input[type=email] {
      padding: 11px;
      border: 1px solid black;
      border-radius: 10px;
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

    button {
      background-color: #39A4E0;
      border: none;
      border-radius: 5px;
      color: white;
      cursor: pointer;
      padding: 10px;
      width: 100%;
    }

    h1 {
      text-align: center;
    }
  </style>
</head>
<body>
  <div id="forgot-password-container">
    <h1>RW Inventory Forgot Password</h1>
    <?php echo $message; ?>
    <form action="" method="POST">
      <label for="email">E-mail</label>
      <input type="email" id="email" name="email" required>
      <button type="submit" name="renew" class="btn btn-primary">Renew password</button>
    </form>
  </div>
</body>
</html>