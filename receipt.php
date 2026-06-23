<?php include 'includes/auth.php'; ?>
<?php include 'includes/connection.php'; ?>

<?php

// Check ID
if(!isset($_GET['id']))
{
    header("Location: payments.php");
    exit();
}

$payment_id = $_GET['id'];

// Secure Query
$stmt = $conn->prepare("
    SELECT p.*, 
           b.bill_month,
           b.total_amount,
           t.tenant_name,
           t.phone,
           t.cnic
    FROM payments p
    JOIN bills b ON p.bill_id = b.id
    JOIN tenants t ON b.tenant_id = t.id
    WHERE p.id=?
");

$stmt->bind_param("i", $payment_id);
$stmt->execute();

$result = $stmt->get_result();
$data = $result->fetch_assoc();

// If payment not found
if(!$data)
{
    header("Location: payments.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Payment Receipt</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">

    <style>

        body{
            background:#f4f6f9;
        }

        .receipt-box{
            max-width:750px;
            margin:40px auto;
            background:#fff;
            padding:40px;
            border-radius:10px;
            box-shadow:0 0 20px rgba(0,0,0,0.1);
        }

        .receipt-header{
            text-align:center;
            margin-bottom:30px;
        }

        .receipt-title{
            font-size:28px;
            font-weight:bold;
            color:#4e73df;
        }

        .receipt-subtitle{
            color:#666;
        }

        .receipt-info p{
            margin-bottom:10px;
            font-size:16px;
        }

        .receipt-table{
            margin-top:25px;
        }

        .signature{
            margin-top:60px;
            text-align:right;
        }

        @media print{

            .no-print{
                display:none;
            }

            body{
                background:white;
            }

            .receipt-box{
                box-shadow:none;
                margin:0;
            }
        }

    </style>

</head>

<body>

<div class="receipt-box">

    <!-- Header -->
    <div class="receipt-header">

        <div class="receipt-title">
            Rental Management System
        </div>

        <div class="receipt-subtitle">
            Payment Receipt
        </div>

    </div>

    <hr>

    <!-- Tenant Info -->
    <div class="receipt-info">

        <div class="row">

            <div class="col-md-6">

                <p>
                    <strong>Tenant Name:</strong>
                    <?php echo $data['tenant_name']; ?>
                </p>

                <p>
                    <strong>Phone:</strong>
                    <?php echo $data['phone']; ?>
                </p>

                <p>
                    <strong>CNIC:</strong>
                    <?php echo $data['cnic']; ?>
                </p>

            </div>

            <div class="col-md-6">

                <p>
                    <strong>Bill Month:</strong>
                    <?php echo $data['bill_month']; ?>
                </p>

                <p>
                    <strong>Payment Date:</strong>
                    <?php echo $data['payment_date']; ?>
                </p>

                <p>
                    <strong>Receipt ID:</strong>
                    #<?php echo $data['id']; ?>
                </p>

            </div>

        </div>

    </div>

    <!-- Payment Table -->
    <div class="receipt-table">

        <table class="table table-bordered">

            <thead class="bg-primary text-white">

                <tr>

                    <th>Total Bill</th>
                    <th>Amount Paid</th>
                    <th>Remaining Balance</th>

                </tr>

            </thead>

            <tbody>

                <tr>

                    <td>
                        Rs. <?php echo $data['total_amount']; ?>
                    </td>

                    <td class="text-success font-weight-bold">
                        Rs. <?php echo $data['amount_paid']; ?>
                    </td>

                    <td class="text-danger font-weight-bold">
                        Rs. <?php echo $data['remaining_balance']; ?>
                    </td>

                </tr>

            </tbody>

        </table>

    </div>

    <!-- Signature -->
    <div class="signature">

        <p>
            ______________________
        </p>

        <p>
            Authorized Signature
        </p>

    </div>

    <hr>

    <!-- Buttons -->
    <div class="text-center no-print">

        <button onclick="window.print()"
                class="btn btn-primary">

            Print Receipt

        </button>

        <a href="payments.php"
           class="btn btn-secondary">

            Back

        </a>

    </div>

</div>

</body>
</html>