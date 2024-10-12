<?php
// session_start();
include "shared/header.php";
include "shared/config.php"; // Ensure this file contains your database connection setup

// Initialize message variables
$cancel_message = "";

// Check if the cancel form was submitted for Pre-Build Orders
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['order_number'])) {
    $order_number = $_POST['order_number'];

    // Prepare the statement to delete the order from prebuildorder
    $delete_sql = "DELETE FROM prebuildorder WHERE order_number = ?";
    if ($stmt = $conn->prepare($delete_sql)) {
        $stmt->bind_param("s", $order_number);
        if ($stmt->execute()) {
            $cancel_message = "Your Order #$order_number is canceled.";
        } else {
            $cancel_message = "Failed to cancel your order. Please try again.";
        }
        $stmt->close();
    }
}

// Check if the cancel form was submitted for Custom Orders
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['order_number'])) {
    $order_number = $_POST['order_number'];

    // Prepare the statement to delete the order from customorder
    $delete_sql = "DELETE FROM customorder WHERE order_number = ?";
    if ($stmt = $conn->prepare($delete_sql)) {
        $stmt->bind_param("s", $order_number);
        if ($stmt->execute()) {
            $cancel_message = "Your Order #$order_number is canceled.";
        } else {
            $cancel_message = "Failed to cancel your order. Please try again.";
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order History</title>
    <!-- Include Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Include your custom CSS if needed -->
    <link href="assets/css/styles.css" rel="stylesheet">
</head>
<body>
<nav class="bread-crumbs">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <ul class="bread-crumbs-list">
                    <li>
                        <a href="index.php">Home</a>
                        <i class="material-icons md-18">chevron_right</i>
                    </li>
                    <li>Order History</li>
                </ul>
            </div>
        </div>
    </div>
</nav>
<br><br><br>

<?php
// Initialize $user_id variable
$user_id = null;

// Check if the user ID is set in the session
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
}
?>

<div class="container">
    <?php if ($cancel_message): ?>
        <div class="alert alert-danger" role="alert">
            <?php echo htmlspecialchars($cancel_message); ?>
        </div>
    <?php endif; ?>

    <h1 style="text-align:center;">Pre-Build Orders</h1>

    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Order Number</th>
                    <th scope="col">Build Name</th>
                    <th scope="col">Build Price</th>
                    <th scope="col">Customer Name</th>
                    <th scope="col">CPU Name</th>
                    <th scope="col">Cooler Name</th>
                    <th scope="col">MotherBoard</th>
                    <th scope="col">Memory</th>
                    <th scope="col">Storage</th>
                    <th scope="col">GPU</th>
                    <th scope="col">Case</th>
                    <th scope="col">PSU</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (isset($user_id) && $user_id !== null) {
                    $pre_build_sql = "SELECT prebuildorder.*, pre_build.*, sign_up.Name
                                      FROM prebuildorder
                                      JOIN pre_build ON prebuildorder.pre_build_id = pre_build.pre_id
                                      JOIN sign_up ON sign_up.id = prebuildorder.user_id
                                      WHERE prebuildorder.user_id = ?";
                    if ($stmt = $conn->prepare($pre_build_sql)) {
                        $stmt->bind_param("i", $user_id);
                        $stmt->execute();
                        $pre_build_result = $stmt->get_result();

                        if ($pre_build_result->num_rows > 0) {
                            $serial = 1;
                            while ($row = $pre_build_result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . htmlspecialchars($serial++) . "</td>";
                                echo "<td>#" . htmlspecialchars($row['order_number']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['build_name']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['price']) . "$</td>";
                                echo "<td>" . htmlspecialchars($row['Name']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['CPU']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['CpuCooler']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['MotherBoard']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['Memory']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['storage']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['GPU']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['pc_case']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['PSU']) . "</td>";

                                if ($row['status'] == 0) {
                                    echo "<td>

                                        <form method='post' action='orderhistory.php'>
                                       
                                            <input type='hidden' name='order_number' value='" . htmlspecialchars($row['order_number']) . "'>
                                            <button type='submit' class='alert alert-danger'>Cancel</button>
                                     
                                          
                                        </form>
                                    </td>";
                                } elseif ($row['status'] == 1) {
                                    echo "<td>
                                        <button type='button' class='alert alert-danger' disabled>Cancel</button>
                                        <br><small>Admin has confirmed your order; you can't cancel it.</small>
                                    </td>";
                                } else {
                                    echo "<td>
                                        <button type='button' class='alert alert-danger' disabled>Cancel</button>
                                        <br><small>Your order has been rejected by the admin.</small>
                                    </td>";
                                }

                                echo "</tr>";
                            }
                        } else {
                            echo '<tr style="text-align:center;"><td colspan="14" style="text-align:center;">
                                    <div class="alert alert-warning" role="alert">
                                        You haven\'t ordered any Pre-Build PC
                                    </div>  
                                    <a href="PreBuild.php" class="btn btn-border btn-with-icon btn-small ripple">
                                        <span>Pre-Build PC</span>
                                        <svg class="btn-icon-right" viewBox="0 0 13 9" width="13" height="9"><use xlink:href="assets/img/sprite.svg#arrow-right"></use></svg>
                                    </a>
                                  </td></tr>';
                        }

                        $stmt->close();
                    } else {
                        echo "<tr><td colspan='14'>Failed to prepare statement.</td></tr>";
                    }
                } else {
                    echo "<tr><td colspan='14'>Please log in to see your order history.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <br><br><br>
    <h1 style="text-align:center;">Custom-Build Orders</h1>

    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Order Number</th>
                    <th scope="col">Customer Name</th>
                    <th scope="col">CPU</th>
                    <th scope="col">Cooler</th>
                    <th scope="col">MotherBoard</th>
                    <th scope="col">Memory</th>
                    <th scope="col">Storage</th>
                    <th scope="col">GPU</th>
                    <th scope="col">Case</th>
                    <th scope="col">PSU</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                if (isset($user_id) && $user_id !== null) {
                    $sql = "SELECT customorder.*, sign_up.Name, cpu.c_name, cooler.cooler_name, motherboard.mb_name, memory.ram_name, storage.s_name, gpu.g_name, pccase.case_name, psu.psu_name
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
                            WHERE customorder.user_id = ?";

                    if ($stmt = $conn->prepare($sql)) {
                        $stmt->bind_param("i", $user_id);
                        $stmt->execute();
                        $result = $stmt->get_result();

                        if ($result->num_rows > 0) {
                            $serial = 1;
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . htmlspecialchars($serial++) . "</td>";
                                echo "<td>#" . htmlspecialchars($row['order_number']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['Name']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['c_name']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['cooler_name']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['mb_name']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['ram_name']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['s_name']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['g_name']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['case_name']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['psu_name']) . "</td>";

                                if ($row['status'] == 0) {
                                    echo "<td>
                                        <form method='post' action='orderhistory.php'>
                                            <input type='hidden' name='order_number' value='" . htmlspecialchars($row['order_number']) . "'>
                                            <button type='submit' class='alert alert-danger'>Cancel</button>
                                        </form>
                                    </td>";
                                } elseif ($row['status'] == 1) {
                                    echo "<td>
                                        <button type='button' class='alert alert-danger' disabled>Cancel</button>
                                        <br><small>Admin has confirmed your order; you can't cancel it.</small>
                                    </td>";
                                } else {
                                    echo "<td>
                                        <button type='button' class='alert alert-danger' disabled>Cancel</button>
                                        <br><small>Your order has been rejected by the admin.</small>
                                    </td>";
                                }

                                echo "</tr>";
                            }
                        } else {
                            echo '<tr style="text-align:center;"><td colspan="12" style="text-align:center;">
                                    <div class="alert alert-warning" role="alert">
                                        You haven\'t ordered any Custom-Build PC
                                    </div>  
                                    <a href="CustomBuild.php" class="btn btn-border btn-with-icon btn-small ripple">
                                        <span>Custom-Build PC</span>
                                        <svg class="btn-icon-right" viewBox="0 0 13 9" width="13" height="9"><use xlink:href="assets/img/sprite.svg#arrow-right"></use></svg>
                                    </a>
                                  </td></tr>';
                        }

                        $stmt->close();
                    } else {
                        echo "<tr><td colspan='12'>Failed to prepare statement. Error: " . htmlspecialchars($conn->error) . "</td></tr>";
                    }
                } else {
                    echo "<tr><td colspan='12'>Please log in to see your order history.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<?php
include "shared/footer.php"
?>