<?php
include "shared/header.php";
include "shared/config.php";
$message = "";

if(isset($_POST['submit'])){
    $g_name = $_POST['mbname'];
    $manufacture = $_POST['manufacture'];
    $chipset = $_POST['speed'];
    $memory = $_POST['modules'];
    $cl_speed = $_POST['color'];
    $lenght = $_POST['firstwordlatency'];
    $color = $_POST['CASlatency'];
    $price = $_POST['price'];
    if(isset($_FILES['img'])){
        $imagename = $_FILES['img']['name'];  
        $imagetmpname = $_FILES['img']['tmp_name'];
        $imagesize = $_FILES['img']['size'];
        $imagetype = $_FILES['img']['type'];
        $imageerr = $_FILES['img']['error'];
        $allowedext = array("jpg", "png", "jpeg", "jfif", "gif");
        $ext = explode('.', $imagename); 
        $imageext = strtolower(end($ext));   
        if(in_array($imageext, $allowedext) === false){
            $errors[] = "This extension isn't allowed";
        }

        if($imagesize > 5242880 ){    
            $errors[] = "This file size isn't allowed";
        }

        if(empty($errors) == true){
            move_uploaded_file($imagetmpname, "compimg/".$imagename);
            $sql = "INSERT INTO `memory`( `ram_name`, `manufacture`, `speed`, `modules`, `color`, `firstwordlatency`, `CASlatency`, `ram_price`, `img`) VALUES ('$g_name','$manufacture','$chipset','$memory','$cl_speed','$lenght','$color','$price','$imagename')";
            $query = mysqli_query($conn, $sql);
            if(!$query){
                die(mysqli_error($conn));
            } else {
                $message = "Memory is added";
            }
        }
    } 
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
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
</head>
<body>
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
                                <h4 class="card-title">Add Memory</h4>
                                <form class="forms-sample" method="POST" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label for="cpuName">Memory Name</label>
                                        <input type="text" class="form-control" name="mbname" placeholder="Board Name" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="cpuName">Manufacture</label>
                                        <input type="text" class="form-control" name="manufacture" placeholder="(eg Corsair, Teamgroup etc)" required oninput="this.value = this.value.toUpperCase()">
                                    </div>
                                    <div class="form-group">
                                        <label for="coolerName">Speed</label>
                                        <input type="text" class="form-control" name="speed" placeholder="(eg, DDR5-6000MHz etc)" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="coolerName">Modules</label>
                                        <input type="text" class="form-control" id="coolerName" name="modules" placeholder="(eg, 2x16GB, 4x16GB)" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="mbName">Color</label>
                                        <input type="text" class="form-control" id="mbName" name="color" placeholder="Color" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="mbName">First Word Latency</label>
                                        <input type="number" class="form-control" id="mbName" name="firstwordlatency" placeholder="First Word Latency" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="mbName">CAS Latency (ns)</label>
                                        <input type="number" class="form-control" id="mbName" name="CASlatency" placeholder="CAS Latency" required>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="psuName">Price</label>
                                        <input type="number" class="form-control" name="price" placeholder="Board Price" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="flImg">Board Image</label>
                                        <input type="file" class="file-input" name="img" placeholder="Cooler Image" required>
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
