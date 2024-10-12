<?php
session_start(); // Start session at the very beginning
ob_start(); // Start output buffering
$pre_id = $_GET['id'];
$message = '';
include "shared/config.php";
include "shared/header.php"; // Ensure this is included after session_start()

if (isset($_POST['submit'])) {
    $bname = $_POST['b_name'];
    $desc = addslashes($_POST['desc']);
    $cpu = $_POST['cpu'];
    $cpuPrice = $_POST['cpu_price'];
    $cooler = $_POST['cpu_cooler'];
    $coolerPrice = $_POST['cooler_price'];
    $mb = $_POST['motherboard'];
    $mbPrice = $_POST['mb_price'];
    $ram = $_POST['ram'];
    $ramPrice = $_POST['ram_price'];
    $storage = $_POST['storage'];
    $storagePrice = $_POST['storage_price'];
    $gpu = $_POST['gpu'];
    $gpuPrice = $_POST['gpu_price'];
    $case = $_POST['case'];
    $casePrice = $_POST['case_price'];
    $psu = $_POST['psu'];
    $psuPrice = $_POST['psu_price'];
    $price = $_POST['price'];

    // File upload handling function
    function handleFileUpload($fileField, $targetDirectory) {
        if (isset($_FILES[$fileField]) && $_FILES[$fileField]['error'] === UPLOAD_ERR_OK) {
            $imageName = $_FILES[$fileField]['name'];
            $imageTmpName = $_FILES[$fileField]['tmp_name'];
            $targetPath = $targetDirectory . basename($imageName);

            if (move_uploaded_file($imageTmpName, $targetPath)) {
                return $imageName;
            } else {
                return false;
            }
        }
        return false;
    }

    // Upload each component image
    $cpuImg = handleFileUpload('cpu_img', "compimg/") ?: $_POST['existing_cpu_img'];
    $coolerImg = handleFileUpload('cooler_img', "compimg/") ?: $_POST['existing_cooler_img'];
    $mbImg = handleFileUpload('mb_img', "compimg/") ?: $_POST['existing_mb_img'];
    $ramImg = handleFileUpload('ram_img', "compimg/") ?: $_POST['existing_ram_img'];
    $storageImg = handleFileUpload('storage_img', "compimg/") ?: $_POST['existing_storage_img'];
    $gpuImg = handleFileUpload('gpu_img', "compimg/") ?: $_POST['existing_gpu_img'];
    $caseImg = handleFileUpload('case_img', "compimg/") ?: $_POST['existing_case_img'];
    $psuImg = handleFileUpload('psu_img', "compimg/") ?: $_POST['existing_psu_img'];
    $flImg = handleFileUpload('fl_img', "compimg/") ?: $_POST['existing_fl_img'];

    // Insert into database using prepared statement
    $sql = "UPDATE pre_build SET 
        build_name=?, short_desc=?, CPU=?, cpu_price=?, cpu_img=?, 
        CpuCooler=?, cooler_price=?, cooler_img=?, MotherBoard=?, mb_price=?, mb_img=?, 
        Memory=?, ram_price=?, ram_img=?, storage=?, storage_price=?, storage_img=?, 
        GPU=?, gpu_price=?, gpu_img=?, pc_case=?, case_price=?, case_img=?, 
        PSU=?, psu_price=?, psu_img=?, final_img=?, price=? 
        WHERE pre_id=?";

    $stmt = mysqli_prepare($conn, $sql);

    // Corrected function usage
    if ($stmt) {
        mysqli_stmt_bind_param(
            $stmt,
            'sssississississississississii',
            $bname, $desc, $cpu, $cpuPrice, $cpuImg,
            $cooler, $coolerPrice, $coolerImg, $mb, $mbPrice, $mbImg,
            $ram, $ramPrice, $ramImg, $storage, $storagePrice, $storageImg,
            $gpu, $gpuPrice, $gpuImg, $case, $casePrice, $caseImg,
            $psu, $psuPrice, $psuImg, $flImg, $price, $pre_id
        );

        if (mysqli_stmt_execute($stmt)) {
            $message = "Changes Saved Successfully";
        } else {
            echo "Error updating record: " . mysqli_error($conn);
        }

        mysqli_stmt_close($stmt);
    } else {
        echo "Error preparing statement: " . mysqli_error($conn);
    }
}
?>

