<?php include 'includes/auth.php'; ?>
<?php include 'includes/connection.php'; ?>

<?php include 'includes/header.php'; ?>
<?php include 'includes/sidebar.php'; ?>
<?php include 'includes/topbar.php'; ?>

<?php

// Total tenants
$tenants = mysqli_query($conn, "SELECT COUNT(*) as total FROM tenants");
$tenant_count = mysqli_fetch_assoc($tenants)['total'];

// Total income
$income = mysqli_query($conn, "SELECT SUM(amount_paid) as total_income FROM payments");
$total_income = mysqli_fetch_assoc($income)['total_income'] ?? 0;

// Total bills
$bills = mysqli_query($conn, "SELECT COUNT(*) as total_bills FROM bills");
$total_bills = mysqli_fetch_assoc($bills)['total_bills'];

// Pending bills
$pending = mysqli_query($conn, "SELECT COUNT(*) as pending FROM bills WHERE status!='Paid'");
$pending_bills = mysqli_fetch_assoc($pending)['pending'];

?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">

        <h1 class="h3 mb-0 text-gray-800 font-weight-bold">
            Reports Dashboard
        </h1>

    </div>

    <!-- Top Summary Cards -->
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
                                <?php echo $tenant_count; ?>
                            </div>

                        </div>

                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>

                    </div>

                </div>

            </div>

        </div>

        <!-- Total Income -->
        <div class="col-xl-3 col-md-6 mb-4">

            <div class="card border-left-success shadow h-100 py-2">

                <div class="card-body">

                    <div class="row no-gutters align-items-center">

                        <div class="col mr-2">

                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Total Income
                            </div>

                            <div class="h4 mb-0 font-weight-bold text-gray-800">
                                Rs. <?php echo $total_income; ?>
                            </div>

                        </div>

                        <div class="col-auto">
                            <i class="fas fa-money-bill-wave fa-2x text-gray-300"></i>
                        </div>

                    </div>

                </div>

            </div>

        </div>

        <!-- Total Bills -->
        <div class="col-xl-3 col-md-6 mb-4">

            <div class="card border-left-info shadow h-100 py-2">

                <div class="card-body">

                    <div class="row no-gutters align-items-center">

                        <div class="col mr-2">

                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Total Bills
                            </div>

                            <div class="h4 mb-0 font-weight-bold text-gray-800">
                                <?php echo $total_bills; ?>
                            </div>

                        </div>

                        <div class="col-auto">
                            <i class="fas fa-file-invoice fa-2x text-gray-300"></i>
                        </div>

                    </div>

                </div>

            </div>

        </div>

        <!-- Pending Bills -->
        <div class="col-xl-3 col-md-6 mb-4">

            <div class="card border-left-danger shadow h-100 py-2">

                <div class="card-body">

                    <div class="row no-gutters align-items-center">

                        <div class="col mr-2">

                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                Pending Bills
                            </div>

                            <div class="h4 mb-0 font-weight-bold text-gray-800">
                                <?php echo $pending_bills; ?>
                            </div>

                        </div>

                        <div class="col-auto">
                            <i class="fas fa-exclamation-circle fa-2x text-gray-300"></i>
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <!-- Reports Information Card -->
    <div class="card shadow mb-4">

        <div class="card-header py-3">

            <h6 class="m-0 font-weight-bold text-primary">
                Financial Overview
            </h6>

        </div>

        <div class="card-body">

            <p class="text-gray-700 mb-2">
                This report dashboard provides a quick overview of:
            </p>

            <ul class="text-gray-700">

                <li>Total registered tenants</li>

                <li>Total bills generated</li>

                <li>Total collected payments</li>

                <li>Pending unpaid bills</li>

            </ul>

        </div>

    </div>

</div>
<!-- End Page Content -->

<?php include 'includes/footer.php'; ?>