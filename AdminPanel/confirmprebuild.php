<?php
include "shared/header.php";
include "shared/config.php";

// Check if the delete_order button is clicked
if (isset($_POST['delete_order'])) {
    $order_number = $_POST['order_number'];

    // SQL query to delete the order
    $sql_delete = "DELETE FROM prebuildorder WHERE order_number = ?";
    $stmt_delete = mysqli_prepare($conn, $sql_delete);
    if ($stmt_delete === false) {
        die('MySQL prepare statement error: ' . mysqli_error($conn));
    }

    mysqli_stmt_bind_param($stmt_delete, "i", $order_number);
    $delete_result = mysqli_stmt_execute($stmt_delete);

    if ($delete_result) {
        echo "<div class='alert alert-danger text-center' role='alert'>
                Order #$order_number has been successfully deleted.
              </div>";
        echo "<meta http-equiv='refresh' content='2'>"; // Refresh the page after 2 seconds
    } else {
        echo "<div class='alert alert-danger text-center' role='alert'>
                Failed to delete order #$order_number. Please try again.
              </div>";
    }

    mysqli_stmt_close($stmt_delete);
}

// SQL query to fetch order details
$sql = "SELECT prebuildorder.order_number, prebuildorder.user_id, pre_build.build_name, pre_build.price, sign_up.Name, sign_up.email, sign_up.address, sign_up.phone 
        FROM prebuildorder 
        JOIN sign_up ON prebuildorder.user_id = sign_up.id 
        JOIN pre_build ON prebuildorder.pre_build_id = pre_build.pre_id 
        WHERE prebuildorder.status = 1";

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

<h3 class="text-center text-success my-5">Pre-Build PCs Success Orders</h3>

<?php if (mysqli_num_rows($result) == 0) : ?>
    <div class="alert alert-warning text-center" role="alert">
        You haven't Confirmed any order yet.
    </div>
<?php else : ?>
    <div class="container">
    <div class="table-wrapper">
        <table class="table">
            <thead>
                <tr>
                    <th style="text-align:center;" scope="col">Order Number</th>
                    <th style="text-align:center;" scope="col">Build Name</th>
                    <th style="text-align:center;" scope="col">Build Price</th>
                    <th style="text-align:center;" scope="col">Order By</th>
                    <th style="text-align:center;" scope="col">Email</th>
                    <th style="text-align:center;" scope="col">Address</th>
                    <th style="text-align:center;" scope="col">Phone</th>
                    <th style="text-align:center;" scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($data = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td style="text-align:center;">#<?php echo htmlspecialchars($data["order_number"]); ?></td>
                        <td style="text-align:center;"><?php echo htmlspecialchars($data["build_name"]); ?></td>
                        <td style="text-align:center;"><?php echo htmlspecialchars($data["price"]); ?>$</td>
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
                                <input type="hidden" name="order_number" value="<?php echo htmlspecialchars($data['order_number']); ?>">
                                <button type="submit" name="delete_order" class="btn btn-danger font-weight-bold">Delete Order</button>
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
