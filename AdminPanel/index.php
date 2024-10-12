<?php
include "shared/header.php";
include "shared/config.php";

// Check if there is a login success message
$login_success_message = isset($_SESSION['login_success']) ? $_SESSION['login_success'] : '';
// Unset the session variable after getting its value
unset($_SESSION['login_success']);

// Fetch the total number of CPUs from the database
$cpu_count = 0; // Default value if query fails
$cpu_sql = "SELECT COUNT(*) as count FROM cpu";
if ($stmt = $conn->prepare($cpu_sql)) {
    $stmt->execute();
    $stmt->bind_result($cpu_count);
    $stmt->fetch();
    $stmt->close();
}

$cooler_count = 0; // Default value if query fails
$cooler_sql = "SELECT COUNT(*) as count FROM cooler";
if ($stmt = $conn->prepare($cooler_sql)) {
    $stmt->execute();
    $stmt->bind_result($cooler_count);
    $stmt->fetch();
    $stmt->close();
}
$mb_count = 0; // Default value if query fails
$mb_count = "SELECT COUNT(*) as count FROM motherboard";
if ($stmt = $conn->prepare($mb_count)) {
    $stmt->execute();
    $stmt->bind_result($mb_count);
    $stmt->fetch();
    $stmt->close();
}
$m_count = 0; // Default value if query fails
$m_count = "SELECT COUNT(*) as count FROM Memory";
if ($stmt = $conn->prepare($m_count)) {
    $stmt->execute();
    $stmt->bind_result($m_count);
    $stmt->fetch();
    $stmt->close();
}
$s_count = 0; // Default value if query fails
$s_count = "SELECT COUNT(*) as count FROM storage";
if ($stmt = $conn->prepare($s_count)) {
    $stmt->execute();
    $stmt->bind_result($s_count);
    $stmt->fetch();
    $stmt->close();
}
$g_count = 0; // Default value if query fails
$g_count = "SELECT COUNT(*) as count FROM gpu";
if ($stmt = $conn->prepare($g_count)) {
    $stmt->execute();
    $stmt->bind_result($g_count);
    $stmt->fetch();
    $stmt->close();
}
$c_count = 0; // Default value if query fails
$c_count = "SELECT COUNT(*) as count FROM pccase";
if ($stmt = $conn->prepare($c_count)) {
    $stmt->execute();
    $stmt->bind_result($c_count);
    $stmt->fetch();
    $stmt->close();
}
$p_count = 0; // Default value if query fails
$p_count = "SELECT COUNT(*) as count FROM PSU";
if ($stmt = $conn->prepare($p_count)) {
    $stmt->execute();
    $stmt->bind_result($p_count);
    $stmt->fetch();
    $stmt->close();
}
?>
<?php if ($login_success_message): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?php echo $login_success_message; ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php endif; ?>
<br>
<br>
<br>
<h1 style="text-align:center;" class="mb-0 font-weight-semibold">Number of components present in website</h1>
<br>
<br>
<!-- Page Title Header Ends -->
<div class="row">
    <div class="col-md-12 grid-margin">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-3 col-md-6">
                        <div class="d-flex">
                            <div class="wrapper">
                                <h3 class="mb-0 font-weight-semibold"><?php echo number_format($cpu_count); ?></h3>
                                <h5 class="mb-0 font-weight-medium text-primary">Total CPU's</h5>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 mt-md-0 mt-4">
                        <div class="d-flex">
                            <div class="wrapper">
                                <h3 class="mb-0 font-weight-semibold"><?php echo number_format($cooler_count); ?></h3>
                                <h5 class="mb-0 font-weight-medium text-primary">Total Coolers</h5>

                            </div>

                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 mt-md-0 mt-4">
                        <div class="d-flex">
                            <div class="wrapper">
                                <h3 class="mb-0 font-weight-semibold"><?php echo number_format($mb_count); ?></h3>
                                <h5 class="mb-0 font-weight-medium text-primary">Total MotherBoards</h5>

                            </div>

                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 mt-md-0 mt-4">
                        <div class="d-flex">
                            <div class="wrapper">
                                <h3 class="mb-0 font-weight-semibold"><?php echo number_format($m_count); ?></h3>
                                <h5 class="mb-0 font-weight-medium text-primary">Total Memories</h5>

                            </div>

                        </div>
                    </div><div class="col-lg-3 col-md-6 mt-md-0 mt-4">
                        <div class="d-flex">
                            <div class="wrapper">
                                <h3 class="mb-0 font-weight-semibold"><?php echo number_format($s_count); ?></h3>
                                <h5 class="mb-0 font-weight-medium text-primary">Total Storages</h5>

                            </div>

                        </div>
                    </div><div class="col-lg-3 col-md-6 mt-md-0 mt-4">
                        <div class="d-flex">
                            <div class="wrapper">
                                <h3 class="mb-0 font-weight-semibold"><?php echo number_format($g_count); ?></h3>
                                <h5 class="mb-0 font-weight-medium text-primary">Total GPU's</h5>

                            </div>

                        </div>
                    </div><div class="col-lg-3 col-md-6 mt-md-0 mt-4">
                        <div class="d-flex">
                            <div class="wrapper">
                                <h3 class="mb-0 font-weight-semibold"><?php echo number_format($c_count); ?></h3>
                                <h5 class="mb-0 font-weight-medium text-primary">Total Case's</h5>

                            </div>

                        </div>
                    </div><div class="col-lg-3 col-md-6 mt-md-0 mt-4">
                        <div class="d-flex">
                            <div class="wrapper">
                                <h3 class="mb-0 font-weight-semibold"><?php echo number_format($p_count); ?></h3>
                                <h5 class="mb-0 font-weight-medium text-primary">Total PSU's</h5>

                            </div>

                        </div>
                    </div>
                   
                </div>
            </div>
        </div>
    </div>
</div>
<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
<?php
include "shared/footer.php";
?>
