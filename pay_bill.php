<?php include 'includes/auth.php'; ?>
<?php include 'includes/connection.php'; ?>

<?php

$message = "";

// Check bill id
if(!isset($_GET['bill_id']))
{
    header("Location: bills.php");
    exit();
}

$bill_id = $_GET['bill_id'];

// Get bill data securely
$stmt = $conn->prepare("SELECT * FROM bills WHERE id=?");
$stmt->bind_param("i", $bill_id);
$stmt->execute();

$result = $stmt->get_result();
$bill = $result->fetch_assoc();

// If no bill found
if(!$bill)
{
    header("Location: bills.php");
    exit();
}

// Get total paid
$paid_query = $conn->prepare("
    SELECT SUM(amount_paid) AS total_paid
    FROM payments
    WHERE bill_id=?
");

$paid_query->bind_param("i", $bill_id);
$paid_query->execute();

$paid_result = $paid_query->get_result();
$paid_row = $paid_result->fetch_assoc();

$total_paid = $paid_row['total_paid'] ?? 0;

$remaining = $bill['total_amount'] - $total_paid;

// Payment Submit
if(isset($_POST['pay']))
{
    $amount_paid = $_POST['amount_paid'];

    // Validation
    if($amount_paid <= 0)
    {
        $message = "Invalid payment amount!";
    }
    elseif($amount_paid > $remaining)
    {
        $message = "Payment exceeds remaining balance!";
    }
    else
    {
        $new_remaining = $remaining - $amount_paid;

        // Insert Payment
        $insert = $conn->prepare("
            INSERT INTO payments
            (bill_id, amount_paid, remaining_balance)
            VALUES (?, ?, ?)
        ");

        $insert->bind_param(
            "idd",
            $bill_id,
            $amount_paid,
            $new_remaining
        );

        $insert->execute();

        // Update Bill Status
        if($new_remaining == 0)
        {
            $status = "Paid";
        }
        else
        {
            $status = "Partial";
        }

        $update = $conn->prepare("
            UPDATE bills
            SET status=?
            WHERE id=?
        ");

        $update->bind_param("si", $status, $bill_id);
        $update->execute();

        $message = "Payment Recorded Successfully!";

        // Refresh values
        $total_paid += $amount_paid;
        $remaining = $new_remaining;
        $bill['status'] = $status;
    }
}

?>

<?php include 'includes/header.php'; ?>
<?php include 'includes/sidebar.php'; ?>
<?php include 'includes/topbar.php'; ?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">

        <h1 class="h3 mb-0 text-gray-800 font-weight-bold">
            Pay Bill
        </h1>

        <a href="bills.php"
           class="btn btn-secondary btn-sm shadow-sm">

            <i class="fas fa-arrow-left"></i>
            Back

        </a>

    </div>

    <!-- Message -->
    <?php if($message != "") { ?>

        <div class="alert alert-info shadow-sm">

            <?php echo $message; ?>

        </div>

    <?php } ?>

    <!-- Bill Card -->
    <div class="card shadow mb-4">

        <div class="card-header py-3">

            <h6 class="m-0 font-weight-bold text-primary">
                Bill Information
            </h6>

        </div>

        <div class="card-body">

            <div class="row">

                <div class="col-md-6">

                    <p>
                        <strong>Bill Month:</strong>
                        <?php echo $bill['bill_month']; ?>
                    </p>

                    <p>
                        <strong>Total Amount:</strong>
                        Rs. <?php echo $bill['total_amount']; ?>
                    </p>

                    <p>
                        <strong>Already Paid:</strong>
                        Rs. <?php echo $total_paid; ?>
                    </p>

                </div>

                <div class="col-md-6">

                    <p>
                        <strong>Remaining Balance:</strong>

                        <span class="text-danger font-weight-bold">
                            Rs. <?php echo $remaining; ?>
                        </span>
                    </p>

                    <p>
                        <strong>Status:</strong>

                        <?php if($bill['status'] == "Paid") { ?>

                            <span class="badge badge-success p-2">
                                Paid
                            </span>

                        <?php } elseif($bill['status'] == "Partial") { ?>

                            <span class="badge badge-warning p-2">
                                Partial
                            </span>

                        <?php } else { ?>

                            <span class="badge badge-danger p-2">
                                Unpaid
                            </span>

                        <?php } ?>

                    </p>

                </div>

            </div>

            <hr>

            <!-- Payment Form -->
            <form method="POST">

                <div class="form-group">

                    <label>Amount to Pay</label>

                    <input type="number"
                           name="amount_paid"
                           class="form-control"
                           placeholder="Enter Payment Amount"
                           required>

                </div>

                <button type="submit"
                        name="pay"
                        class="btn btn-success">

                    <i class="fas fa-money-bill-wave"></i>
                    Pay Now

                </button>

            </form>

        </div>

    </div>

</div>
<!-- End Page Content -->

<?php include 'includes/footer.php'; ?>