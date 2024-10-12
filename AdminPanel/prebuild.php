<?php
 // Start session at the very beginning
ob_start(); // Start output buffering

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
    $cpuImg = handleFileUpload('cpu_img', "compimg/");
$coolerImg = handleFileUpload('cooler_img', "compimg/");
$mbImg = handleFileUpload('mb_img', "compimg/");
$ramImg = handleFileUpload('ram_img', "compimg/");
$storageImg = handleFileUpload('storage_img', "compimg/");
$gpuImg = handleFileUpload('gpu_img', "compimg/");
$caseImg = handleFileUpload('case_img', "compimg/");
$psuImg = handleFileUpload('psu_img', "compimg/");
$flImg = handleFileUpload('fl_img', "compimg/");

    // Insert into database using prepared statement
    $sql = "INSERT INTO `pre_build` (`build_name`, `short_desc`, `CPU`, `cpu_price`, `cpu_img`, `CpuCooler`, `cooler_price`, `cooler_img`, `MotherBoard`, `mb_price`, `mb_img`, `Memory`, `ram_price`, `ram_img`, `storage`, `storage_price`, `storage_img`, `GPU`, `gpu_price`, `gpu_img`, `pc_case`, `case_price`, `case_img`, `PSU`, `psu_price`, `psu_img`, `price`, `final_img`) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?)";

$stmt = mysqli_prepare($conn, $sql);

if (!$stmt) {
    die('Prepare failed: ' . mysqli_error($conn));
}

// Bind parameters
mysqli_stmt_bind_param($stmt, 'sssissississississississisis', $bname, $desc, $cpu, $cpuPrice, $cpuImg, $cooler, $coolerPrice, $coolerImg, $mb, $mbPrice, $mbImg, $ram, $ramPrice, $ramImg, $storage, $storagePrice, $storageImg, $gpu, $gpuPrice, $gpuImg, $case, $casePrice, $caseImg, $psu, $psuPrice, $psuImg, $price, $flImg);

// Execute statement
if (mysqli_stmt_execute($stmt)) {
    $_SESSION['message'] = "PC is added";
    $_SESSION['message_type'] = "success";
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
} else {
    die(mysqli_error($conn));
}

