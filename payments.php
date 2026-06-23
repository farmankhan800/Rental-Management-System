<?php include 'includes/auth.php'; ?>
<?php include 'includes/connection.php'; ?>

<?php include 'includes/header.php'; ?>
<?php include 'includes/sidebar.php'; ?>
<?php include 'includes/topbar.php'; ?>

<?php

$query = "SELECT p.*, t.tenant_name, b.bill_month
          FROM payments p
          JOIN bills b ON p.bill_id = b.id
          JOIN tenants t ON b.tenant_id = t.id
          ORDER BY p.id DESC";

$result = mysqli_query($conn, $query);

?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">

        <h1 class="h3 mb-0 text-gray-800 font-weight-bold">
            Payment History
        </h1>

    </div>

    <!-- Payment Table Card -->
    <div class="card shadow mb-4">

        <div class="card-header py-3">

            <h6 class="m-0 font-weight-bold text-primary">
                All Payment Records
            </h6>

        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-bordered table-hover">

                    <thead class="bg-primary text-white">

                        <tr>

                            <th>ID</th>
                            <th>Tenant</th>
                            <th>Bill Month</th>
                            <th>Amount Paid</th>
                            <th>Remaining Balance</th>
                            <th>Payment Date</th>
                            <th>Receipt</th>

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

                                <td class="text-success font-weight-bold">
                                    Rs. <?php echo $row['amount_paid']; ?>
                                </td>

                                <td class="text-danger font-weight-bold">
                                    Rs. <?php echo $row['remaining_balance']; ?>
                                </td>

                                <td>
                                    <?php echo $row['payment_date']; ?>
                                </td>

                                <td>

                                    <a href="receipt.php?id=<?php echo $row['id']; ?>"
                                       class="btn btn-primary btn-sm shadow-sm">

                                        <i class="fas fa-print"></i>
                                        Receipt

                                    </a>

                                </td>

                            </tr>

                        <?php } ?>

                    <?php } else { ?>

                        <tr>

                            <td colspan="7"
                                class="text-center text-muted">

                                No Payment Records Found

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