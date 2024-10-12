<?php
include "shared/header.php";
include "shared/config.php";

$pid = isset($_GET['id']) ? mysqli_real_escape_string($conn, $_GET['id']) : '';


$cpu_query = "SELECT * FROM select_cpu WHERE id = '$pid'";
$cpu_result = mysqli_query($conn, $cpu_query);
$cpu_row = mysqli_fetch_assoc($cpu_result);
$cpu_name = $cpu_row ? $cpu_row['name'] : ''; 

$g_id = isset($_GET['g_id']) ? $_GET['g_id'] : '';
$cooler_id = isset($_GET['cooler_id']) ? $_GET['cooler_id'] : '';
$mb_id = isset($_GET['mb_id']) ? $_GET['mb_id'] : '';
$m_id = isset($_GET['m_id']) ? $_GET['m_id'] : '';
$s_id = isset($_GET['s_id']) ? $_GET['s_id'] : '';
$case_id = isset($_GET['case_id']) ? $_GET['case_id'] : '';
$psu_id = isset($_GET['psu_id']) ? $_GET['psu_id'] : '';
?>

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
                        <a href="custombuild.php">Custom PC Build</a>
                        <i class="material-icons md-18">chevron_right</i>
                    </li>
                    <li>
                        <a href="custombuild.php">Select CPU Brand</a>
                        <i class="material-icons md-18">chevron_right</i>
                    </li>
                    <li>CPU Selection</li>
                </ul>
            </div>
        </div>
    </div>
</nav>

<br><br><br><br>

<style>
    /* Your CSS styles here */
</style>

<div class="container">
<div class="table-responsive">
    <table class="table-bordered">
        <thead>
            <tr>
                <th>SR No.</th>
                <th>Image</th>
                <th>Name</th>
                <th>Manufacture</th>
                <th>Core Count</th>
                <th>Threads</th>
                <th>Core Clock</th>
                <th>Core Boost Clock</th>
                <th>TDP</th>
                <th>Integrated GPU</th>
                <th>Socket</th>
                <th>Price</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Fetch CPU details from the 'cpu' table based on 'manufacture'
            $sql = "SELECT * FROM cpu WHERE manufacture = '$cpu_name'";
            $result = mysqli_query($conn, $sql);
            $row_number = 1;
            while ($row = mysqli_fetch_assoc($result)) {
            ?>
                <tr>
                    <td><?php echo $row_number++; ?></td>
                    <td><img width="100" src="../AdminPanel/compimg/<?php echo $row['cpu_img']; ?>" alt="<?php echo $row['c_name']; ?>"></td>
                    <td><?php echo $row['c_name']; ?></td>
                    <td><?php echo $row['manufacture']; ?></td>
                    <td><?php echo $row['core_count']; ?></td>
                    <td><?php echo $row['threads']; ?></td>
                    <td><?php echo $row['core_clock']; ?></td>
                    <td><?php echo $row['core_boost_clock']; ?></td>
                    <td><?php echo $row['TDP']; ?>W</td>
                    <td><?php echo $row['int_gpu']; ?></td>
                    <td><?php echo $row['socket']; ?></td>
                    <td>$<?php echo $row['c_price']; ?></td>
                    <td>
                        <a href="custombuild.php?c_id=<?php echo $row['c_id']; ?>&cooler_id=<?php echo $cooler_id; ?>&mb_id=<?php echo $mb_id; ?>&m_id=<?php echo $m_id; ?>&s_id=<?php echo $s_id; ?>&g_id=<?php echo $g_id; ?>&case_id=<?php echo $case_id; ?>&psu_id=<?php echo $psu_id; ?>" class="btn btn-border btn-with-icon btn-small ripple">
                            <span>Add Component</span>
                            <svg class="btn-icon-right" viewBox="0 0 13 9" width="13" height="9">
                                <use xlink:href="assets/img/sprite.svg#arrow-right"></use>
                            </svg>
                        </a>
                    </td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
        </div>
</div>

<br>
<br>
<br>
<br>
<br>
<br>
<?php
include "shared/footer.php";
?>
