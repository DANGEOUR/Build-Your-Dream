<?php
include "shared/config.php";
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

// Get the PC ID and username from the URL
$cpu_id = isset($_GET['c_id']) ? $_GET['c_id'] : '';
$cooler_id = isset($_GET['cooler_id']) ? $_GET['cooler_id'] : '';
$g_id = isset($_GET['g_id']) ? $_GET['g_id'] : '';
$mb_id = isset($_GET['mb_id']) ? $_GET['mb_id'] : '';
$ram_id = isset($_GET['m_id']) ? $_GET['m_id'] : '';
$storage_id = isset($_GET['s_id']) ? $_GET['s_id'] : '';
$psu_id = isset($_GET['psu_id']) ? $_GET['psu_id'] : '';
$case_id = isset($_GET['case_id']) ? $_GET['case_id'] : '';
$username = $_GET['user'];

// Fetch user details
$userQuery = "SELECT * FROM sign_up WHERE Name='$username'";
$userResult = mysqli_query($conn, $userQuery);
$userData = mysqli_fetch_assoc($userResult);

// Initialize messages and total price
$successMessage = "";
$errorMessage = "";
$totalPrice = 0; // Initialize totalPrice

// Fetch pre-built PC details
$sqlPC = "SELECT * FROM cpu JOIN cooler JOIN gpu JOIN memory JOIN pccase JOIN storage JOIN psu JOIN motherboard WHERE cpu.c_id = $cpu_id AND cooler.cooler_id = $cooler_id AND motherboard.mb_id = $mb_id AND memory.m_id = $ram_id AND storage.s_id = $storage_id AND gpu.g_id = $g_id AND pccase.case_id = $case_id AND psu.psu_id = $psu_id";
$resultPC = mysqli_query($conn, $sqlPC);
if ($resultPC) {
    $pcData = mysqli_fetch_assoc($resultPC);

    // Calculate total price
    if ($pcData) {
        $totalPrice = $pcData['c_price'] + $pcData['cooler_price'] + $pcData['mb_price'] + $pcData['ram_price'] + $pcData['s_price'] + $pcData['g_price'] + $pcData['case_price'] + $pcData['psu_price'];
    }
} else {
    $errorMessage = "Error fetching PC details: " . mysqli_error($conn);
}

