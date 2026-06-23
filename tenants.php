<?php include 'includes/auth.php'; ?>
<?php include 'includes/connection.php'; ?>

<?php include 'includes/header.php'; ?>
<?php include 'includes/sidebar.php'; ?>
<?php include 'includes/topbar.php'; ?>

<?php

$search = $_GET['search'] ?? "";

// Secure Search Query
$stmt = $conn->prepare("
    SELECT * FROM tenants
    WHERE tenant_name LIKE ?
    OR cnic LIKE ?
    ORDER BY id DESC
");

$searchTerm = "%$search%";

$stmt->bind_param("ss", $searchTerm, $searchTerm);

$stmt->execute();

$result = $stmt->get_result();

?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">

        <h1 class="h3 mb-0 text-gray-800 font-weight-bold">

            Tenants Management

        </h1>

        <a href="add_tenant.php"
           class="btn btn-primary shadow-sm">

            <i class="fas fa-user-plus fa-sm text-white-50"></i>
            Add Tenant

        </a>

    </div>

    <!-- Search Card -->
    <div class="card shadow mb-4">

        <div class="card-body">

            <form method="GET">

                <div class="row">

                    <div class="col-md-10 mb-2">

                        <input type="text"
                               name="search"
                               class="form-control"
                               placeholder="Search by Tenant Name or CNIC..."
                               value="<?php echo htmlspecialchars($search); ?>">

                    </div>

                    <div class="col-md-2 mb-2">

                        <button type="submit"
                                class="btn btn-primary btn-block">

                            <i class="fas fa-search"></i>
                            Search

                        </button>

                    </div>

                </div>

            </form>

        </div>

    </div>

    <!-- Table Card -->
    <div class="card shadow mb-4">

        <div class="card-header py-3">

            <h6 class="m-0 font-weight-bold text-primary">

                Tenant Records

            </h6>

        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-bordered table-hover">

                    <thead class="bg-primary text-white">

                        <tr>

                            <th>ID</th>
                            <th>Tenant Name</th>
                            <th>Phone</th>
                            <th>CNIC</th>
                            <th width="180">Actions</th>

                        </tr>

                    </thead>

                    <tbody>

                    <?php if(mysqli_num_rows($result) > 0) { ?>

                        <?php while($row = mysqli_fetch_assoc($result)) { ?>

                            <tr>

                                <td>
                                    <?php echo $row['id']; ?>
                                </td>

                                <td class="font-weight-bold">
                                    <?php echo $row['tenant_name']; ?>
                                </td>

                                <td>
                                    <?php echo $row['phone']; ?>
                                </td>

                                <td>
                                    <?php echo $row['cnic']; ?>
                                </td>

                                <td>

                                    <a href="edit_tenant.php?id=<?php echo $row['id']; ?>"
                                       class="btn btn-info btn-sm">

                                        <i class="fas fa-edit"></i>
                                        Edit

                                    </a>

                                    <a href="delete_tenant.php?id=<?php echo $row['id']; ?>"
                                       class="btn btn-danger btn-sm"
                                       onclick="return confirm('Are you sure you want to delete this tenant?')">

                                        <i class="fas fa-trash"></i>
                                        Delete

                                    </a>

                                </td>

                            </tr>

                        <?php } ?>

                    <?php } else { ?>

                        <tr>

                            <td colspan="5"
                                class="text-center text-muted">

                                No Tenants Found

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