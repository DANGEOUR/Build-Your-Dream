<?php 
$cooler_id = $_GET['id'];
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
                window.location.href = "showcooler.php";
            }, 500);
        }

        function previewImage() {
            var file = document.getElementById("img").files[0];
            var reader = new FileReader();
            reader.onloadend = function() {
                document.getElementById("cooler_img_preview").src = reader.result;
            }
            if (file) {
                reader.readAsDataURL(file);
            } else {
                document.getElementById("cooler_img_preview").src = "";
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

    if (isset($_POST['submit'])) {
        $g_name = $_POST['cooler'];
        $manufacture = $_POST['manufacture'];
        $chipset = $_POST['rpm'];
        $memory = $_POST['noiselvl'];
        $cl_speed = $_POST['color'];
        $lenght = $_POST['size'];
        $price = $_POST['price'];
        if (isset($_FILES['img'])) {
            $imagename = $_FILES['img']['name'];
            $imagetmpname = $_FILES['img']['tmp_name'];
            $imagesize = $_FILES['img']['size'];
            $imagetype = $_FILES['img']['type'];
            $imageerr = $_FILES['img']['error'];
            $allowedext = array("jpg", "png", "jpeg", "jfif", "gif");
            $ext = explode('.', $imagename);
            $imageext = strtolower(end($ext));
            if (in_array($imageext, $allowedext) === false) {
                $errors[] = "This extension isn't allowed";
            }
    
            if ($imagesize > 5242880) {
                $errors[] = "This file size isn't allowed";
            }
            move_uploaded_file($imagetmpname, "compimg/".$imagename);
        } else {
            $imagename = $_POST['existing_cpu_img'];
        }

        $sql = "UPDATE `cooler` SET `name`='$g_name',`manufacture`='$manufacture',`fanrpm`='$chipset',`noiselvl`='$memory',`color`='$cl_speed',`radiatorsize`='$lenght',`price`='$price',`img`='$imagename' WHERE `cooler_id` = $cooler_id";

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
                                <h4 class="card-title">Edit Cooler</h4>
                                <?php 
                                $fetch = "SELECT * FROM cooler WHERE cooler_id = $cooler_id";
                                $result = mysqli_query($conn, $fetch);
                                while($rows = mysqli_fetch_array($result)){
                                ?>
                                <form class="forms-sample" method="POST" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label for="cpuName">Cooler Name</label>
                                        <input type="text" class="form-control" name="cooler" placeholder="Cooler Name" required value="<?php echo $rows['cooler_name']?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="manufacture">Manufacture</label>
                                        <input value="<?php echo $rows['manufacture']?>" type="text" class="form-control" name="manufacture" placeholder="(eg Intel, AMD)" required oninput="this.value = this.value.toUpperCase()">
                                    </div>
                                    <div class="form-group">
                                        <label for="core_count">Fan RPM</label>
                                        <input type="text" class="form-control" name="rpm" placeholder="Fan RPM" required value="<?php echo $rows['fanrpm']?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="threads">Noise Level</label>
                                        <input type="text" class="form-control" name="noiselvl" placeholder="Noise Level" required value="<?php echo $rows['noiselvl']?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="c_speed">Color</label>
                                        <input type="text" class="form-control" name="color" placeholder="Color" required value="<?php echo $rows['color']?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="oc_speed">Radiator Size</label>
                                        <input type="text" class="form-control" name="size" placeholder="Radiator Size" required value="<?php echo $rows['radiatorsize']?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="price">Price</label>
                                        <input type="number" class="form-control" name="price" placeholder="CPU Price" required value="<?php echo $rows['cooler_price']?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="cpu_img">Cpoler Image</label>
                                        <input type="file" class="file-input" id="cpu_img" name="cpu_img" onchange="previewImage()">
                                        <input type="hidden" name="existing_cpu_img" value="<?php echo $rows['img']?>">
                                        <img id="cooler_img_preview" src="compimg/<?php echo $rows['img']; ?>" alt="CPU Image" style="width: 100px; height: auto;">
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

