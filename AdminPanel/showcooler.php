<?php
include "shared/header.php";
include "shared/config.php";
$cooler_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$delmess = '';
$error = '';

if ($cooler_id > 0) {
    $sql = "DELETE FROM cooler WHERE cooler_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, 'i', $cooler_id);
        if (mysqli_stmt_execute($stmt)) {
            $delmess = "Cooler Deleted Successfully";
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
        <li class="breadcrumb-item active" aria-current="page">All CPU Cooler</li>
      </ol>
    </nav>
    <br><br><br>
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
              <h4 class="card-title mb-0">All CPU Cooler</h4>
            </div>
            <p>Following are the all CPU Cooler which are on your website</p>
            <div class="table-responsive">
              <table class="table table-striped table-hover">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Manufacture</th>
                    <th>Fan RPM</th>
                    <th>Noise Level</th>
                    <th>Color</th>
                    <th>Radiator Size</th>
                    <th>Price</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                    <?php
                    
                    $sql = "SELECT * FROM cooler";
                    $result = mysqli_query($conn, $sql);
                    $row_number = 1;
                    while ($row = mysqli_fetch_array($result)) {
                    ?>
                  <tr>
                    <td><?php echo $row_number++?></td>
                    <td><img width="150" src="compimg/<?php echo $row['img']?>" alt=""></td>
                    <td><?php echo $row['cooler_name']?></td>
                    <td><?php echo $row['manufacture']?></td>
                    <td><?php echo $row['fanrpm']?>RPM</td>
                    <td><?php echo $row['noiselvl']?>dB</td>
                    <td><?php echo $row['color']?></td>
                    <td><?php echo $row['radiatorsize']?>mm</td>
                    <td><?php echo $row['cooler_price']?>$</td>

                    <td><a href="editcooler.php?id=<?php echo $row['cooler_id']?>">Edit</a>/<a href="showcooler.php?id=<?php echo $row['cooler_id']?>">Delete</a></td>
                  </tr>
                  <?php }?>
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
