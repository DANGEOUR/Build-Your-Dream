<?php
include "shared/header.php";
include "shared/config.php";
$pid = $_GET['id'];
?>

<style>
    .total-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px 20px;
        border: 1px solid #ddd;
        border-radius: 5px;
    }

    .total-label {
        font-weight: bold;
    }

    .total-price {
        font-weight: bold;
    }

    .alert {
        display: none;
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
                        <a href="PreBuild.php">Pre-Build PCs</a>
                        <i class="material-icons md-18">chevron_right</i>
                    </li>
                    <li>Details</li>
                </ul>
            </div>
        </div>
    </div>
</nav>
<br><br><br><br>

<div class="container">
<div class="table-responsive">
    <table class="table-bordered">
        <thead>
            <tr>
                <th>Items</th>
                <th>Image</th>
                <th>Name</th>
                <th>Price</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "SELECT * FROM pre_build WHERE pre_id=$pid";
            $result = mysqli_query($conn, $sql);
            while ($rows = mysqli_fetch_array($result)) {
                echo "<tr>
                        <td>CPU</td>
                        <td><img width='100' src='../AdminPanel/compimg/{$rows['cpu_img']}' alt=''></td>
                        <td>{$rows['CPU']}</td>
                        <td>\${$rows['cpu_price']}</td>
                      </tr>";
            }
            ?>
            <?php
            $sql = "SELECT * FROM pre_build WHERE pre_id=$pid";
            $result = mysqli_query($conn, $sql);
            while ($rows = mysqli_fetch_array($result)) {
                echo "<tr>
                        <td>CPU Cooler</td>
                        <td><img width='100' src='../AdminPanel/compimg/{$rows['cooler_img']}' alt=''></td>
                        <td>{$rows['CpuCooler']}</td>
                        <td>\${$rows['cooler_price']}</td>
                      </tr>";
            }
            ?>
            <?php
            $sql = "SELECT * FROM pre_build WHERE pre_id=$pid";
            $result = mysqli_query($conn, $sql);
            while ($rows = mysqli_fetch_array($result)) {
                echo "<tr>
                        <td>MotherBoard</td>
                        <td><img width='100' height='auto' src='../AdminPanel/compimg/{$rows['mb_img']}' alt=''></td>
                        <td>{$rows['MotherBoard']}</td>
                        <td>\${$rows['mb_price']}</td>
                      </tr>";
            }
            ?>
            <?php
            $sql = "SELECT * FROM pre_build WHERE pre_id=$pid";
            $result = mysqli_query($conn, $sql);
            while ($rows = mysqli_fetch_array($result)) {
                echo "<tr>
                        <td>Memory</td>
                        <td><img width='100' src='../AdminPanel/compimg/{$rows['ram_img']}' alt=''></td>
                        <td>{$rows['Memory']}</td>
                        <td>\${$rows['ram_price']}</td>
                      </tr>";
            }
            ?>
            <?php
            $sql = "SELECT * FROM pre_build WHERE pre_id=$pid";
            $result = mysqli_query($conn, $sql);
            while ($rows = mysqli_fetch_array($result)) {
                echo "<tr>
                        <td>Storage</td>
                        <td><img width='100' src='../AdminPanel/compimg/{$rows['storage_img']}' alt=''></td>
                        <td>{$rows['storage']}</td>
                        <td>\${$rows['storage_price']}</td>
                      </tr>";
            }
            ?>
            <?php
            $sql = "SELECT * FROM pre_build WHERE pre_id=$pid";
            $result = mysqli_query($conn, $sql);
            while ($rows = mysqli_fetch_array($result)) {
                echo "<tr>
                        <td>GPU</td>
                        <td><img width='100' src='../AdminPanel/compimg/{$rows['gpu_img']}' alt=''></td>
                        <td>{$rows['GPU']}</td>
                        <td>\${$rows['gpu_price']}</td>
                      </tr>";
            }
            ?>
            <?php
            $sql = "SELECT * FROM pre_build WHERE pre_id=$pid";
            $result = mysqli_query($conn, $sql);
            while ($rows = mysqli_fetch_array($result)) {
                echo "<tr>
                        <td>Case</td>
                        <td><img width='100' src='../AdminPanel/compimg/{$rows['case_img']}' alt=''></td>
                        <td>{$rows['pc_case']}</td>
                        <td>\${$rows['case_price']}</td>
                      </tr>";
            }
            ?>
            <?php
            $sql = "SELECT * FROM pre_build WHERE pre_id=$pid";
            $result = mysqli_query($conn, $sql);
            while ($rows = mysqli_fetch_array($result)) {
                echo "<tr>
                        <td>PSU</td>
                        <td><img width='100' src='../AdminPanel/compimg/{$rows['psu_img']}' alt=''></td>
                        <td>{$rows['PSU']}</td>
                        <td>\${$rows['psu_price']}</td>
                      </tr>";
            }
            ?>
        </tbody>
    </table>
        </div>

    <br>
    <?php
    $sql = "SELECT * FROM pre_build WHERE pre_id=$pid";
    $result = mysqli_query($conn, $sql);
    while ($rows = mysqli_fetch_array($result)) {
    ?>
        <div class="total-container">
            <span class="total-label">Total:</span>
            <span class="total-price">$<span id="total-price-value"><?php echo $rows['price'] ?></span></span>
        </div>
    <?php
    }
    ?>
    <br>
    <div class="alert alert-danger" id="login-alert">Please login or sign up to continue.</div>
    
    <form id="buy-form" action="prebuildcheckout.php" method="GET">
        <input type="hidden" name="pid" value="<?php echo $pid; ?>">
        <input type="hidden" name="user" value="<?php echo isset($_SESSION['username']) ? $_SESSION['username'] : ''; ?>">
        <button type="submit" class="btn btn-border btn-with-icon btn-small ripple" id="buy-button">
            <span>Buy Pre-Build PC</span>
            <svg class="btn-icon-right" viewBox="0 0 13 9" width="13" height="9">
                <use xlink:href="assets/img/sprite.svg#arrow-right"></use>
            </svg>
        </button>
    </form>

    <input type="hidden" id="is-logged-in" value="<?php echo isset($_SESSION['username']) ? '1' : '0'; ?>">
</div>
<br><br>

<?php
include "shared/footer.php";
?>

<script>
    document.getElementById('buy-button').addEventListener('click', function (e) {
        const isLoggedIn = document.getElementById('is-logged-in').value;
        const loginAlert = document.getElementById('login-alert');
        if (isLoggedIn === '0') {
            e.preventDefault();
            loginAlert.style.display = 'block';
        }
    });
</script>
