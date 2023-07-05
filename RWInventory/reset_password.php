<?php
include("connect.php");

if (isset($_GET["token"])) {
    $resetToken = $_GET["token"];

    // Find the company with the matching reset token
    $select_company = "SELECT * FROM companies WHERE reset_token = '$resetToken'";
    $company = mysqli_query($connect, $select_company);

    if (mysqli_num_rows($company) > 0) {
        if (isset($_POST["new-password"]) && isset($_POST["confirm-password"])) {
            $newPassword = $_POST["new-password"];
            $confirmPassword = $_POST["confirm-password"];

            if ($newPassword === $confirmPassword) {
                $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

                // Update the company's password in the database
                $update_password = "UPDATE companies SET user_password = '$hashedPassword', reset_token = NULL WHERE reset_token = '$resetToken'";
                mysqli_query($connect, $update_password);

                echo '<div class="alert alert-success" role="alert">
                    Password reset successfully. You can now <a href="login.php">log in</a> with your new password.
                </div>';
            } else {
                echo '<div class="alert alert-danger" role="alert">
                    Passwords do not match. Please try again.
                </div>';
            }
        }
    } else {
        echo '<div class="alert alert-danger" role="alert">
            Invalid password reset token.
        </div>';
    }
}

mysqli_close($connect);
?>

<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Reset Password</title>
    <style>
        /* Add your CSS styling here */
        /* For example: */
        body {
            background-color: #f5f5f5;
            font-family: Arial, sans-serif;
        }

        #change-password-form {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0px 0px 10px #888888;
            margin: auto;
            margin-top: 50px;
            padding: 50px;
            width: 600px;
        }

        h2 {
            text-align: center;
            font-size: 25px;
            margin-bottom: 30px;
        }

        label {
            display: inline-block;
            font-weight: bold;
            margin-bottom: 10px;
        }

        input[type="password"] {
            border-radius: 5px;
            border: 1px solid #ccc;
            box-sizing: border-box;
            margin-bottom: 20px;
            padding: 10px;
            width: 100%;
        }

        .btn {
            background-color: #39A4E0;
            border: none;
            border-radius: 5px;
            color: white;
            cursor: pointer;
            padding: 10px;
            margin-top: 20px;
            margin-left: 30px;
        }

        .btn:hover {
            background-color: #49A4E0;
        }
    </style>
</head>
<body>
    <div id="change-password-form">
        <h2>Reset Password</h2>
        <form method="post" action="">
            <label for="new-password">New Password</label>
            <input type="password" id="new-password" name="new-password" required>
            <label for="confirm-password">Confirm New Password</label>
            <input type="password" id="confirm-password" name="confirm-password" required>
            <button type="submit" class="btn">Reset Password</button>
        </form>
    </div>
</body>
</html>
