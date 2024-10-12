<?php
session_start();
include "shared/config.php";

$otp_verified = false;
$error_message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $input_otp = $_POST['otp'];
    $user_id = $_POST['user_id'];

    if (isset($_SESSION['otp']) && isset($_SESSION['otp_expiry'])) {
        $stored_otp = $_SESSION['otp'];
        $otp_expiry = $_SESSION['otp_expiry'];

        if (time() > $otp_expiry) {
            $error_message = "OTP has expired. Please request a new OTP.";
        } elseif ($input_otp != $stored_otp) {
            $error_message = "Invalid OTP. Please try again.";
        } else {
            // OTP is valid
            $otp_verified = true;
            // Redirect to profile update page
            header("Location: userprofile.php?id=" . htmlspecialchars($user_id));
            exit;
        }
    } else {
        $error_message = "No OTP found. Please request a new OTP.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Verify OTP</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Verify OTP</h4>
                    <?php if (!empty($error_message)): ?>
                        <div class="alert alert-danger"><?php echo htmlspecialchars($error_message); ?></div>
                    <?php endif; ?>
                    <form action="verify_otp.php" method="POST">
                        <div class="mb-3">
                            <label for="otp" class="form-label">Enter OTP</label>
                            <input type="text" class="form-control" id="otp" name="otp" required>
                        </div>
                        <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($_GET['id']); ?>">
                        <button type="submit" class="btn btn-primary">Verify OTP</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
