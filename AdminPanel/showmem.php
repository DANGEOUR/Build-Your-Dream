<?php
include "shared/header.php";
include "shared/config.php";

// Ensure $c_id is an integer to prevent SQL injection
$c_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$delmess = '';
$error = '';

if ($c_id > 0) {
    $sql = "DELETE FROM memory WHERE mb_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, 'i', $c_id);
        if (mysqli_stmt_execute($stmt)) {
            $delmess = "Memory(RAM) Deleted Successfully";
        } else {
            $error = mysqli_stmt_error($stmt);
        }
        mysqli_stmt_close($stmt);
    } else {
        $error = mysqli_error($conn);
    }
} else {
    $error = "Invalid ID.";
}
?>

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
        <li class="breadcrumb-item"><a href="#">Edit Components</a></li>
        <li class="breadcrumb-item active" aria-current="page">All Memorys</li>
    </ol>
</nav>


<div class="col-md-12 grid-margin"><?php if ($delmess != ""): ?>
    <div class="alert alert-danger">
        <?php echo $delmess; ?>
    </div>
<?php endif; ?>
<?php if ($error != ""): ?>
    <script>
        console.log("<?php echo $error; ?>"); // Log the error to the console
    </script>
<?php endif; ?>

    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between">
                <h4 class="card-title mb-0">All Memorys</h4>
            </div>
            <p>Following are all Memorys which are on your website</p>
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Manufacture</th>
                            <th>Speed</th>
                            <th>Modules</th>
                            <th>Color</th>
                            <th>First Word Latency</th>
                            <th>CAS Latency</th>
                            <th>Price</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT * FROM memory";
                        $result = mysqli_query($conn, $sql);
                        $row_number = 1;
                        while ($row = mysqli_fetch_array($result)) {
                        ?>
                        <tr>
                            <td><?php echo $row_number++ ?></td>
                            <td><img width="150" src="compimg/<?php echo $row['img'] ?>" alt=""></td>
                            <td><?php echo $row['ram_name'] ?></td>
                            <td><?php echo $row['manufacture'] ?></td>
                            <td><?php echo $row['speed'] ?></td>
                            <td><?php echo $row['modules'] ?></td>
                            <td><?php echo $row['color'] ?></td>
                            <td><?php echo $row['firstwordlatency'] ?></td>
                            <td><?php echo $row['CASlatency'] ?></td>
                            <td><?php echo $row['ram_price'] ?>$</td>
                            <td><a href="editmem.php?id=<?php echo $row['m_id'] ?>">Edit</a>/<a href="showmb.php?id=<?php echo $row['m_id'] ?>">Delete</a></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
<?php
include "shared/footer.php";
?>
