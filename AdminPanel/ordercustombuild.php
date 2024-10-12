<?php
// Start output buffering
ob_start();

include "shared/header.php";
include "shared/config.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Include Composer's autoload file
require 'vendor/autoload.php';

$success_message = '';

if (isset($_POST['send_mail'])) {
    $email = $_POST['email'];
    $name = $_POST['name'];
    $order_number = $_POST['order_number'];

    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'huzaifadx780@gmail.com';
        $mail->Password = 'tmzj nmlt levm opwb';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('your-email@gmail.com', 'Your Name');
        $mail->addAddress($email, $name);

        $mail->isHTML(true);
        $mail->Subject = 'Order Confirmation';
        $mail->Body = 'Dear ' . $name . ',<br><br>Your order (Order Number: ' . $order_number . ') has been confirmed. Thank you for choosing our service.<br><br>Best Regards,<br>Your Company';

        $mail->send();
        $success_message = "Confirmation mail has been sent to " . $email;

        // Update the status in the database
        $update_status_query = "UPDATE customorder SET status = 1 WHERE order_number = '$order_number'";
        mysqli_query($conn, $update_status_query);

        // Redirect to confirmation page
        header("Location: confirmcustomorder.php?message=" . urlencode($success_message));
        exit;

    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}

if (isset($_POST['reject_order'])) {
    $email = $_POST['email'];
    $name = $_POST['name'];
    $order_number = $_POST['order_number'];

    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'huzaifadx780@gmail.com';
        $mail->Password = 'tmzj nmlt levm opwb';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('your-email@gmail.com', 'Your Name');
        $mail->addAddress($email, $name);

        $mail->isHTML(true);
        $mail->Subject = 'Order Rejection';
        $mail->Body = 'Dear ' . $name . ',<br><br>We regret to inform you that your order (Order Number: ' . $order_number . ') has been rejected. If you have any questions, please contact us.<br><br>Best Regards,<br>Your Company';

        $mail->send();
        $success_message = "Rejection mail has been sent to " . $email;

        // Update the status in the database
        $update_status_query = "UPDATE customorder SET status = 2 WHERE order_number = '$order_number'";
        mysqli_query($conn, $update_status_query);

        // Redirect to rejection page
        header("Location: rejectcustomorder.php?message=" . urlencode($success_message));
        exit;

    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}

// SQL query to fetch order details
$sql = "SELECT customorder.order_number, customorder.user_id, sign_up.Name, sign_up.email, sign_up.address, sign_up.phone , cpu.c_name, cooler.cooler_name,motherboard.mb_name,memory.ram_name,storage.s_name,gpu.g_name,pccase.case_name,psu.psu_name
        FROM customorder 
        JOIN sign_up ON customorder.user_id = sign_up.id 
        JOIN cpu ON customorder.cpu_id = cpu.c_id
        JOIN cooler ON customorder.cooler_id = cooler.cooler_id
        JOIN motherboard ON customorder.mb_id = motherboard.mb_id
        JOIN memory ON customorder.ram_id = memory.m_id
        JOIN storage ON customorder.s_id = storage.s_id
        JOIN gpu ON customorder.gpu_id = gpu.g_id
        JOIN pccase ON customorder.case_id = pccase.case_id
        JOIN psu ON customorder.psu_id = psu.psu_id
        WHERE customorder.status = 0";

$result = mysqli_query($conn, $sql);

if (!$result) {
    echo "Error executing query: " . mysqli_error($conn);
}
?>

<style>
 .table-wrapper {
    overflow-x: auto; /* Enable horizontal scrolling */
    -webkit-overflow-scrolling: touch; /* Smooth scrolling on iOS */
}

.table {
    min-width: 1000px; /* Set a minimum width to force horizontal scrolling */
}

