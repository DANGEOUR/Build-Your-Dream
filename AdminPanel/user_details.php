<?php
include "shared/header.php";
include "shared/config.php";

if (isset($_GET['user_id'])) {
    $user_id = intval($_GET['user_id']);

    // Fetch user details from the database
    $sql = "SELECT * FROM sign_up WHERE id = $user_id";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        $user = mysqli_fetch_assoc($result);
    } else {
        echo "Error fetching user details: " . mysqli_error($conn);
    }
} else {
    echo "User ID not specified.";
}
?>

<style>
    .container {
        display: block;
        margin: auto;
        width: 70%;
        height: auto;
        margin-top: 5rem;
    }
    .card-shadow {
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        border-radius :10px;
    }
</style>

    <div class="container">
        <h3 class="text-center text-success my-5">User Details</h3>
        <?php if (isset($user)): ?>
            <div class="card card-shadow">
                <div class="card-body">
                    <h5 class="card-title">User Information</h5>
                    <p><strong>Name:</strong> <?php echo htmlspecialchars($user['Name']); ?></p>
                    <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
                    <p><strong>Address:</strong> <?php echo htmlspecialchars($user['address']); ?></p>
                    <p><strong>Phone:</strong> <?php echo htmlspecialchars($user['phone']); ?></p>
                </div>
            </div>
        <?php endif; ?>
    </div>
<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
    <?php include "shared/footer.php"; ?>
