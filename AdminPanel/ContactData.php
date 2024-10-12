<?php
include "shared/header.php";
include "shared/config.php";

$sql = "SELECT * FROM contact";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<style>
    .container {
        display: block;
        margin: auto;
        width: 70%;
        height: auto;
        margin-top: 5rem;
    }
</style>

<body>

    <div class="container">
        <h3 class="text-center text-success my-5">Contact Us Table</h3>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Phone</th>
                    <th scope="col">Email</th>
                    <th scope="col">Message</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($data = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($data["name"]); ?></td>
                        <td><?php echo htmlspecialchars($data["phone"]); ?></td>
                        <td><?php echo htmlspecialchars($data["email"]); ?></td>
                        <td><?php echo htmlspecialchars($data["message"]); ?></td>
                        <td>
                            <a href="mailto:<?php echo urlencode($data['email']); ?>" class="btn btn-warning font-weight-bold">Send Mail</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
    <?php include "shared/footer.php"; ?>
</body>

</html>