<!-- Add the PHP code as it is, then modify the HTML form section -->
<!-- partial -->
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
                            <h4 class="card-title">Edit Pre-Build PCs</h4>
                            <?php
                            if (isset($_SESSION['message'])) {
                                echo '<div class="alert alert-' . $_SESSION['message_type'] . '">' . $_SESSION['message'] . '</div>';
                                unset($_SESSION['message']);
                                unset($_SESSION['message_type']);
                            }
                            ?>
                            <?php 
                            $sql = "SELECT * FROM pre_build WHERE pre_id = $pre_id";
                            $result = mysqli_query($conn, $sql);
                            while ($rows = mysqli_fetch_array($result)) {
                            ?>
                            <form class="forms-sample" method="POST" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label for="exampleInputName1">Build Name</label>
                                    <input type="text" class="form-control" name="b_name" id="exampleInputName1" placeholder="Name" value="<?php echo $rows['build_name']?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="exampleTextarea1">Short Description</label>
                                    <textarea class="form-control" id="exampleTextarea1" rows="2" name="desc" required><?php echo $rows['short_desc']?></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="cpuName">CPU Name</label>
                                    <input type="text" class="form-control" id="cpuName" name="cpu" placeholder="CPU Name" required value="<?php echo $rows['CPU']?>">
                                </div>
                                <div class="form-group">
                                    <label for="cpuPrice">CPU Price</label>
                                    <input type="number" class="form-control" id="cpuPrice" name="cpu_price" placeholder="CPU price" required oninput="calculateTotalPrice()" value="<?php echo $rows['cpu_price']?>">
                                </div>
                                <div class="form-group">
                                    <label for="cpuImg">CPU Image</label>
                                    <input type="file" class="file-input" id="cpuImg" name="cpu_img" placeholder="CPU Image">
                                    <input type="hidden" name="existing_cpu_img" value="<?php echo $rows['cpu_img']?>">
                                    <?php if ($rows['cpu_img']) { ?>
                                        <img src="compimg/<?php echo $rows['cpu_img']; ?>" alt="CPU Image" style="width: 100px; height: auto;">
                                    <?php } ?>
                                </div>
                                <div class="form-group">
                                    <label for="coolerName">CPU Cooler Name</label>
                                    <input type="text" class="form-control" id="coolerName" name="cpu_cooler" placeholder="CPU Cooler" required value="<?php echo $rows['CpuCooler']?>">
                                </div>
                                <div class="form-group">
                                    <label for="coolerPrice">CPU Cooler Price</label>
                                    <input type="number" class="form-control" id="coolerPrice" name="cooler_price" placeholder="CPU Cooler price" required oninput="calculateTotalPrice()" value="<?php echo $rows['cooler_price']?>">
                                </div>
                                <div class="form-group">
                                    <label for="coolerImg">CPU Cooler Image</label>
                                    <input type="file" class="file-input" id="coolerImg" name="cooler_img" placeholder="Cooler Image">
                                    <input type="hidden" name="existing_cooler_img" value="<?php echo $rows['cooler_img']?>">
                                    <?php if ($rows['cooler_img']) { ?>
                                        <img src="compimg/<?php echo $rows['cooler_img']; ?>" alt="Cooler Image" style="width: 100px; height: auto;">
                                    <?php } ?>
                                </div>
                                <div class="form-group">
                                    <label for="mbName">Motherboard Name</label>
                                    <input type="text" class="form-control" id="mbName" name="motherboard" placeholder="Motherboard Name" required value="<?php echo $rows['MotherBoard']?>">
                                </div>
                                <div class="form-group">
                                    <label for="mbPrice">Motherboard Price</label>
                                    <input type="number" class="form-control" id="mbPrice" name="mb_price" placeholder="Motherboard price" required oninput="calculateTotalPrice()" value="<?php echo $rows['mb_price']?>">
                                </div>
                                <div class="form-group">
                                    <label for="mbImg">Motherboard Image</label>
                                    <input type="file" class="file-input" id="mbImg" name="mb_img" placeholder="Motherboard Image">
                                    <input type="hidden" name="existing_mb_img" value="<?php echo $rows['mb_img']?>">
                                    <?php if ($rows['mb_img']) { ?>
                                        <img src="compimg/<?php echo $rows['mb_img']; ?>" alt="Motherboard Image" style="width: 100px; height: auto;">
                                    <?php } ?>
                                </div>
                                <div class="form-group">
                                    <label for="ramName">RAM Name</label>
                                    <input type="text" class="form-control" id="ramName" name="ram" placeholder="RAM Name" required value="<?php echo $rows['Memory']?>">
                                </div>
                                <div class="form-group">
                                    <label for="ramPrice">RAM Price</label>
                                    <input type="number" class="form-control" id="ramPrice" name="ram_price" placeholder="RAM price" required oninput="calculateTotalPrice()" value="<?php echo $rows['ram_price']?>">
                                </div>
                                <div class="form-group">
                                    <label for="ramImg">RAM Image</label>
                                    <input type="file" class="file-input" id="ramImg" name="ram_img" placeholder="RAM Image">
                                    <input type="hidden" name="existing_ram_img" value="<?php echo $rows['ram_img']?>">
                                    <?php if ($rows['ram_img']) { ?>
                                        <img src="compimg/<?php echo $rows['ram_img']; ?>" alt="RAM Image" style="width: 100px; height: auto;">
                                    <?php } ?>
                                </div>
                                <div class="form-group">
                                    <label for="storageName">Storage Name</label>
                                    <input type="text" class="form-control" id="storageName" name="storage" placeholder="Storage Name" required value="<?php echo $rows['storage']?>">
                                </div>
                                <div class="form-group">
                                    <label for="storagePrice">Storage Price</label>
                                    <input type="number" class="form-control" id="storagePrice" name="storage_price" placeholder="Storage price" required oninput="calculateTotalPrice()" value="<?php echo $rows['storage_price']?>">
                                </div>
                                <div class="form-group">
                                    <label for="storageImg">Storage Image</label>
                                    <input type="file" class="file-input" id="storageImg" name="storage_img" placeholder="Storage Image">
                                    <input type="hidden" name="existing_storage_img" value="<?php echo $rows['storage_img']?>">
                                    <?php if ($rows['storage_img']) { ?>
                                        <img src="compimg/<?php echo $rows['storage_img']; ?>" alt="Storage Image" style="width: 100px; height: auto;">
                                    <?php } ?>
                                </div>
                                <div class="form-group">
                                    <label for="gpuName">GPU Name</label>
                                    <input type="text" class="form-control" id="gpuName" name="gpu" placeholder="GPU Name" required value="<?php echo $rows['GPU']?>">
                                </div>
                                <div class="form-group">
                                    <label for="gpuPrice">GPU Price</label>
                                    <input type="number" class="form-control" id="gpuPrice" name="gpu_price" placeholder="GPU price" required oninput="calculateTotalPrice()" value="<?php echo $rows['gpu_price']?>">
                                </div>
                                <div class="form-group">
                                    <label for="gpuImg">GPU Image</label>
                                    <input type="file" class="file-input" id="gpuImg" name="gpu_img" placeholder="GPU Image">
                                    <input type="hidden" name="existing_gpu_img" value="<?php echo $rows['gpu_img']?>">
                                    <?php if ($rows['gpu_img']) { ?>
                                        <img src="compimg/<?php echo $rows['gpu_img']; ?>" alt="GPU Image" style="width: 100px; height: auto;">
                                    <?php } ?>
                                </div>
                                <div class="form-group">
                                    <label for="caseName">Case Name</label>
                                    <input type="text" class="form-control" id="caseName" name="case" placeholder="Case Name" required value="<?php echo $rows['pc_case']?>">
                                </div>
                                <div class="form-group">
                                    <label for="casePrice">Case Price</label>
                                    <input type="number" class="form-control" id="casePrice" name="case_price" placeholder="Case price" required oninput="calculateTotalPrice()" value="<?php echo $rows['case_price']?>">
                                </div>
                                <div class="form-group">
                                    <label for="caseImg">Case Image</label>
                                    <input type="file" class="file-input" id="caseImg" name="case_img" placeholder="Case Image">
                                    <input type="hidden" name="existing_case_img" value="<?php echo $rows['case_img']?>">
                                    <?php if ($rows['case_img']) { ?>
                                        <img src="compimg/<?php echo $rows['case_img']; ?>" alt="Case Image" style="width: 100px; height: auto;">
                                    <?php } ?>
                                </div>
                                <div class="form-group">
                                    <label for="psuName">PSU Name</label>
                                    <input type="text" class="form-control" id="psuName" name="psu" placeholder="PSU Name" required value="<?php echo $rows['PSU']?>">
                                </div>
                                <div class="form-group">
                                    <label for="psuPrice">PSU Price</label>
                                    <input type="number" class="form-control" id="psuPrice" name="psu_price" placeholder="PSU price" required oninput="calculateTotalPrice()" value="<?php echo $rows['psu_price']?>">
                                </div>
                                <div class="form-group">
                                    <label for="psuImg">PSU Image</label>
                                    <input type="file" class="file-input" id="psuImg" name="psu_img" placeholder="PSU Image">
                                    <input type="hidden" name="existing_psu_img" value="<?php echo $rows['psu_img']?>">
                                    <?php if ($rows['psu_img']) { ?>
                                        <img src="compimg/<?php echo $rows['psu_img']; ?>" alt="PSU Image" style="width: 100px; height: auto;">
                                    <?php } ?>
                                </div>
                                <div class="form-group">
                                    <label for="flImg">Final Build Image</label>
                                    <input type="file" class="file-input" id="flImg" name="fl_img" placeholder="Final Image">
                                    <input type="hidden" name="existing_fl_img" value="<?php echo $rows['final_img']?>">
                                    <?php if ($rows['final_img']) { ?>
                                        <img src="compimg/<?php echo $rows['final_img']; ?>" alt="Final Build Image" style="width: 100px; height: auto;">
                                    <?php } ?>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputName1">Total Price</label>
                                    <input type="number" class="form-control" name="price" id="totalPrice" placeholder="Name" required value="<?php echo $rows['price']?>">
                                </div>
                                <button type="submit" name="submit" class="btn btn-primary me-2">Submit</button>
                                <button class="btn btn-light">Cancel</button>
                            </form>
                            <?php 
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function calculateTotalPrice() {
            var cpuPrice = parseFloat(document.getElementById('cpuPrice').value) || 0;
            var coolerPrice = parseFloat(document.getElementById('coolerPrice').value) || 0;
            var mbPrice = parseFloat(document.getElementById('mbPrice').value) || 0;
            var ramPrice = parseFloat(document.getElementById('ramPrice').value) || 0;
            var storagePrice = parseFloat(document.getElementById('storagePrice').value) || 0;
            var gpuPrice = parseFloat(document.getElementById('gpuPrice').value) || 0;
            var casePrice = parseFloat(document.getElementById('casePrice').value) || 0;
            var psuPrice = parseFloat(document.getElementById('psuPrice').value) || 0;
            var totalPrice = cpuPrice + coolerPrice + mbPrice + ramPrice + storagePrice + gpuPrice + casePrice + psuPrice;
            document.getElementById('totalPrice').value = totalPrice;
        }
    </script>
<?php 
include "shared/footer.php";
?>