// Handle the order placement when the button is clicked
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['place_order'])) {
    // Generate a random 4-digit order number
    $orderNumber = rand(1000, 9999);
    $userID = $userData['id']; // Assuming 'id' is the column name in the 'sign_up' table

    // Insert order details into the 'prebuildorder' table
    $orderQuery = "INSERT INTO `customorder` ( `order_number`, `user_id`, `cpu_id`, `cooler_id`, `mb_id`, `ram_id`, `s_id`, `gpu_id`, `case_id`, `psu_id`, `status`) VALUES ($orderNumber, $userID, '$cpu_id', '$cooler_id', '$mb_id', '$ram_id', '$storage_id', '$g_id', '$case_id', '$psu_id', 0)";
    if (mysqli_query($conn, $orderQuery)) {
        $successMessage = "Thank you for using our service. Your order number is #$orderNumber. We will deliver your dream shortly.";

        // Prepare email content
        $emailContent = "
            <h1>Thank You, {$userData['Name']} for using our service</h1>
            <h2>Order Details</h2>
            <h3>Your Order Number:# $orderNumber</h3>
            <p>Thank you for your order. Here are the details of your custom PC build:</p>
            <table>
                <tr><th>Component</th><th>Name</th><th>Price</th></tr>
                <tr><td>CPU</td><td>{$pcData['c_name']}</td><td>\${$pcData['c_price']}</td></tr>
                <tr><td>CPU Cooler</td><td>{$pcData['cooler_name']}</td><td>\${$pcData['cooler_price']}</td></tr>
                <tr><td>Motherboard</td><td>{$pcData['mb_name']}</td><td>\${$pcData['mb_price']}</td></tr>
                <tr><td>Memory</td><td>{$pcData['ram_name']}</td><td>\${$pcData['ram_price']}</td></tr>
                <tr><td>Storage</td><td>{$pcData['s_name']}</td><td>\${$pcData['s_price']}</td></tr>
                <tr><td>GPU</td><td>{$pcData['g_name']}</td><td>\${$pcData['g_price']}</td></tr>
                <tr><td>Case</td><td>{$pcData['case_name']}</td><td>\${$pcData['case_price']}</td></tr>
                <tr><td>PSU</td><td>{$pcData['psu_name']}</td><td>\${$pcData['psu_price']}</td></tr>
                <tr><th>Total</th><td></td><th>\${$totalPrice}</th></tr>
            </table>
            <p>Thank You For choosing us, You will get a confirmation mail within 24hrs.</p>
        ";

        // Send email
        $mail = new PHPMailer(true); // true enables exceptions
        try {
            //Server settings
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'huzaifadx780@gmail.com'; // SMTP username
            $mail->Password = 'tmzj nmlt levm opwb'; // SMTP password
            $mail->SMTPSecure = 'tls'; // Enable TLS encryption, `ssl` also accepted
            $mail->Port = 587; // TCP port to connect to

            //Recipients
            $mail->setFrom('huzaifadx780@gmail.com', 'Custom PC Build');
            $mail->addAddress($userData['email'], $userData['Name']); // Send email to the user who submitted the form

            // Content
            $mail->isHTML(true); // Set email format to HTML
            $mail->Subject = 'Your Custom PC Build Order Details';
            $mail->Body = $emailContent;

            $mail->send();
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }

        // Redirect after 2 seconds
        echo "<meta http-equiv='refresh' content='2;url=orderhistory.php'>";
    } else {
        $errorMessage = "Error: " . mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Custom-Build Check Out</title>
    <link rel="icon" href="assets/img/logo1.png">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <style>
        #invoice-POS {
            box-shadow: 0 0 1in -0.25in rgba(0, 0, 0, 0.5);
            padding: 2mm;
            margin: 0 auto;
            width: 150mm; /* Adjusted width for larger card */
            background: #fff;
        }
        h1 { font-size: 1.5em; color: #222; }
        h2 { font-size: 1.2em; } /* Increased font size */
        h3 { font-size: 1.2em; font-weight: 300; line-height: 2em; }
        p { font-size: 1em; color: #666; line-height: 1.5em; } /* Increased font size */
        #top, #mid, #bot { border-bottom: 1px solid #eee; }
        #top { min-height: 100px; }
        #mid { min-height: 80px; }
        #bot { min-height: 50px; }
        .info { display: block; margin-left: 0; }
        .title { float: right; }
        .title p { text-align: right; }
        table { width: 100%; border-collapse: collapse; }
        .tabletitle { font-size: 1em; background: #eee; } /* Increased font size */
        .service { border-bottom: 1px solid #eee; }
        .item { width: 24mm; }
        .itemtext { font-size: 1em; } /* Increased font size */
        #legalcopy { margin-top: 5mm; }
        #top .logo {
            height: 60px;
            width: 60px;
            background: url(assets/img/logo1.png) no-repeat;
            background-size: 60px 60px;
        }
        .clientlogo {
            float: left;
            height: 60px;
            width: 60px;
            background: url(assets/img/logo1.png) no-repeat;
            background-size: 60px 60px;
            border-radius: 50px;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <?php if (!empty($successMessage)): ?>
            <div class="alert alert-success" role="alert">
                <?php echo $successMessage; ?>
            </div>
        <?php elseif (!empty($errorMessage)): ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $errorMessage; ?>
            </div>
        <?php endif; ?>
    </div>
    <a style="text-decoration:none; color:Black; padding-left:5%;" href="custombuild.php?psu_id=<?php echo $psu_id; ?>&c_id=<?php echo $cpu_id; ?>&g_id=<?php echo $g_id; ?>&cooler_id=<?php echo $cooler_id; ?>&mb_id=<?php echo $mb_id; ?>&m_id=<?php echo $ram_id; ?>&s_id=<?php echo $storage_id; ?>&case_id=<?php echo $case_id; ?>">
        Go Back
    </a>

    <div id="invoice-POS">
        <center id="top">
            <div class="logo"></div>
            <div class="info">
                <h2>Custom PC Build</h2>
            </div>
        </center>

        <div id="mid">
            <div class="info">
                <h2>Contact Info</h2>
                <p>
                    User name: <?php echo $userData['Name']; ?><br>
                    Address: <?php echo $userData['address']; ?><br>
                    Email: <?php echo $userData['email']; ?><br>
                    Phone: <?php echo $userData['phone']; ?><br>
                </p>
            </div>
        </div>

        <div id="bot">
            <div id="table">
                <h2>Order Details</h2>
                <table>
                    <tr class="tabletitle">
                        <th>Component</th>
                        <th>Name</th>
                        <th>Price</th>
                    </tr>
                    <tr class="service">
                        <td class="tableitem"><p class="itemtext">CPU:</p></td>
                        <td class="tableitem"><p class="itemtext"><?php echo $pcData['c_name']; ?></p></td>
                        <td class="tableitem"><p class="itemtext"><?php echo $pcData['c_price']; ?>$</p></td>
                    </tr>
                    <tr class="service">
                        <td class="tableitem"><p class="itemtext">CPU Cooler:</p></td>
                        <td class="tableitem"><p class="itemtext"><?php echo $pcData['cooler_name']; ?></p></td>
                        <td class="tableitem"><p class="itemtext"><?php echo $pcData['cooler_price']; ?>$</p></td>
                    </tr>
                    <tr class="service">
                        <td class="tableitem"><p class="itemtext">Motherboard:</p></td>
                        <td class="tableitem"><p class="itemtext"><?php echo $pcData['mb_name']; ?></p></td>
                        <td class="tableitem"><p class="itemtext"><?php echo $pcData['mb_price']; ?>$</p></td>
                    </tr>
                    <tr class="service">
                        <td class="tableitem"><p class="itemtext">Memory:</p></td>
                        <td class="tableitem"><p class="itemtext"><?php echo $pcData['ram_name']; ?></p></td>
                        <td class="tableitem"><p class="itemtext"><?php echo $pcData['ram_price']; ?>$</p></td>
                    </tr>
                    <tr class="service">
                        <td class="tableitem"><p class="itemtext">Storage:</p></td>
                        <td class="tableitem"><p class="itemtext"><?php echo $pcData['s_name']; ?></p></td>
                        <td class="tableitem"><p class="itemtext"><?php echo $pcData['s_price']; ?>$</p></td>
                    </tr>
                    <tr class="service">
                        <td class="tableitem"><p class="itemtext">GPU:</p></td>
                        <td class="tableitem"><p class="itemtext"><?php echo $pcData['g_name']; ?></p></td>
                        <td class="tableitem"><p class="itemtext"><?php echo $pcData['g_price']; ?>$</p></td>
                    </tr>
                    <tr class="service">
                        <td class="tableitem"><p class="itemtext">Case:</p></td>
                        <td class="tableitem"><p class="itemtext"><?php echo $pcData['case_name']; ?></p></td>
                        <td class="tableitem"><p class="itemtext"><?php echo $pcData['case_price']; ?>$</p></td>
                    </tr>
                    <tr class="service">
                        <td class="tableitem"><p class="itemtext">PSU:</p></td>
                        <td class="tableitem"><p class="itemtext"><?php echo $pcData['psu_name']; ?></p></td>
                        <td class="tableitem"><p class="itemtext"><?php echo $pcData['psu_price']; ?>$</p></td>
                    </tr>
                    <tr class="tabletitle">
                        <td></td>
                        <td class="Rate"><h2>Total</h2></td>
                        <td class="payment"><h2><?php echo $totalPrice; ?>$</h2></td>
                    </tr>
                </table>
                <form method="post">
                    <button type="submit" name="place_order" class="btn btn-primary">Place Order</button>
                </form>
                
            </div>
            <div id="legalcopy">
                <p class="legal"><strong>Thank you for your business!</strong> Your order details will be sent to your email.</p>
            </div>
        </div>
    </div>
</body>
</html>
