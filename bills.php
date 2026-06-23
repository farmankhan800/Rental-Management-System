<?php include 'includes/auth.php'; ?>
<?php include 'includes/connection.php'; ?>

<?php include 'includes/header.php'; ?>
<?php include 'includes/sidebar.php'; ?>
<?php include 'includes/topbar.php'; ?>

<?php

$query = "SELECT b.*, t.tenant_name
          FROM bills b
          JOIN tenants t ON b.tenant_id = t.id
          ORDER BY b.id DESC";

$result = mysqli_query($conn, $query);

?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">

        <h1 class="h3 mb-0 text-gray-800 font-weight-bold">
            Bills Management
        </h1>

        <a href="generate_bill.php"
           class="btn btn-warning btn-sm shadow-sm">

            <i class="fas fa-plus-circle"></i>
            Generate Bill

        </a>

    </div>

    <!-- Bills Table Card -->
    <div class="card shadow mb-4">

        <div class="card-header py-3">

            <h6 class="m-0 font-weight-bold text-primary">
                All Bills
            </h6>

        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-bordered table-hover">

                    <thead class="bg-primary text-white">

                        <tr>

                            <th>ID</th>
                            <th>Tenant</th>
                            <th>Month</th>
                            <th>Current Rent</th>
                            <th>Previous Due</th>
                            <th>Total Amount</th>
                            <th>Status</th>
                            <th>Action</th>

                        </tr>

                    </thead>

                    <tbody>

                    <?php if(mysqli_num_rows($result) > 0) { ?>

                        <?php while($row = mysqli_fetch_assoc($result)) { ?>

                            <tr>

                                <td>
                                    <?php echo $row['id']; ?>
                                </td>

                                <td>
                                    <?php echo $row['tenant_name']; ?>
                                </td>

                                <td>
                                    <?php echo $row['bill_month']; ?>
                                </td>

                                <td>
                                    Rs. <?php echo $row['current_rent']; ?>
                                </td>

                                <td>
                                    Rs. <?php echo $row['previous_due']; ?>
                                </td>

                                <td>
                                    <strong>
                                        Rs. <?php echo $row['total_amount']; ?>
                                    </strong>
                                </td>

                                <!-- Status -->
                                <td>

                                    <?php if($row['status'] == "Paid") { ?>

                                        <span class="badge badge-success p-2">
                                            Paid
                                        </span>

                                    <?php } elseif($row['status'] == "Partial") { ?>

                                        <span class="badge badge-warning p-2">
                                            Partial
                                        </span>

                                    <?php } else { ?>

                                        <span class="badge badge-danger p-2">
                                            Unpaid
                                        </span>

                                    <?php } ?>

                                </td>

                                <!-- Action -->
                                <td>

                                    <a href="pay_bill.php?bill_id=<?php echo $row['id']; ?>"
                                       class="btn btn-success btn-sm">

                                        <i class="fas fa-money-bill-wave"></i>
                                        Pay

                                    </a>

                                </td>

                            </tr>

                        <?php } ?>

                    <?php } else { ?>

                        <tr>

                            <td colspan="8" class="text-center text-muted">

                                No Bills Found

                            </td>

                        </tr>

                    <?php } ?>

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>
<!-- End Page Content -->

<?php include 'includes/footer.php'; ?>