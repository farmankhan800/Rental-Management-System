<?php
session_start();

include 'includes/connection.php';

$error = "";

if(isset($_POST['login']))
{
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Secure Query
    $stmt = $conn->prepare("SELECT * FROM admins WHERE email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();

    $result = $stmt->get_result();

    $row = $result->fetch_assoc();

    if($row)
    {
        if(password_verify($password, $row['password']))
        {
            $_SESSION['admin'] = $row['email'];

            header("Location: index.php");
            exit();
        }
        else
        {
            $error = "Incorrect Password";
        }
    }
    else
    {
        $error = "Email Not Found";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Login - Rental Management System</title>

    <!-- Font Awesome -->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet">

    <!-- SB Admin CSS -->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-primary">

<div class="container">

    <div class="row justify-content-center">

        <div class="col-xl-5 col-lg-6 col-md-8">

            <div class="card o-hidden border-0 shadow-lg my-5">

                <div class="card-body p-5">

                    <!-- Heading -->
                    <div class="text-center mb-4">

                        <h1 class="h3 text-gray-900 mb-2 font-weight-bold">
                            Welcome Back
                        </h1>

                        <p class="text-gray-600">
                            Rental Management System Login
                        </p>

                    </div>

                    <!-- Error -->
                    <?php if($error != "") { ?>

                        <div class="alert alert-danger text-center">
                            <?php echo $error; ?>
                        </div>

                    <?php } ?>

                    <!-- Login Form -->
                    <form method="POST">

                        <div class="form-group">

                            <input type="email"
                                   name="email"
                                   class="form-control form-control-user"
                                   placeholder="Enter Email Address"
                                   required>

                        </div>

                        <div class="form-group">

                            <input type="password"
                                   name="password"
                                   class="form-control form-control-user"
                                   placeholder="Enter Password"
                                   required>

                        </div>

                        <button type="submit"
                                name="login"
                                class="btn btn-primary btn-user btn-block">

                            Login

                        </button>

                    </form>

                    <hr>

                    <!-- Register Route -->
                    <div class="text-center">

                        <a class="small" href="register.php">
                            Create an Account
                        </a>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

<!-- Scripts -->
<script src="vendor/jquery/jquery.min.js"></script>

<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<script src="js/sb-admin-2.min.js"></script>

</body>
</html>