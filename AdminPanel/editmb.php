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
                window.location.href = "showmb.php";
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

        $sql = "UPDATE `motherboard` SET 
            `mb_name`='$c_name',
            `mb_manufacture`='$manufacture',
            `socket`='$c_core',
            `Form Factor`='$threads',
            `maxram`='$cl_speed',
            `slots`='$oc_speed',
            `color`='$tdp',
            `mb_price`='$price',
            `img`='$imagename' 
            WHERE mb_id = $c_id";

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
                                <h4 class="card-title">Edit motherboard</h4>
                                <?php 
                                $fetch = "SELECT * FROM motherboard WHERE mb_id = $c_id";
                                $result = mysqli_query($conn, $fetch);
                                while($rows = mysqli_fetch_array($result)){
                                ?>
                                <form class="forms-sample" method="POST" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label for="cpuName">MotherBoard Name</label>
                                        <input type="text" class="form-control" name="cpu" placeholder="CPU Name" required value="<?php echo $rows['mb_name']?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="manufacture">Manufacture</label>
                                        <input value="<?php echo $rows['mb_manufacture']?>" type="text" class="form-control" name="manufacture" placeholder="(eg Intel, AMD)" required oninput="this.value = this.value.toUpperCase()">
                                    </div>
                                    <div class="form-group">
                                        <label for="core_count">Socket</label>
                                        <input type="text" class="form-control" name="core_count" placeholder="Core Count" required value="<?php echo $rows['socket']?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="threads">Form Factor</label>
                                        <input type="text" class="form-control" name="threads" placeholder="Threads" required value="<?php echo $rows['Form Factor']?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="c_speed">Max Ram</label>
                                        <input type="number" class="form-control" name="c_speed" placeholder="Clock Speed" required value="<?php echo $rows['maxram']?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="oc_speed">Slots</label>
                                        <input type="number" class="form-control" name="oc_speed" placeholder="Max OverClock Speed" required value="<?php echo $rows['slots']?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="tdp">Color</label>
                                        <input type="text" class="form-control" name="tdp" placeholder="Thermal Design Power" required value="<?php echo $rows['color']?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="price">Price</label>
                                        <input type="number" class="form-control" name="price" placeholder="CPU Price" required value="<?php echo $rows['mb_price']?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="cpu_img">MotherBoard Image</label>
                                        <input type="file" class="file-input" id="cpu_img" name="cpu_img" onchange="previewImage()">
                                        <input type="hidden" name="existing_cpu_img" value="<?php echo $rows['img']?>">
                                        <img id="cpu_img_preview" src="compimg/<?php echo $rows['img']; ?>" alt="CPU Image" style="width: 100px; height: auto;">
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

