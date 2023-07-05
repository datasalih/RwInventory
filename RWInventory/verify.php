<?php
include("connect.php");

if (isset($_GET["token"])) {
    $token = $_GET["token"];

    // Find the company with the provided verification token
    $find_company = "SELECT * FROM companies WHERE verification_token = '$token'";
    $result = mysqli_query($connect, $find_company);
    if (mysqli_num_rows($result) > 0) {
        $company = mysqli_fetch_assoc($result);
        $company_id = $company["company_id"];

        // Update the company's verification status
        $update_verification = "UPDATE companies SET is_verified = 1 WHERE company_id = $company_id";
        mysqli_query($connect, $update_verification);

        echo '<div class="alert alert-success" role="alert">
        Your email has been verified successfully. You can now log in.
        </div>';
    } else {
        echo '<div class="alert alert-danger" role="alert">
        Invalid verification token.
        </div>';
    }
}

mysqli_close($connect);

