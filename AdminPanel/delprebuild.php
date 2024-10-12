<?php
include "shared/header.php";
include "shared/config.php";

$mess = '';

// Check if id parameter is set and is numeric
if(isset($_GET['id']) && is_numeric($_GET['id'])) {
    $pre_id = $_GET['id'];

    $sql = "DELETE FROM `pre_build` WHERE pre_id = ?";
    
    // Prepare the statement
    $stmt = mysqli_prepare($conn, $sql);
    
    // Bind parameters
    mysqli_stmt_bind_param($stmt, "i", $pre_id);
    
    // Execute the statement
    $result = mysqli_stmt_execute($stmt);
    
    if(!$result){
        // Error handling: Print error to console
        $error_message = "Error: " . mysqli_stmt_error($stmt);
        echo "<script>console.error('$error_message');</script>";
    } else {
        $mess = "PC Deleted Successfully";
    }
    
    // Close statement
    mysqli_stmt_close($stmt);

    // Redirect to same page to refresh
    echo '<script>window.location.href = "delprebuild.php";</script>';
} else if(isset($_GET['id'])) {
    // Handle case where id is provided but not numeric
    echo "<script>console.error('Invalid id parameter');</script>";
} else {
    // Handle case where id parameter is not provided
    echo "<script>console.error('id parameter is missing');</script>";
}

// Fetch all PCs
$sql = "SELECT * FROM pre_build";
$result = mysqli_query($conn, $sql);

// Check if there are rows
if (mysqli_num_rows($result) == 0) {
    $no_data_message = "You don't have any PC in your website";
}
?>

<div class="container mt-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
            <li class="breadcrumb-item"><a href="#">Pre-Build PCs</a></li>
            <li class="breadcrumb-item active" aria-current="page">Delete Pre-Build PCs</li>
        </ol>
    </nav>
    <?php if (!empty($mess)): ?>
        <div style="text-align:center;" id="success-message" class="alert alert-danger">
            <?php echo $mess; ?>
        </div>
        <script>
            // Hide success message after 3 seconds
            setTimeout(function() {
                document.getElementById('success-message').style.display = 'none';
            }, 3000);
        </script>
    <?php endif; ?>
    <?php if (isset($no_data_message)): ?>
        <div style="text-align:center;" class="alert alert-info">
            <?php echo $no_data_message; ?>
        </div>
    <?php else: ?>
        <div class="row">
            <?php while ($rows = mysqli_fetch_array($result)): ?>
                <div class="col-md-4">
                    <div class="card" style="width: 18rem;">
                        <img height="100%" src="compimg/<?php echo $rows['final_img']?>" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $rows['build_name']?></h5>
                            <p class="card-text"><?php echo $rows['short_desc']?></p>
                            <a href="delprebuild.php?id=<?php echo $rows['pre_id']?>" class="btn btn-danger">Delete</a>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    <?php endif; ?>
</div>
<br><br><br><br><br><br><br><br><br><br><br><br>
<?php
include "shared/footer.php";
?>