mysqli_stmt_close($stmt);
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
                            <h4 class="card-title">Add Pre-Build PCs</h4>
                            <?php
                            if (isset($_SESSION['message'])) {
                                echo '<div class="alert alert-' . $_SESSION['message_type'] . '">' . $_SESSION['message'] . '</div>';
                                unset($_SESSION['message']);
                                unset($_SESSION['message_type']);
                            }
                            ?>
                            <form class="forms-sample" method="POST" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label for="exampleInputName1">Build Name</label>
                                    <input type="text" class="form-control" name="b_name" id="exampleInputName1" placeholder="Name" required>
                                </div>
                                <div class="form-group">
                                    <label for="exampleTextarea1">Short Description</label>
                                    <textarea class="form-control" id="exampleTextarea1" rows="2" name="desc" required></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="cpuName">CPU Name</label>
                                    <input type="text" class="form-control" id="cpuName" name="cpu" placeholder="CPU Name" required>
                                </div>
                                <div class="form-group">
                                    <label for="cpuPrice">CPU Price</label>
                                    <input type="number" class="form-control" id="cpuPrice" name="cpu_price" placeholder="CPU price" required oninput="calculateTotalPrice()">
                                </div>
                                <div class="form-group">
                                    <label for="cpuImg">CPU Image</label>
                                    <input type="file" class="file-input" id="cpuImg" name="cpu_img" placeholder="CPU Image" required>
                                </div>
                                <div class="form-group">
                                    <label for="coolerName">CPU Cooler Name</label>
                                    <input type="text" class="form-control" id="coolerName" name="cpu_cooler" placeholder="CPU Cooler" required>
                                </div>
                                <div class="form-group">
                                    <label for="coolerPrice">CPU Cooler Price</label>
                                    <input type="number" class="form-control" id="coolerPrice" name="cooler_price" placeholder="CPU Cooler price" required oninput="calculateTotalPrice()">
                                </div>
                                <div class="form-group">
                                    <label for="coolerImg">CPU Cooler Image</label>
                                    <input type="file" class="file-input" id="coolerImg" name="cooler_img" placeholder="Cooler Image" required>
                                </div>
                                <div class="form-group">
                                    <label for="mbName">Motherboard Name</label>
                                    <input type="text" class="form-control" id="mbName" name="motherboard" placeholder="Motherboard" required>
                                </div>
                                <div class="form-group">
                                    <label for="mbPrice">Motherboard Price</label>
                                    <input type="number" class="form-control" id="mbPrice" name="mb_price" placeholder="Motherboard price" required oninput="calculateTotalPrice()">
                                </div>
                                <div class="form-group">
                                    <label for="mbImg">Motherboard Image</label>
                                    <input type="file" class="file-input" id="mbImg" name="mb_img" placeholder="Motherboard Image" required>
                                </div>
                                <div class="form-group">
                                    <label for="ramName">RAM Name</label>
                                    <input type="text" class="form-control" id="ramName" name="ram" placeholder="RAM" required>
                                </div>
                                <div class="form-group">
                                    <label for="ramPrice">RAM Price</label>
                                    <input type="number" class="form-control" id="ramPrice" name="ram_price" placeholder="RAM price" required oninput="calculateTotalPrice()">
                                </div>
                                <div class="form-group">
                                    <label for="ramImg">RAM Image</label>
                                    <input type="file" class="file-input" id="ramImg" name="ram_img" placeholder="RAM Image" required>
                                </div>
                                <div class="form-group">
                                    <label for="storageName">Storage Name</label>
                                    <input type="text" class="form-control" id="storageName" name="storage" placeholder="Storage" required>
                                </div>
                                <div class="form-group">
                                    <label for="storagePrice">Storage Price</label>
                                    <input type="number" class="form-control" id="storagePrice" name="storage_price" placeholder="Storage price" required oninput="calculateTotalPrice()">
                                </div>
                                <div class="form-group">
                                    <label for="storageImg">Storage Image</label>
                                    <input type="file" class="file-input" id="storageImg" name="storage_img" placeholder="Storage Image" required>
                                </div>
                                <div class="form-group">
                                    <label for="gpuName">GPU Name</label>
                                    <input type="text" class="form-control" id="gpuName" name="gpu" placeholder="GPU" required>
                                </div>
                                <div class="form-group">
                                    <label for="gpuPrice">GPU Price</label>
                                    <input type="number" class="form-control" id="gpuPrice" name="gpu_price" placeholder="GPU price" required oninput="calculateTotalPrice()">
                                </div>
                                <div class="form-group">
                                    <label for="gpuImg">GPU Image</label>
                                    <input type="file" class="file-input" id="gpuImg" name="gpu_img" placeholder="GPU Image" required>
                                </div>
                                <div class="form-group">
                                    <label for="caseName">PC Case Name</label>
                                    <input type="text" class="form-control" id="caseName" name="case" placeholder="PC Case" required>
                                </div>
                                <div class="form-group">
                                    <label for="casePrice">PC Case Price</label>
                                    <input type="number" class="form-control" id="casePrice" name="case_price" placeholder="Case price" required oninput="calculateTotalPrice()">
                                </div>
                                <div class="form-group">
                                    <label for="caseImg">PC Case Image</label>
                                    <input type="file" class="file-input" id="caseImg" name="case_img" placeholder="Case Image" required>
                                </div>
                                <div class="form-group">
                                    <label for="psuName">PSU Name</label>
                                    <input type="text" class="form-control" id="psuName" name="psu" placeholder="PSU" required>
                                </div>
                                <div class="form-group">
                                    <label for="psuPrice">PSU Price</label>
                                    <input type="number" class="form-control" id="psuPrice" name="psu_price" placeholder="PSU price" required oninput="calculateTotalPrice()">
                                </div>
                                <div class="form-group">
                                    <label for="psuImg">PSU Image</label>
                                    <input type="file" class="file-input" id="psuImg" name="psu_img" placeholder="PSU Image" required>
                                </div>
                                <div class="form-group">
                                    <label for="price">Total Price</label>
                                    <input type="number" class="form-control" id="price" name="price" placeholder="Total price" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="flImg">Final Look Image</label>
                                    <input type="file" class="file-input" id="flImg" name="fl_img" placeholder="Final look Image" required>
                                </div>
                                <button type="submit" name="submit" class="btn btn-primary mr-2">Submit</button>
                            </form>
                            <script>
                                function calculateTotalPrice() {
                                    const cpuPrice = parseFloat(document.getElementById('cpuPrice').value) || 0;
                                    const coolerPrice = parseFloat(document.getElementById('coolerPrice').value) || 0;
                                    const mbPrice = parseFloat(document.getElementById('mbPrice').value) || 0;
                                    const ramPrice = parseFloat(document.getElementById('ramPrice').value) || 0;
                                    const storagePrice = parseFloat(document.getElementById('storagePrice').value) || 0;
                                    const gpuPrice = parseFloat(document.getElementById('gpuPrice').value) || 0;
                                    const casePrice = parseFloat(document.getElementById('casePrice').value) || 0;
                                    const psuPrice = parseFloat(document.getElementById('psuPrice').value) || 0;

                                    const totalPrice = cpuPrice + coolerPrice + mbPrice + ramPrice + storagePrice + gpuPrice + casePrice + psuPrice;
                                    document.getElementById('price').value = totalPrice.toFixed(2);
                                }
                            </script>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
<?php
include "shared/footer.php";
ob_end_flush();
?>