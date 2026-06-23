<?php include 'includes/auth.php'; ?>
<?php include 'includes/connection.php'; ?>

<?php

$message = "";

// Check ID
if(!isset($_GET['id']))
{
    header("Location: tenants.php");
    exit();
}

$id = $_GET['id'];

// Fetch Existing Tenant
$stmt = $conn->prepare("SELECT * FROM tenants WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();

$result = $stmt->get_result();
$row = $result->fetch_assoc();

// If tenant not found
if(!$row)
{
    header("Location: tenants.php");
    exit();
}

// Update Tenant
if(isset($_POST['update']))
{
    $tenant_name = $_POST['tenant_name'];
    $phone = $_POST['phone'];
    $cnic = $_POST['cnic'];

    $update = $conn->prepare("UPDATE tenants
                              SET tenant_name=?, phone=?, cnic=?
                              WHERE id=?");

    $update->bind_param(
        "sssi",
        $tenant_name,
        $phone,
        $cnic,
        $id
    );

    $result2 = $update->execute();

    if($result2)
    {
        $message = "Tenant Updated Successfully!";

        // Refresh Data
        $stmt = $conn->prepare("SELECT * FROM tenants WHERE id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();

        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
    }
    else
    {
        $message = "Update Failed!";
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
            Edit Tenant
        </h1>

        <a href="tenants.php"
           class="btn btn-secondary btn-sm shadow-sm">

            <i class="fas fa-arrow-left"></i>
            Back

        </a>

    </div>

    <!-- Success Message -->
    <?php if($message != "") { ?>

        <div class="alert alert-success shadow-sm">

            <?php echo $message; ?>

        </div>

    <?php } ?>

    <!-- Edit Form Card -->
    <div class="card shadow mb-4">

        <div class="card-header py-3">

            <h6 class="m-0 font-weight-bold text-primary">
                Update Tenant Information
            </h6>

        </div>

        <div class="card-body">

            <form method="POST">

                <!-- Tenant Name -->
                <div class="form-group">

                    <label>Tenant Name</label>

                    <input type="text"
                           name="tenant_name"
                           value="<?php echo $row['tenant_name']; ?>"
                           class="form-control"
                           required>

                </div>

                <!-- Phone -->
                <div class="form-group">

                    <label>Phone Number</label>

                    <input type="text"
                           name="phone"
                           value="<?php echo $row['phone']; ?>"
                           class="form-control"
                           required>

                </div>

                <!-- CNIC -->
                <div class="form-group">

                    <label>CNIC</label>

                    <input type="text"
                           name="cnic"
                           value="<?php echo $row['cnic']; ?>"
                           class="form-control"
                           required>

                </div>

                <!-- Buttons -->
                <button type="submit"
                        name="update"
                        class="btn btn-success">

                    <i class="fas fa-save"></i>
                    Update Tenant

                </button>

                <a href="tenants.php"
                   class="btn btn-secondary">

                    Cancel

                </a>

            </form>

        </div>

    </div>

</div>
<!-- End Page Content -->

<?php include 'includes/footer.php'; ?>