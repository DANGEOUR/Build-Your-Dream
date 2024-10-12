
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
        $g_name=$_POST['gpu'];
        $manufacture=$_POST['manufacture'];
        $chipset=$_POST['chipset'];
        $memory=$_POST['ram'];
        $cl_speed=$_POST['c_clock'];
        $oc_speed=$_POST['oc_speed'];
        $lenght=$_POST['lenght'];
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
              $sql = "INSERT INTO `gpu`( `g_name`,`manufacture`,`chipset`, `memory`,  `core_clock`, `boost_clock`, `lenght`, `g_price`, `g_img`) VALUES ('$g_name','$manufacture','$chipset','$memory','$cl_speed','$oc_speed','$lenght','$price','$imagename')";
              $query= mysqli_query($conn, $sql);
              if(!$query){
                  die(mysqli_error($conn));
              } else {
                  $message = "GPU is added";
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
                                <h4 class="card-title">Add GPU</h4>
                                <form class="forms-sample" method="POST" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label for="cpuName">GPU Name</label>
                                        <input type="text" class="form-control" name="gpu" placeholder="CPU Name" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="cpuName">Manufacture</label>
                                        <input type="text" class="form-control" name="manufacture" placeholder="(eg Navidia, AMD)" required oninput="this.value = this.value.toUpperCase()">
                                    </div>
                                    <div class="form-group">
                                        <label for="coolerName">Chipset</label>
                                        <input type="text" class="form-control" name="chipset" placeholder="Chipset" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="coolerName">Memory (GB)</label>
                                        <input type="number" class="form-control" id="coolerName" name="ram" placeholder="Memory" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="mbName">Core Clock</label>
                                        <input type="number" class="form-control" id="mbName" name="c_clock" placeholder="Core Clock" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="ramName">Max OverClock Speed</label>
                                        <input type="number" class="form-control" name="oc_speed" placeholder="Max OverClock Speed" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="storageName">Lenght(mm)</label>
                                        <input type="number" class="form-control" name="lenght" placeholder="Lenght in millimeter" required>
                                </div>
                                    <div class="form-group">
                                        <label for="psuName">Price</label>
                                        <input type="number" class="form-control" name="price" placeholder="GPU Price" required>
                                    </div>
                                    <div class="form-group">
    <label for="flImg">GPU Image</label>
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