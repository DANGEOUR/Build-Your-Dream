<?php
include "shared/header.php";
include "shared/config.php";
?>
  <div class="container mt-4">
  <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
        <li class="breadcrumb-item"><a href="#">Pre-Build PCs</a></li>
        <li class="breadcrumb-item active" aria-current="page">Edit Pre-Build PCs</li>
      </ol>
    </nav>
    <div class="row">
        <?php
        $sql= "SELECT * FROM pre_build";
        $result = mysqli_query($conn,$sql);
        while($rows = mysqli_fetch_array($result)){
        ?>
      <div class="col-md-4">
        <div class="card" style="width: 18rem;">
          <img height="100%" src="compimg/<?php echo $rows['final_img']?>" class="card-img-top" alt="...">
          <div class="card-body">
            <h5 class="card-title"><?php echo $rows['build_name']?></h5>
            <p class="card-text"><?php echo $rows['short_desc']?></p>
            <a href="editprebuild.php?id=<?php echo $rows['pre_id']?>" class="btn btn-primary">Edit</a>
          </div>
        </div>
      </div>
      <?php
        }
       ?>

    </div>
  </div>
  <br>
  <br>
  <br>
  <br>
  <br>
  <br>
  <br>
  <br>
  <br>
  <br>
  <br>
  <br><br>
  <br>
  <br>
  <br>
  <br><br>
  <br>
  <br>
  <br>
  <br>
  <br>
  <br>
<?php
include "shared/footer.php";
?>