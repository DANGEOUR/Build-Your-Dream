<?php
include "shared/header.php";
include "shared/config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['gpu_id'])) {
    $gpu_id = $_POST['gpu_id'];
    header("Location: custombuild.php?g_id=$gpu_id");
    exit();
}
$c_id = isset($_GET['c_id']) ? $_GET['c_id'] : '';
$cooler_id = isset($_GET['cooler_id']) ? $_GET['cooler_id'] : '';
$mb_id = isset($_GET['mb_id']) ? $_GET['mb_id'] : '';
$m_id = isset($_GET['m_id']) ? $_GET['m_id'] : '';
$s_id = isset($_GET['s_id']) ? $_GET['s_id'] : '';
$g_id = isset($_GET['g_id']) ? $_GET['g_id'] : '';
$case_id = isset($_GET['case_id']) ? $_GET['case_id'] : '';
$psu_id = isset($_GET['psu_id']) ? $_GET['psu_id'] : '';
?>

<style>
body {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
    background-color: #f0f0f0;
}

.container {
    display: flex;
    gap: 20px; 
}

.image-wrapper {
    flex: 1; 
    display: flex;
    justify-content: center;
    align-items: center;
    border-radius: 30px;
    overflow: hidden; 
}

.image {
    width: 100%; 
    height: auto;
    max-height: 200px; 
}
</style>

<nav class="bread-crumbs">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <ul class="bread-crumbs-list">
                    <li>
                        <a href="index.php">Home</a>
                        <i class="material-icons md-18">chevron_right</i>
                    </li>
                    <li>
                        <a href="custombuild.php">Custom Build</a>
                        <i class="material-icons md-18">chevron_right</i>
                    </li>
                    <li>
                        Select GPU Brand
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>

<br><br><br><br>

<div class="section-heading heading-center">
    <div class="section-subheading">GPU Brand</div>
    <h1>Select Your GPU Brand</h1>
</div>

<div class="container">
    <?php
    $sql = "SELECT * FROM `select_gpu` LIMIT 2";
    $result = mysqli_query($conn, $sql);

    $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);

    if (count($rows) >= 2) {
    ?>
        <div class="image-wrapper">
            <a href="gpu.php?id=<?php echo $rows[0]['id']; ?>&c_id=<?php echo $c_id; ?>&cooler_id=<?php echo $cooler_id; ?>&mb_id=<?php echo $mb_id; ?>&m_id=<?php echo $m_id; ?>&s_id=<?php echo $s_id; ?>&g_id=<?php echo $g_id; ?>&case_id=<?php echo $case_id; ?>&psu_id=<?php echo $psu_id; ?>">
                <img src="https://www.logo.wine/a/logo/Nvidia/Nvidia-Vertical-Black-Logo.wine.svg" alt="Nvidia Logo" class="image">
            </a>
        </div>
        <div class="image-wrapper">
            <a href="gpu.php?id=<?php echo $rows[1]['id']; ?>&c_id=<?php echo $c_id; ?>&cooler_id=<?php echo $cooler_id; ?>&mb_id=<?php echo $mb_id; ?>&m_id=<?php echo $m_id; ?>&s_id=<?php echo $s_id; ?>&g_id=<?php echo $g_id; ?>&case_id=<?php echo $case_id; ?>&psu_id=<?php echo $psu_id; ?>">
                <img src="https://seeklogo.com/images/A/AMD-logo-B5E0D58D48-seeklogo.com.png" alt="AMD Logo" class="image">
            </a>
        </div>
    <?php
    }
    ?>
</div>

<br><br><br><br><br>
<br>
<br>

<?php
include "shared/footer.php";
?>
