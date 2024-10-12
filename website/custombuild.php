<?php
include "shared/header.php";
include "shared/config.php";

// Determine if the user is logged in
$is_logged_in = isset($_SESSION['username']) && !empty($_SESSION['username']);
$c_id = isset($_GET['c_id']) ? $_GET['c_id'] : '';
$cooler_id = isset($_GET['cooler_id']) ? $_GET['cooler_id'] : '';
$mb_id = isset($_GET['mb_id']) ? $_GET['mb_id'] : '';
$m_id = isset($_GET['m_id']) ? $_GET['m_id'] : '';
$s_id = isset($_GET['s_id']) ? $_GET['s_id'] : '';
$g_id = isset($_GET['g_id']) ? $_GET['g_id'] : '';
$case_id = isset($_GET['case_id']) ? $_GET['case_id'] : '';
$psu_id = isset($_GET['psu_id']) ? $_GET['psu_id'] : '';

$total_price = 0;
?>

<nav class="bread-crumbs">
  <!-- ... -->
</nav>
<br>
<br>
<br>
<br>
<br>
<div class="container">
<div class="table-responsive">
    <table class="table-bordered">
        <thead>
            <tr>
                <th>Items</th>
                <th>Image</th>
                <th>Name</th>
                <th>Manufacture</th>
                <th>Price</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <!-- CPU Section -->
            <?php
            $sql_cpu = "SELECT * FROM `cpu` WHERE c_id = '$c_id'";
            $result_cpu = mysqli_query($conn, $sql_cpu);

            if (!$result_cpu) {
                die('SQL Error: ' . mysqli_error($conn));
            }

            if (mysqli_num_rows($result_cpu) > 0) {
                while ($rows = mysqli_fetch_array($result_cpu)) {
                    $total_price += $rows['c_price'];
            ?>
                    <tr>
                        <td>CPU</td>
                        <td><img width="100" src="../AdminPanel/compimg/<?php echo $rows['cpu_img'] ?>" alt=""></td>
                        <td><?php echo isset($rows['c_name']) ? $rows['c_name'] : 'NULL'; ?></td>
                        <td><?php echo isset($rows['manufacture']) ? $rows['manufacture'] : 'NULL'; ?></td>
                        <td><?php echo isset($rows['c_price']) ? '$' . $rows['c_price'] : 'NULL'; ?></td>
                        <td>
                            <a href="selectcpu.php?c_id=<?php echo $c_id; ?>&cooler_id=<?php echo $cooler_id; ?>&mb_id=<?php echo $mb_id; ?>&m_id=<?php echo $m_id; ?>&s_id=<?php echo $s_id; ?>&g_id=<?php echo $g_id; ?>&case_id=<?php echo $case_id; ?>&psu_id=<?php echo $psu_id; ?>" class="btn btn-border btn-with-icon btn-small ripple">
                                <span>Change Component</span>
                                <svg class="btn-icon-right" viewBox="0 0 13 9" width="13" height="9">
                                    <use xlink:href="assets/img/sprite.svg#arrow-right"></use>
                                </svg>
                            </a>
                        </td>
                    </tr>
            <?php
                }
            } else {
            ?>
                <tr>
                    <td colspan="5">No CPU selected</td>
                    <td>
                        <a href="selectcpu.php?c_id=<?php echo $c_id; ?>&g_id=<?php echo $g_id; ?>&cooler_id=<?php echo $cooler_id; ?>&mb_id=<?php echo $mb_id; ?>&m_id=<?php echo $m_id; ?>&s_id=<?php echo $s_id; ?>&case_id=<?php echo $case_id; ?>&psu_id=<?php echo $psu_id; ?>" class="btn btn-border btn-with-icon btn-small ripple">
                            <span>Select Component</span>
                            <svg class="btn-icon-right" viewBox="0 0 13 9" width="13" height="9">
                                <use xlink:href="assets/img/sprite.svg#arrow-right"></use>
                            </svg>
                        </a>
                    </td>
                </tr>
            <?php
            }
            ?>
            
            <!-- CPU Cooler Section -->
            <?php
            $sql_cooler = "SELECT * FROM `cooler` WHERE cooler_id = '$cooler_id'";
            $result_cooler = mysqli_query($conn, $sql_cooler);

            if (!$result_cooler) {
                die('SQL Error: ' . mysqli_error($conn));
            }

            if (mysqli_num_rows($result_cooler) > 0) {
                while ($rowscooler = mysqli_fetch_array($result_cooler)) {
                    $total_price += $rowscooler['cooler_price'];
            ?>
                    <tr>
                        <td>CPU Cooler</td>
                        <td><img width="100" src="../AdminPanel/compimg/<?php echo $rowscooler['img'] ?>" alt=""></td>
                        <td><?php echo isset($rowscooler['cooler_name']) ? $rowscooler['cooler_name'] : 'NULL'; ?></td>
                        <td><?php echo isset($rowscooler['manufacture']) ? $rowscooler['manufacture'] : 'NULL'; ?></td>
                        <td><?php echo isset($rowscooler['cooler_price']) ? '$' . $rowscooler['cooler_price'] : 'NULL'; ?></td>
                        <td>
                            <a href="selectcooler.php?cooler_id=<?php echo $cooler_id; ?>&g_id=<?php echo $g_id; ?>&c_id=<?php echo $c_id; ?>&mb_id=<?php echo $mb_id; ?>&m_id=<?php echo $m_id; ?>&s_id=<?php echo $s_id; ?>&case_id=<?php echo $case_id; ?>&psu_id=<?php echo $psu_id; ?>" class="btn btn-border btn-with-icon btn-small ripple">
                                <span>Change Component</span>
                                <svg class="btn-icon-right" viewBox="0 0 13 9" width="13" height="9">
                                    <use xlink:href="assets/img/sprite.svg#arrow-right"></use>
                                </svg>
                            </a>
                        </td>
                    </tr>
            <?php
                }
            } else {
            ?>
                <tr>
                    <td colspan="5">No CPU Cooler selected</td>
                    <td>
                        <a href="selectcooler.php?cooler_id=<?php echo $cooler_id; ?>&g_id=<?php echo $g_id; ?>&c_id=<?php echo $c_id; ?>&mb_id=<?php echo $mb_id; ?>&m_id=<?php echo $m_id; ?>&s_id=<?php echo $s_id; ?>&case_id=<?php echo $case_id; ?>&psu_id=<?php echo $psu_id; ?>" class="btn btn-border btn-with-icon btn-small ripple">
                            <span>Select Component</span>
                            <svg class="btn-icon-right" viewBox="0 0 13 9" width="13" height="9">
                                <use xlink:href="assets/img/sprite.svg#arrow-right"></use>
                            </svg>
                        </a>
                    </td>
                </tr>
            <?php
            }
            ?>
            
            <!-- Motherboard Section -->
            <?php
            $sql_mb = "SELECT * FROM `motherboard` WHERE mb_id = '$mb_id'";
            $result_mb = mysqli_query($conn, $sql_mb);

            if (!$result_mb) {
                die('SQL Error: ' . mysqli_error($conn));
            }

            if (mysqli_num_rows($result_mb) > 0) {
                while ($rowsmb = mysqli_fetch_array($result_mb)) {
                    $total_price += $rowsmb['mb_price'];
            ?>
                    <tr>
                        <td>MotherBoard</td>
                        <td><img width="100" src="../AdminPanel/compimg/<?php echo $rowsmb['img'] ?>" alt=""></td>
                        <td><?php echo isset($rowsmb['mb_name']) ? $rowsmb['mb_name'] : 'NULL'; ?></td>
                        <td><?php echo isset($rowsmb['mb_manufacture']) ? $rowsmb['mb_manufacture'] : 'NULL'; ?></td>
                        <td><?php echo isset($rowsmb['mb_price']) ? '$' . $rowsmb['mb_price'] : 'NULL'; ?></td>
                        <td>
                            <a href="selectmotherboard.php?mb_id=<?php echo $mb_id; ?>&c_id=<?php echo $c_id; ?>&g_id=<?php echo $g_id; ?>&cooler_id=<?php echo $cooler_id; ?>&m_id=<?php echo $m_id; ?>&s_id=<?php echo $s_id; ?>&case_id=<?php echo $case_id; ?>&psu_id=<?php echo $psu_id; ?>" class="btn btn-border btn-with-icon btn-small ripple">
                                <span>Change Component</span>
                                <svg class="btn-icon-right" viewBox="0 0 13 9" width="13" height="9">
                                    <use xlink:href="assets/img/sprite.svg#arrow-right"></use>
                                </svg>
                            </a>
                        </td>
                    </tr>
            <?php
                }
            } else {
            ?>
                <tr>
                    <td colspan="5">No Motherboard selected</td>
                    <td>
                        <a href="selectmotherboard.php?mb_id=<?php echo $mb_id; ?>&c_id=<?php echo $c_id; ?>&g_id=<?php echo $g_id; ?>&cooler_id=<?php echo $cooler_id; ?>&m_id=<?php echo $m_id; ?>&s_id=<?php echo $s_id; ?>&case_id=<?php echo $case_id; ?>&psu_id=<?php echo $psu_id; ?>" class="btn btn-border btn-with-icon btn-small ripple">
                            <span>Select Component</span>
                            <svg class="btn-icon-right" viewBox="0 0 13 9" width="13" height="9">
                                <use xlink:href="assets/img/sprite.svg#arrow-right"></use>
                            </svg>
                        </a>
                    </td>
                </tr>
            <?php
            }
            ?>

            <!-- Memory Section -->
            <?php
            $sql_memory = "SELECT * FROM `memory` WHERE m_id = '$m_id'";
            $result_memory = mysqli_query($conn, $sql_memory);

            if (!$result_memory) {
                die('SQL Error: ' . mysqli_error($conn));
            }

            if (mysqli_num_rows($result_memory) > 0) {
                while ($rowsmem = mysqli_fetch_array($result_memory)) {
                    $total_price += $rowsmem['ram_price'];
            ?>
                    <tr>
                        <td>Memory</td>
                        <td><img width="100" src="../AdminPanel/compimg/<?php echo $rowsmem['img'] ?>" alt=""></td>
                        <td><?php echo isset($rowsmem['ram_name']) ? $rowsmem['ram_name'] : 'NULL'; ?></td>
                        <td><?php echo isset($rowsmem['manufacture']) ? $rowsmem['manufacture'] : 'NULL'; ?></td>
                        <td><?php echo isset($rowsmem['ram_price']) ? '$' . $rowsmem['ram_price'] : 'NULL'; ?></td>
                        <td>
                            <a href="selectmemory.php?m_id=<?php echo $m_id; ?>&c_id=<?php echo $c_id; ?>&g_id=<?php echo $g_id; ?>&cooler_id=<?php echo $cooler_id; ?>&mb_id=<?php echo $mb_id; ?>&s_id=<?php echo $s_id; ?>&case_id=<?php echo $case_id; ?>&psu_id=<?php echo $psu_id; ?>" class="btn btn-border btn-with-icon btn-small ripple">
                                <span>Change Component</span>
                                <svg class="btn-icon-right" viewBox="0 0 13 9" width="13" height="9">
                                    <use xlink:href="assets/img/sprite.svg#arrow-right"></use>
                                </svg>
                            </a>
                        </td>
                    </tr>
            <?php
                }
            } else {
            ?>
                <tr>
                    <td colspan="5">No Memory selected</td>
                    <td>
                        <a href="selectmemory.php?m_id=<?php echo $m_id; ?>&c_id=<?php echo $c_id; ?>&g_id=<?php echo $g_id; ?>&cooler_id=<?php echo $cooler_id; ?>&mb_id=<?php echo $mb_id; ?>&s_id=<?php echo $s_id; ?>&case_id=<?php echo $case_id; ?>&psu_id=<?php echo $psu_id; ?>" class="btn btn-border btn-with-icon btn-small ripple">
                            <span>Select Component</span>
                            <svg class="btn-icon-right" viewBox="0 0 13 9" width="13" height="9">
                                <use xlink:href="assets/img/sprite.svg#arrow-right"></use>
                            </svg>
                        </a>
                    </td>
                </tr>
            <?php
            }
            ?>

            <!-- Storage Section -->
            <?php
            $sql_storage = "SELECT * FROM `storage` WHERE s_id = '$s_id'";
            $result_storage = mysqli_query($conn, $sql_storage);

            if (!$result_storage) {
                die('SQL Error: ' . mysqli_error($conn));
            }

            if (mysqli_num_rows($result_storage) > 0) {
                while ($rowsstor = mysqli_fetch_array($result_storage)) {
                    $total_price += $rowsstor['s_price'];
            ?>
                    <tr>
                        <td>Storage</td>
                        <td><img width="100" src="../AdminPanel/compimg/<?php echo $rowsstor['img'] ?>" alt=""></td>
                        <td><?php echo isset($rowsstor['s_name']) ? $rowsstor['s_name'] : 'NULL'; ?></td>
                        <td><?php echo isset($rowsstor['manufacture']) ? $rowsstor['manufacture'] : 'NULL'; ?></td>
                        <td><?php echo isset($rowsstor['s_price']) ? '$' . $rowsstor['s_price'] : 'NULL'; ?></td>
                        <td>
                            <a href="selectstorage.php?s_id=<?php echo $s_id; ?>&c_id=<?php echo $c_id; ?>&g_id=<?php echo $g_id; ?>&cooler_id=<?php echo $cooler_id; ?>&mb_id=<?php echo $mb_id; ?>&m_id=<?php echo $m_id; ?>&case_id=<?php echo $case_id; ?>&psu_id=<?php echo $psu_id; ?>" class="btn btn-border btn-with-icon btn-small ripple">
                                <span>Change Component</span>
                                <svg class="btn-icon-right" viewBox="0 0 13 9" width="13" height="9">
                                    <use xlink:href="assets/img/sprite.svg#arrow-right"></use>
                                </svg>
                            </a>
                        </td>
                    </tr>
            <?php
                }
            } else {
            ?>
                <tr>
                    <td colspan="5">No Storage selected</td>
                    <td>
                        <a href="selectstorage.php?s_id=<?php echo $s_id; ?>&c_id=<?php echo $c_id; ?>&g_id=<?php echo $g_id; ?>&cooler_id=<?php echo $cooler_id; ?>&mb_id=<?php echo $mb_id; ?>&m_id=<?php echo $m_id; ?>&case_id=<?php echo $case_id; ?>&psu_id=<?php echo $psu_id; ?>" class="btn btn-border btn-with-icon btn-small ripple">
                            <span>Select Component</span>
                            <svg class="btn-icon-right" viewBox="0 0 13 9" width="13" height="9">
                                <use xlink:href="assets/img/sprite.svg#arrow-right"></use>
                            </svg>
                        </a>
                    </td>
                </tr>
            <?php
            }
            ?>
 <!-- CPU Section -->
 <?php
            $sql_gpu = "SELECT * FROM `gpu` WHERE g_id = '$g_id'";
            $result_gpu = mysqli_query($conn, $sql_gpu);

            if (!$result_gpu) {
                die('SQL Error: ' . mysqli_error($conn));
            }

            if (mysqli_num_rows($result_gpu) > 0) {
                while ($rgpu = mysqli_fetch_array($result_gpu)) {
                    $total_price += $rgpu['g_price'];
            ?>
                    <tr>
                        <td>Storage</td>
                        <td><img width="100" src="../AdminPanel/compimg/<?php echo $rgpu['g_img'] ?>" alt=""></td>
                        <td><?php echo isset($rgpu['chipset']) ? $rgpu['chipset'] : 'NULL'; ?></td>
                        <td><?php echo isset($rgpu['manufacture']) ? $rgpu['manufacture'] : 'NULL'; ?></td>
                        <td><?php echo isset($rgpu['g_price']) ? '$' . $rgpu['g_price'] : 'NULL'; ?></td>
                        <td>
                            <a href="selectgpu.php?s_id=<?php echo $s_id; ?>&c_id=<?php echo $c_id; ?>&g_id=<?php echo $g_id; ?>&cooler_id=<?php echo $cooler_id; ?>&mb_id=<?php echo $mb_id; ?>&m_id=<?php echo $m_id; ?>&case_id=<?php echo $case_id; ?>&psu_id=<?php echo $psu_id; ?>" class="btn btn-border btn-with-icon btn-small ripple">
                                <span>Change Component</span>
                                <svg class="btn-icon-right" viewBox="0 0 13 9" width="13" height="9">
                                    <use xlink:href="assets/img/sprite.svg#arrow-right"></use>
                                </svg>
                            </a>
                        </td>
                    </tr>
            <?php
                }
            } else {
            ?>
                <tr>
                    <td colspan="5">No GPU selected</td>
                    <td>
                        <a href="selectgpu.php?s_id=<?php echo $s_id; ?>&c_id=<?php echo $c_id; ?>&g_id=<?php echo $g_id; ?>&cooler_id=<?php echo $cooler_id; ?>&mb_id=<?php echo $mb_id; ?>&m_id=<?php echo $m_id; ?>&case_id=<?php echo $case_id; ?>&psu_id=<?php echo $psu_id; ?>" class="btn btn-border btn-with-icon btn-small ripple">
                            <span>Select Component</span>
                            <svg class="btn-icon-right" viewBox="0 0 13 9" width="13" height="9">
                                <use xlink:href="assets/img/sprite.svg#arrow-right"></use>
                            </svg>
                        </a>
                    </td>
                </tr>
            <?php
            }
            ?>
            <!-- Case Section -->
            <?php
            $sql_case = "SELECT * FROM `pccase` WHERE case_id = '$case_id'";
            $result_case = mysqli_query($conn, $sql_case);

            if (!$result_case) {
                die('SQL Error: ' . mysqli_error($conn));
            }

            if (mysqli_num_rows($result_case) > 0) {
                while ($rowscase = mysqli_fetch_array($result_case)) {
                    $total_price += $rowscase['case_price'];
            ?>
                    <tr>
                        <td>Case</td>
                        <td><img width="100" src="../AdminPanel/compimg/<?php echo $rowscase['img'] ?>" alt=""></td>
                        <td><?php echo isset($rowscase['case_name']) ? $rowscase['case_name'] : 'NULL'; ?></td>
                        <td><?php echo isset($rowscase['manufacture']) ? $rowscase['manufacture'] : 'NULL'; ?></td>
                        <td><?php echo isset($rowscase['case_price']) ? '$' . $rowscase['case_price'] : 'NULL'; ?></td>
                        <td>
                            <a href="selectcase.php?case_id=<?php echo $case_id; ?>&c_id=<?php echo $c_id; ?>&g_id=<?php echo $g_id; ?>&cooler_id=<?php echo $cooler_id; ?>&mb_id=<?php echo $mb_id; ?>&m_id=<?php echo $m_id; ?>&s_id=<?php echo $s_id; ?>&psu_id=<?php echo $psu_id; ?>" class="btn btn-border btn-with-icon btn-small ripple">
                                <span>Change Component</span>
                                <svg class="btn-icon-right" viewBox="0 0 13 9" width="13" height="9">
                                    <use xlink:href="assets/img/sprite.svg#arrow-right"></use>
                                </svg>
                            </a>
                        </td>
                    </tr>
            <?php
                }
            } else {
            ?>
                <tr>
                    <td colspan="5">No Case selected</td>
                    <td>
                        <a href="selectcase.php?case_id=<?php echo $case_id; ?>&c_id=<?php echo $c_id; ?>&g_id=<?php echo $g_id; ?>&cooler_id=<?php echo $cooler_id; ?>&mb_id=<?php echo $mb_id; ?>&m_id=<?php echo $m_id; ?>&s_id=<?php echo $s_id; ?>&psu_id=<?php echo $psu_id; ?>" class="btn btn-border btn-with-icon btn-small ripple">
                            <span>Select Component</span>
                            <svg class="btn-icon-right" viewBox="0 0 13 9" width="13" height="9">
                                <use xlink:href="assets/img/sprite.svg#arrow-right"></use>
                            </svg>
                        </a>
                    </td>
                </tr>
            <?php
            }
            ?>
      <!-- PSU Section -->
      <?php
            $sql_psu = "SELECT * FROM `psu` WHERE psu_id = '$psu_id'";
            $result_psu = mysqli_query($conn, $sql_psu);

            if (!$result_psu) {
                die('SQL Error: ' . mysqli_error($conn));
            }

            if (mysqli_num_rows($result_psu) > 0) {
                while ($rowspsu = mysqli_fetch_array($result_psu)) {
                    $total_price += $rowspsu['psu_price'];
            ?>
                    <tr>
                        <td>PSU</td>
                        <td><img width="100" src="../AdminPanel/compimg/<?php echo $rowspsu['img'] ?>" alt=""></td>
                        <td><?php echo isset($rowspsu['psu_name']) ? $rowspsu['psu_name'] : 'NULL'; ?></td>
                        <td><?php echo isset($rowspsu['manufacture']) ? $rowspsu['manufacture'] : 'NULL'; ?></td>
                        <td><?php echo isset($rowspsu['psu_price']) ? '$' . $rowspsu['psu_price'] : 'NULL'; ?></td>
                        <td>
                            <a href="selectpsu.php?psu_id=<?php echo $psu_id; ?>&c_id=<?php echo $c_id; ?>&g_id=<?php echo $g_id; ?>&cooler_id=<?php echo $cooler_id; ?>&mb_id=<?php echo $mb_id; ?>&m_id=<?php echo $m_id; ?>&s_id=<?php echo $s_id; ?>" class="btn btn-border btn-with-icon btn-small ripple">
                                <span>Change Component</span>
                                <svg class="btn-icon-right" viewBox="0 0 13 9" width="13" height="9">
                                    <use xlink:href="assets/img/sprite.svg#arrow-right"></use>
                                </svg>
                            </a>
                        </td>
                    </tr>
            <?php
                }
            } else {
            ?>
                <tr>
                    <td colspan="5">No PSU selected</td>
                    <td>
                        <a href="selectpsu.php?psu_id=<?php echo $psu_id; ?>&c_id=<?php echo $c_id; ?>&g_id=<?php echo $g_id; ?>&cooler_id=<?php echo $cooler_id; ?>&mb_id=<?php echo $mb_id; ?>&m_id=<?php echo $m_id; ?>&s_id=<?php echo $s_id; ?>&case_id=<?php echo $case_id; ?>" class="btn btn-border btn-with-icon btn-small ripple">
                            <span>Select Component</span>
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
    <div class="total-container">
            <span class="total-label">Total:</span>
            <span class="total-price">$<span id="total-price-value"><?php echo $total_price?></span></span>
        </div>
                                <br>
    <div class="alert alert-danger" id="login-alert" style="display: none;">Please login or sign up to continue.</div>
    <form id="buy-form" action="customcheckout.php" method="GET">
    <input type="hidden" name="pid" value="<?php echo $pid; ?>">
    <input type="hidden" name="user" value="<?php echo $is_logged_in ? $_SESSION['username'] : ''; ?>">
    <input type="hidden" name="psu_id" value="<?php echo $psu_id; ?>">
    <input type="hidden" name="c_id" value="<?php echo $c_id; ?>">
    <input type="hidden" name="g_id" value="<?php echo $g_id; ?>">
    <input type="hidden" name="cooler_id" value="<?php echo $cooler_id; ?>">
    <input type="hidden" name="mb_id" value="<?php echo $mb_id; ?>">
    <input type="hidden" name="m_id" value="<?php echo $m_id; ?>">
    <input type="hidden" name="s_id" value="<?php echo $s_id; ?>">
    <input type="hidden" name="case_id" value="<?php echo $case_id; ?>">
    <button type="submit" class="btn btn-border btn-with-icon btn-small ripple">
        <span>Assemble PC</span>
        <svg class="btn-icon-right" viewBox="0 0 13 9" width="13" height="9">
            <use xlink:href="assets/img/sprite.svg#arrow-right"></use>
        </svg>
    </button>
</form>

</div>
<script>
    document.getElementById('buy-button').addEventListener('click', function() {
        var isLoggedIn = <?php echo json_encode($is_logged_in); ?>;
        var alertElement = document.getElementById('login-alert');
        
        if (isLoggedIn) {
            document.getElementById('buy-form').submit();
        } else {
            alertElement.style.display = 'block';
        }
    });
</script>
<br><br><br><br><br>
<?php 
include "shared/footer.php"
?>