</style>
<body>
    <?php if (isset($_GET['message'])) : ?>
        <div style="text-align:center;" class="alert alert-success" role="alert">
            <?php echo htmlspecialchars($_GET['message']); ?>
        </div>
    <?php endif; ?>

    <h3 class="text-center text-success my-5">Custom-Build PCs Order</h3>
    <?php if (mysqli_num_rows($result) == 0) : ?>
        <div class="alert alert-warning text-center" role="alert">
            You dont any orders yet :)
        </div>
    <?php else : ?>
        <div class="container">
    <div class="table-wrapper">
        <table class="table">
            <thead>
                <tr>
                    <th style="text-align:center;" scope="col">Order Number</th>
                    <th style="text-align:center;" scope="col">CPU</th>
                    <th style="text-align:center;" scope="col">Cooler</th>
                    <th style="text-align:center;" scope="col">MotherBoard</th>
                    <th style="text-align:center;" scope="col">Memory</th>
                    <th style="text-align:center;" scope="col">Storage</th>
                    <th style="text-align:center;" scope="col">GPU</th>
                    <th style="text-align:center;" scope="col">Case</th>
                    <th style="text-align:center;" scope="col">PSU</th>
                    <th style="text-align:center;" scope="col">Order By</th>
                    <th style="text-align:center;" scope="col">Email</th>
                    <th style="text-align:center;" scope="col">Address</th>
                    <th style="text-align:center;" scope="col">Phone</th>
                    <th style="text-align:center;" scope="col">Action</th>
                    <th scope="col">User Details</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($data = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td style="text-align:center;">#<?php echo htmlspecialchars($data["order_number"]); ?></td>
                        <td style="text-align:center;"><?php echo htmlspecialchars($data["c_name"]); ?></td>
                        <td style="text-align:center;"><?php echo htmlspecialchars($data["cooler_name"]); ?>$</td>
                        <td style="text-align:center;"><?php echo htmlspecialchars($data["mb_name"]); ?></td>
                        <td style="text-align:center;"><?php echo htmlspecialchars($data["ram_name"]); ?></td>
                        <td style="text-align:center;"><?php echo htmlspecialchars($data["s_name"]); ?></td>
                        <td style="text-align:center;"><?php echo htmlspecialchars($data["g_name"]); ?></td>
                        <td style="text-align:center;"><?php echo htmlspecialchars($data["case_name"]); ?></td>
                        <td style="text-align:center;"><?php echo htmlspecialchars($data["psu_name"]); ?></td>
                        <td style="text-align:center;"><?php echo htmlspecialchars($data["Name"]); ?></td>
                        <td style="text-align:center;"><?php echo htmlspecialchars($data["email"]); ?></td>
                        <td style="text-align:center;"><?php 
                            $fullAddress = htmlspecialchars($data["address"]);
                            $shortAddress = (strlen($fullAddress) > 30) ? substr($fullAddress, 0, 30) . '...' : $fullAddress;
                            echo $shortAddress; 
                        ?></td>
                        <td style="text-align:center;"><?php echo htmlspecialchars($data["phone"]); ?></td>
                        <td>
                            <form method="post" style="display: inline;">
                                <input type="hidden" name="email" value="<?php echo htmlspecialchars($data['email']); ?>">
                                <input type="hidden" name="name" value="<?php echo htmlspecialchars($data['Name']); ?>">
                                <input type="hidden" name="order_number" value="<?php echo htmlspecialchars($data['order_number']); ?>">
                                <button type="submit" name="send_mail" class="btn btn-warning font-weight-bold">Send Confirmation Mail</button>
                            </form>
                            <form method="post" style="display: inline;">
                                <input type="hidden" name="email" value="<?php echo htmlspecialchars($data['email']); ?>">
                                <input type="hidden" name="name" value="<?php echo htmlspecialchars($data['Name']); ?>">
                                <input type="hidden" name="order_number" value="<?php echo htmlspecialchars($data['order_number']); ?>">
                                <button type="submit" name="reject_order" class="btn btn-danger font-weight-bold">Reject Order</button>
                            </form>
                        </td>
                        <td>
                            <form method="get" action="user_details.php" style="display: inline;">
                                <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($data['user_id']); ?>">
                                <button type="submit" class="btn btn-info font-weight-bold">User Details</button>
                            </form>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

    <?php endif; ?>
<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
    <?php include "shared/footer.php"; ?>
</body>

<?php
// End output buffering and flush the buffer
ob_end_flush();
?>
