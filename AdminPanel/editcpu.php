<?php 
$c_id = $_GET['id'];
?>

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
    <script>
        function redirectToShowCPU() {
            setTimeout(function() {
                window.location.href = "showcpu.php";
            }, 500);
        }

        function previewImage() {
            var file = document.getElementById("cpu_img").files[0];
            var reader = new FileReader();
            reader.onloadend = function() {
                document.getElementById("cpu_img_preview").src = reader.result;
            }
            if (file) {
                reader.readAsDataURL(file);
            } else {
                document.getElementById("cpu_img_preview").src = "";
            }
        }
    </script>

    <?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    include "shared/header.php";
    include "shared/config.php";
    $message = "";

    if(isset($_POST['submit'])){
        $c_name = $_POST['cpu'];
        $manufacture = $_POST['manufacture'];
        $c_core = $_POST['core_count'];
        $threads = $_POST['threads'];
        $cl_speed = $_POST['c_speed'];
        $oc_speed = $_POST['oc_speed'];
        $tdp = $_POST['tdp'];
        $int_gpu = $_POST['int_gpu'];
        $socket = $_POST['socket'];
        $price = $_POST['price'];
        $imagename = $_FILES['cpu_img']['name'];

        if(!empty($imagename)){
            $imagetmpname = $_FILES['cpu_img']['tmp_name'];
            $imagesize = $_FILES['cpu_img']['size'];
            $imagetype = $_FILES['cpu_img']['type'];
            $imageerr = $_FILES['cpu_img']['error'];
            $allowedext = array("jpg", "png", "jpeg", "jfif", "gif");
            $ext = explode('.', $imagename); 
            $imageext = strtolower(end($ext));   
            if(in_array($imageext, $allowedext) === false){
                die("This extension isn't allowed");
            }
            if($imagesize > 5242880){    
                die("This file size isn't allowed");
            }
            move_uploaded_file($imagetmpname, "compimg/".$imagename);
        } else {
            $imagename = $_POST['existing_cpu_img'];
        }

        $sql = "UPDATE `cpu` SET 
            `c_name`='$c_name',
            `manufacture`='$manufacture',
            `core_count`='$c_core',
            `threads`='$threads',
            `core_clock`='$cl_speed',
            `core_boost_clock`='$oc_speed',
            `TDP`='$tdp',
            `int_gpu`='$int_gpu',
            `socket`='$socket',
            `c_price`='$price',
            `cpu_img`='$imagename' 
            WHERE c_id = $c_id";

        $query = mysqli_query($conn, $sql);
        if(!$query){
            die("Query Failed: " . mysqli_error($conn));
        } else {
            $message = "Changes Saved Successfully";
            echo '<script>redirectToShowCPU();</script>';
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
                                <h4 class="card-title">Edit CPU</h4>
                                <?php 
                                $fetch = "SELECT * FROM cpu WHERE c_id = $c_id";
                                $result = mysqli_query($conn, $fetch);
                                while($rows = mysqli_fetch_array($result)){
                                ?>
                                <form class="forms-sample" method="POST" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label for="cpuName">CPU Name</label>
                                        <input type="text" class="form-control" name="cpu" placeholder="CPU Name" required value="<?php echo $rows['c_name']?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="manufacture">Manufacture</label>
                                        <input value="<?php echo $rows['manufacture']?>" type="text" class="form-control" name="manufacture" placeholder="(eg Intel, AMD)" required oninput="this.value = this.value.toUpperCase()">
                                    </div>
                                    <div class="form-group">
                                        <label for="core_count">Core Count</label>
                                        <input type="number" class="form-control" name="core_count" placeholder="Core Count" required value="<?php echo $rows['core_count']?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="threads">Threads</label>
                                        <input type="number" class="form-control" name="threads" placeholder="Threads" required value="<?php echo $rows['threads']?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="c_speed">Clock Speed</label>
                                        <input type="text" class="form-control" name="c_speed" placeholder="Clock Speed" required value="<?php echo $rows['core_clock']?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="oc_speed">Max OverClock Speed</label>
                                        <input type="text" class="form-control" name="oc_speed" placeholder="Max OverClock Speed" required value="<?php echo $rows['core_boost_clock']?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="tdp">TDP</label>
                                        <input type="number" class="form-control" name="tdp" placeholder="Thermal Design Power" required value="<?php echo $rows['TDP']?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="int_gpu">Integrated Graphics</label>
                                        <input type="text" class="form-control" name="int_gpu" placeholder="Integrated Graphics" required value="<?php echo $rows['int_gpu']?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="socket">Socket</label>
                                        <input type="text" class="form-control" name="socket" placeholder="(eg AM5,AM4, etc)" required value="<?php echo $rows['socket']?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="price">Price</label>
                                        <input type="number" class="form-control" name="price" placeholder="CPU Price" required value="<?php echo $rows['c_price']?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="cpu_img">CPU Image</label>
                                        <input type="file" class="file-input" id="cpu_img" name="cpu_img" onchange="previewImage()">
                                        <input type="hidden" name="existing_cpu_img" value="<?php echo $rows['cpu_img']?>">
                                        <img id="cpu_img_preview" src="compimg/<?php echo $rows['cpu_img']; ?>" alt="CPU Image" style="width: 100px; height: auto;">
                                    </div>
                                    <button type="submit" name="submit" class="btn btn-primary mr-2">Submit</button>
                                </form>
                                <?php }?>
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

