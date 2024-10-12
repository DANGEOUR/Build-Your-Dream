<?php
include "shared/header.php";
include "shared/config.php";
$cooler_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$delmess = '';
$error = '';

if ($cooler_id > 0) {
    $sql = "DELETE FROM pccase WHERE case_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, 'i', $cooler_id);
        if (mysqli_stmt_execute($stmt)) {
            $delmess = "Case Deleted Successfully";
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
        <li class="breadcrumb-item active" aria-current="page">All PSU</li>
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
              <h4 class="card-title mb-0">All PSU</h4>
            </div>
            <p>Following are the all PSU which are on your website</p>
            <div class="table-responsive">
              <table class="table table-striped table-hover">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Manufacture</th>
                    <th>Type</th>
                    <th>Efficiency Rating</th>
                    <th>Wattage</th>
                    <th>Modular</th>
                    <th>Color</th>
                    <th>Price</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                    <?php
                    
                    $sql = "SELECT * FROM psu";
                    $result = mysqli_query($conn, $sql);
                    $row_number = 1;
                    while ($row = mysqli_fetch_array($result)) {
                    ?>
                  <tr>
                    <td><?php echo $row_number++?></td>
                    <td><img width="150" src="compimg/<?php echo $row['img']?>" alt=""></td>
                    <td><?php echo $row['psu_name']?></td>
                    <td><?php echo $row['manufacture']?></td>
                    <td><?php echo $row['type']?></td>
                    <td><?php echo $row['efficiencyrating']?></td>
                    <td><?php echo $row['wattage']?>W</td>
                    <td><?php echo $row['modular']?></td>
                    <td><?php echo $row['color']?></td>
                    <td><?php echo $row['psu_price']?>$</td>

                    <td><a href="editpsu.php?id=<?php echo $row['psu_id']?>">Edit</a>/<a href="showpsu.php?id=<?php echo $row['psu_id']?>">Delete</a></td>
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
