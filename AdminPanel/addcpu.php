
    <style>
        .message {
            background-color: green;
            color: white;
            padding: 10px;
            margin-top: 10px;
            border-radius: 5px;
            text-align: center;
            font-weight: bold;
        }
    </style>
    <?php
    include "shared/header.php";
    include "shared/config.php";
    $message = "";

    if(isset($_POST['submit'])){
        $c_name=$_POST['cpu'];
        $manufacture=$_POST['manufacture'];
        $c_core=$_POST['core_count'];
        $threads=$_POST['threads'];
        $cl_speed=$_POST['c_speed'];
        $oc_speed=$_POST['oc_speed'];
        $tdp=$_POST['tdp'];
        $int_gpu=$_POST['int_gpu'];
        $socket=$_POST['socket'];
        $price=$_POST['price'];
        if(isset($_FILES['img'])){
          $imagename = $_FILES['img']['name'];  
          $imagetmpname = $_FILES['img']['tmp_name'];
          $imagesize = $_FILES['img']['size'];
          $imagetype = $_FILES['img']['type'];
          $imageerr = $_FILES['img']['error'];
          $allowedext = array("jpg", "png", "jpeg", "jfif", "gif");
          $ext = explode('.', $imagename); 
          $imageext=strtolower(end($ext));   
          if(in_array( $imageext,$allowedext )===false){
              $errors[]= "This extension isn't allowed";
          }

          if($imagesize > 5242880 ){    
              $errors[]= "This file size isn't allowed";
          }

          if(empty($errors)==true){
              move_uploaded_file($imagetmpname, "compimg/".$imagename);
              $sql = "INSERT INTO `cpu`( `c_name`,`manufacture`, `core_count`, `threads`, `core_clock`, `core_boost_clock`, `TDP`, `int_gpu`, `socket`, `c_price`, `cpu_img`, `type`) VALUES ('$c_name','$manufacture','$c_core','$threads','$cl_speed','$oc_speed','$tdp','$int_gpu','$socket','$price','$imagename','cpu')";
              $query= mysqli_query($conn, $sql);
              if(!$query){
                  die(mysqli_error($conn));
              } else {
                  $message = "CPU is added";
              }
          }
        } 
    }

    ?>

    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="container">
                    <div class="col-md-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                            <?php if ($message != ""): ?>
                    <div class="alert alert-success">
                        <?php echo $message; ?>
                    </div>
                <?php endif; ?>
                                <h4 class="card-title">Add CPU</h4>
                                <form class="forms-sample" method="POST" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label for="cpuName">CPU Name</label>
                                        <input type="text" class="form-control" name="cpu" placeholder="CPU Name" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="cpuName">Manufacture</label>
                                        <input type="text" class="form-control" name="manufacture" placeholder="(eg Intel, AMD)" required oninput="this.value = this.value.toUpperCase()">
                                    </div>
                                    <div class="form-group">
                                        <label for="coolerName">Core Count</label>
                                        <input type="number" class="form-control" name="core_count" placeholder="Core Count" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="coolerName">Threads</label>
                                        <input type="number" class="form-control" id="coolerName" name="threads" placeholder="Threads" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="mbName">Clock Speed</label>
                                        <input type="text" class="form-control" id="mbName" name="c_speed" placeholder="Clock Speed" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="ramName">Max OverClock Speed</label>
                                        <input type="text" class="form-control" name="oc_speed" placeholder="Max OverClock Speed" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="storageName">TDP</label>
                                        <input type="number" class="form-control" name="tdp" placeholder="Thermal Design Power" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="gpuName">Integrated Graphics</label>
                                        <input type="text" class="form-control" name="int_gpu" placeholder="Integrated Graphics" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="caseName">Socket</label>
                                        <input type="text" class="form-control" name="socket" placeholder="(eg AM5,AM4, etc)" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="psuName">Price</label>
                                        <input type="number" class="form-control" name="price" placeholder="CPU Price" required>
                                    </div>
                                    <div class="form-group">
    <label for="flImg">CPU Image</label>
    <input type="file" class="file-input" name="img" placeholder="Final look Image" required>
</div>
<style>
    .file-input {
        border: 1px solid #ced4da;
        border-radius: 4px;
        padding: 5px;
        width: 100%;
        box-sizing: border-box;
    }
    .file-input:focus {
        outline: none;
        border-color: #66afe9;
        box-shadow: 0 0 0 0.2rem rgba(38, 143, 255, 0.25);
    }
</style>
                                    <button type="submit" name="submit" class="btn btn-primary mr-2">Submit</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php
    include "shared/footer.php";
    ?>
</body>
</html>
