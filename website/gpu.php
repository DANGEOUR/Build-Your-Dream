<?php
include "shared/header.php";
include "shared/config.php";


$pid = isset($_GET['id']) ? mysqli_real_escape_string($conn, $_GET['id']) : '';


$gpu_query = "SELECT * FROM select_gpu WHERE id = '$pid'";
$gpu_result = mysqli_query($conn, $gpu_query);
$gpu_row = mysqli_fetch_assoc($gpu_result);
$gpu_name = $gpu_row ? $gpu_row['name'] : ''; 


$cpu_id = isset($_GET['c_id']) ? $_GET['c_id'] : '';
$cooler_id = isset($_GET['cooler_id']) ? $_GET['cooler_id'] : '';
$mb_id = isset($_GET['mb_id']) ? $_GET['mb_id'] : '';
$ram_id = isset($_GET['m_id']) ? $_GET['m_id'] : '';
$storage_id = isset($_GET['s_id']) ? $_GET['s_id'] : '';
$psu_id = isset($_GET['psu_id']) ? $_GET['psu_id'] : '';
$case_id = isset($_GET['case_id']) ? $_GET['case_id'] : '';

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
                        <a href="custombuild.php">Select GPU Brand</a>
                        <i class="material-icons md-18">chevron_right</i>
                    </li>
                    <li>GPU Selection</li>
                </ul>
            </div>
        </div>
    </div>
</nav>


<br><br><br><br>


<div class="container">
    <table class="table-bordered">
        <thead>
            <tr>
                <th>SR No.</th>
                <th>Image</th>
                <th>Name</th>
                <th>Manufacture</th>
                <th>Chipset</th>
                <th>Memory</th>
                <th>Core Clock</th>
                <th>Boost Clock</th>
                <th>Length</th>
                <th>Price</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php

            $sql = "SELECT * FROM gpu WHERE manufacture = '$gpu_name'";
            $result = mysqli_query($conn, $sql);
            $row_number = 1;
            while ($row = mysqli_fetch_assoc($result)) {
            ?>
                <tr>
                    <td><?php echo $row_number++; ?></td>
                    <td><img width="100" src="../AdminPanel/compimg/<?php echo $row['g_img']; ?>" alt="<?php echo $row['g_name']; ?>"></td>
                    <td><?php echo $row['g_name']; ?></td>
                    <td><?php echo $row['manufacture']; ?></td>
                    <td><?php echo $row['chipset']; ?></td>
                    <td><?php echo $row['memory']; ?></td>
                    <td><?php echo $row['core_clock']; ?></td>
                    <td><?php echo $row['boost_clock']; ?>W</td>
                    <td><?php echo $row['lenght']; ?></td>
                    <td>$<?php echo $row['g_price']; ?></td>
                    <td>
                        <a href="custombuild.php?g_id=<?php echo $row['g_id']; ?>&c_id=<?php echo $cpu_id; ?>&cooler_id=<?php echo $cooler_id; ?>&mb_id=<?php echo $mb_id; ?>&m_id=<?php echo $ram_id; ?>&s_id=<?php echo $storage_id; ?>&psu_id=<?php echo $psu_id; ?>&case_id=<?php echo $case_id; ?>" class="btn btn-border btn-with-icon btn-small ripple">
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

<br>
<br>
<br>
<br>
<br>
<br>
<br>
<?php
include "shared/footer.php";
?>
