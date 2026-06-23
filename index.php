<?php include 'includes/auth.php'; ?>
<?php include 'includes/connection.php'; ?>

<?php include 'includes/header.php'; ?>
<?php include 'includes/sidebar.php'; ?>
<?php include 'includes/topbar.php'; ?>

<?php
// Dashboard Data
$tenants = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM tenants"));
$bills = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM bills"));
$payments = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM payments"));
$income = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(amount_paid) as total FROM payments"));
?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800 font-weight-bold">
            Dashboard
        </h1>
    </div>

    <!-- Welcome Banner -->
    <div class="card shadow mb-4 border-left-primary">
        <div class="card-body">

            <div class="row align-items-center">

                <div class="col-md-8">
                    <h4 class="text-primary font-weight-bold">
                        Welcome Back, Farman!
                    </h4>

                    <p class="text-gray-600 mb-0">
                        Manage tenants, rent bills, payments and reports easily from this dashboard.
                    </p>
                </div>

                <div class="col-md-4 text-right">
                    <i class="fas fa-building fa-4x text-gray-300"></i>
                </div>

            </div>

        </div>
    </div>

    <!-- Quick Action Buttons -->
    <div class="row mb-4">

        <div class="col-md-4 mb-2">
            <a href="tenants.php" class="btn btn-primary btn-block shadow">
                <i class="fas fa-users"></i> Manage Tenants
            </a>
        </div>

        <div class="col-md-4 mb-2">
            <a href="generate_bill.php" class="btn btn-warning btn-block shadow">
                <i class="fas fa-file-invoice"></i> Generate Bills
            </a>
        </div>

        <div class="col-md-4 mb-2">
            <a href="reports.php" class="btn btn-success btn-block shadow">
                <i class="fas fa-chart-bar"></i> View Reports
            </a>
        </div>

    </div>

    <!-- Statistics Cards -->
    <div class="row">

        <!-- Total Tenants -->
        <div class="col-xl-3 col-md-6 mb-4">

            <div class="card border-left-primary shadow h-100 py-2">

                <div class="card-body">

                    <div class="row no-gutters align-items-center">

                        <div class="col mr-2">

                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Tenants
                            </div>

                            <div class="h4 mb-0 font-weight-bold text-gray-800">
                                <?php echo $tenants['total']; ?>
                            </div>

                        </div>

                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>

                    </div>

                </div>

            </div>

        </div>

        <!-- Total Bills -->
        <div class="col-xl-3 col-md-6 mb-4">

            <div class="card border-left-warning shadow h-100 py-2">

                <div class="card-body">

                    <div class="row no-gutters align-items-center">

                        <div class="col mr-2">

                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Total Bills
                            </div>

                            <div class="h4 mb-0 font-weight-bold text-gray-800">
                                <?php echo $bills['total']; ?>
                            </div>

                        </div>

                        <div class="col-auto">
                            <i class="fas fa-file-invoice fa-2x text-gray-300"></i>
                        </div>

                    </div>

                </div>

            </div>

        </div>

        <!-- Payments -->
        <div class="col-xl-3 col-md-6 mb-4">

            <div class="card border-left-success shadow h-100 py-2">

                <div class="card-body">

                    <div class="row no-gutters align-items-center">

                        <div class="col mr-2">

                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Total Payments
                            </div>

                            <div class="h4 mb-0 font-weight-bold text-gray-800">
                                <?php echo $payments['total']; ?>
                            </div>

                        </div>

                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                        </div>

                    </div>

                </div>

            </div>

        </div>

        <!-- Income -->
        <div class="col-xl-3 col-md-6 mb-4">

            <div class="card border-left-info shadow h-100 py-2">

                <div class="card-body">

                    <div class="row no-gutters align-items-center">

                        <div class="col mr-2">

                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Total Income
                            </div>

                            <div class="h4 mb-0 font-weight-bold text-gray-800">
                                Rs. <?php echo $income['total'] ?? 0; ?>
                            </div>

                        </div>

                        <div class="col-auto">
                            <i class="fas fa-coins fa-2x text-gray-300"></i>
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>
<!-- /.container-fluid -->

<?php include 'includes/footer.php'; ?>