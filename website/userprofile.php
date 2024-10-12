<?php
// session_start(); // Ensure session is started

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include "shared/config.php";
include "shared/header.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

$otp_sent = false;
$otp_verified = false;
$fields_hidden = false;
$otp_error = '';
$user_id = isset($_GET['id']) ? intval($_GET['id']) : 0; // Ensure user_id is defined and sanitized

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['otp'])) {
        // Verify OTP
        $input_otp = $_POST['otp'];
        if (isset($_SESSION['otp']) && $input_otp == $_SESSION['otp'] && time() <= $_SESSION['otp_expiry']) {
            $otp_verified = true;

            // Update profile if OTP is verified
            $name = mysqli_real_escape_string($conn, $_SESSION['name']);
            $phone = mysqli_real_escape_string($conn, $_SESSION['phone']);
            $address = mysqli_real_escape_string($conn, $_SESSION['address']);
            $email = mysqli_real_escape_string($conn, $_SESSION['email']);

            // Update query only if any field is changed
            $sql = "UPDATE sign_up SET Name='$name', phone='$phone', address='$address', email='$email' WHERE id=$user_id";
            if (mysqli_query($conn, $sql)) {
                // Clear session data
                unset($_SESSION['otp']);
                unset($_SESSION['otp_expiry']);
                unset($_SESSION['user_id']);
                unset($_SESSION['name']);
                unset($_SESSION['phone']);
                unset($_SESSION['address']);
                unset($_SESSION['email']);

                // Redirect to index.php
                echo "<meta http-equiv='refresh' content='2;url=loginsign.php'>";
                exit(); // Ensure no further code is executed
            } else {
                $_SESSION['otp_error'] = "Failed to update profile.";
                header("Location: userprofile.php?id=$user_id");
                exit();
            }
        } else {
            $_SESSION['otp_error'] = "OTP is incorrect or expired.";
            echo "<meta http-equiv='refresh' content='2;url=userprofile.php?id=$user_id'>";
             exit();
        }
    } else {
        // Retrieve and sanitize POST data
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $phone = mysqli_real_escape_string($conn, $_POST['phone']);
        $address = mysqli_real_escape_string($conn, $_POST['address']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);

        // Store data in session
        $_SESSION['user_id'] = $user_id;
        $_SESSION['name'] = $name;
        $_SESSION['phone'] = $phone;
        $_SESSION['address'] = $address;
        $_SESSION['email'] = $email;

        // Check if new email or username is already in use
        $sql_check = "SELECT * FROM sign_up WHERE (email = '$email' AND id != $user_id) OR (Name = '$name' AND id != $user_id)";
        $result_check = mysqli_query($conn, $sql_check);

        if (mysqli_num_rows($result_check) > 0) {
            echo "<script>alert('Username or Email is already in use');</script>";
        } else {
            // Send OTP email
            $otp = rand(1000, 9999);
            $_SESSION['otp'] = $otp;
            $_SESSION['otp_expiry'] = time() + 60; // OTP valid for 1 minute

            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host       = 'smtp.gmail.com'; 
                $mail->SMTPAuth   = true;
                $mail->Username   = 'huzaifadx780@gmail.com'; 
                $mail->Password   = 'tmzj nmlt levm opwb'; 
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; 
                $mail->Port       = 587; 

                $mail->setFrom('huzaifadx780@gmail.com', 'Your Name');
                $mail->addAddress($email); 

                $mail->isHTML(true);
                $mail->Subject = 'Your OTP Code';
                $mail->Body    = 'Your OTP code is ' . $otp;

                $mail->send();
                $otp_sent = true;
                $fields_hidden = true; // Hide profile fields, show OTP input
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
        }
    }
}

$sql = "SELECT * FROM sign_up WHERE id = $user_id";
$result = mysqli_query($conn, $sql);
$rows = mysqli_fetch_array($result);

$otp_error = isset($_SESSION['otp_error']) ? $_SESSION['otp_error'] : '';
unset($_SESSION['otp_error']); // Clear the error message after displaying it
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Settings</title>
    <link rel="icon" href="assets/img/logo1.png">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #585858;
        }
        .form-control:focus {
            box-shadow: none;
            border-color: #BA68C8;
        }
        .profile-button {
            background: #585858;
            box-shadow: none;
            border: none;
        }
        .profile-button:hover {
            background: #585858;
        }
        .profile-button:focus {
            background: #682773;
            box-shadow: none;
        }
        .profile-button:active {
            background: #682773;
            box-shadow: none;
        }
        .back:hover {
            color: #682773;
            cursor: pointer;
        }
        .labels {
            font-size: 11px;
        }
        .add-experience:hover {
            background: #BA68C8;
            color: #fff;
            cursor: pointer;
            border: solid 1px #BA68C8;
        }
        .otp-field {
            display: <?php echo $fields_hidden ? 'block' : 'none'; ?>;
        }
    </style>
</head>
<body>
    <div class="container rounded bg-white mt-5 mb-5">
        <div class="row">
            <div class="col-md-12 border-right">
                <div class="p-3 py-5">
                    <div class="d-flex justify-content-center align-items-center mb-3">
                        <h4 class="text-center">Profile Settings</h4>
                    </div>

                    <?php if ($otp_error) { ?>
                        <div class="alert alert-danger mt-2"><?php echo htmlspecialchars($otp_error); ?></div>
                    <?php } ?>

                    <?php if (!$fields_hidden) { ?>
                    <form action="userprofile.php?id=<?php echo htmlspecialchars($user_id); ?>" method="POST">
                        <div class="row mt-3">
                            <div class="col-md-12"><label class="labels">Full Name</label><input name="name" type="text" class="form-control" placeholder="Full name" value="<?php echo htmlspecialchars($rows['Name']); ?>"></div>
                            <div class="col-md-12"><label class="labels">Mobile Number</label><input name="phone" type="number" class="form-control" placeholder="Enter phone number" value="<?php echo htmlspecialchars($rows['phone']); ?>"></div>
                            <div class="col-md-12"><label class="labels">Address</label><input name="address" type="text" class="form-control" placeholder="Enter address" value="<?php echo htmlspecialchars($rows['address']); ?>"></div>
                            <div class="col-md-12"><label class="labels">Email ID</label><input name="email" type="text" class="form-control" placeholder="Enter email id" value="<?php echo htmlspecialchars($rows['email']); ?>"></div>
                        </div>
                        <div class="mt-5 text-center">
                            <button type="submit" class="btn btn-border btn-with-icon btn-small ripple">
                                <span>Save Changes</span>
                                <svg class="btn-icon-right" viewBox="0 0 13 9" width="13" height="9">
                                    <use xlink:href="assets/img/sprite.svg#arrow-right"></use>
                                </svg>
                            </button>
                        </div>
                    </form>
                    <?php } ?>

                    <?php if ($fields_hidden) { ?>
                    <form action="userprofile.php?id=<?php echo htmlspecialchars($user_id); ?>" method="POST">
                        <div class="otp-field">
                            <div class="form-group">
                                <label for="otp">Enter OTP</label>
                                <input type="text" name="otp" id="otp" class="form-control">
                                <span style="color:red; text-align:center;">Note: OTP will expire within 60 seconds</span>
                            </div>
                            <button type="submit" class="btn btn-border btn-with-icon btn-small ripple">
                                <span>Verify OTP</span>
                            </button>
                        </div>
                    </form>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
    <?php include "shared/footer.php"; ?>
</body>
</html>
