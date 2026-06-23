<?php include 'includes/auth.php'; ?>
<?php include 'includes/connection.php'; ?>

<?php

$message = "";

// Fetch tenants
$tenants = mysqli_query($conn, "SELECT * FROM tenants");

if(isset($_POST['generate']))
{
    $tenant_id = $_POST['tenant_id'];
    $bill_month = $_POST['bill_month'];
    $current_rent = $_POST['current_rent'];
    $previous_due = $_POST['previous_due'];

    // Calculate total
    $total_amount = $current_rent + $previous_due;

    // Insert Bill
    $stmt = $conn->prepare("INSERT INTO bills 
    (tenant_id, bill_month, current_rent, previous_due, total_amount, status)
    VALUES (?, ?, ?, ?, ?, 'Unpaid')");

    $stmt->bind_param(
        "isddd",
        $tenant_id,
        $bill_month,
        $current_rent,
        $previous_due,
        $total_amount
    );

    $result = $stmt->execute();

    if($result)
    {
        header("Location: bills.php");
        exit();
    }
    else
    {
        $message = "Error: " . $conn->error;
    }
}

?>

<?php include 'includes/header.php'; ?>
<?php include 'includes/sidebar.php'; ?>
<?php include 'includes/topbar.php'; ?>

<div class="container-fluid">

    <!-- Heading -->
    <div class="d-flex justify-content-between align-items-center mb-4">

        <h1 class="h3 text-gray-800 font-weight-bold">
            Generate Bill
        </h1>

        <a href="bills.php" class="btn btn-success btn-sm">
            View Bills
        </a>

    </div>

    <!-- Error -->
    <?php if($message != "") { ?>

        <div class="alert alert-danger">
            <?php echo $message; ?>
        </div>

    <?php } ?>

    <!-- Card -->
    <div class="card shadow">

        <div class="card-body">

            <form method="POST">

                <!-- Tenant -->
                <div class="form-group">

                    <label>Select Tenant</label>

                    <select name="tenant_id" class="form-control" required>

                        <option value="">Choose Tenant</option>

                        <?php while($row = mysqli_fetch_assoc($tenants)) { ?>

                            <option value="<?php echo $row['id']; ?>">

                                <?php echo $row['tenant_name']; ?>

                            </option>

                        <?php } ?>

                    </select>

                </div>

                <!-- Month -->
                <div class="form-group">

                    <label>Bill Month</label>

                    <input type="text"
                           name="bill_month"
                           class="form-control"
                           placeholder="Example: May 2026"
                           required>

                </div>

                <!-- Current Rent -->
                <div class="form-group">

                    <label>Current Rent</label>

                    <input type="number"
                           name="current_rent"
                           class="form-control"
                           required>

                </div>

                <!-- Previous Due -->
                <div class="form-group">

                    <label>Previous Due</label>

                    <input type="number"
                           name="previous_due"
                           class="form-control"
                           value="0">

                </div>

                <!-- Button -->
                <button type="submit"
                        name="generate"
                        class="btn btn-primary">

                    Generate Bill

                </button>

            </form>

        </div>

    </div>

</div>

<?php include 'includes/footer.php'; ?>