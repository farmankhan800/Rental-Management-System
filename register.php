<?php

include 'includes/connection.php';

$message = "";
$message_type = "";

// Register User
if(isset($_POST['register']))
{
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Check existing email
    $check = $conn->prepare("SELECT id FROM admins WHERE email=?");
    $check->bind_param("s", $email);
    $check->execute();

    $check_result = $check->get_result();

    if($check_result->num_rows > 0)
    {
        $message = "Email already exists!";
        $message_type = "danger";
    }
    else
    {
        // Hash Password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Secure Insert
        $stmt = $conn->prepare("
            INSERT INTO admins(username, email, password)
            VALUES (?, ?, ?)
        ");

        $stmt->bind_param(
            "sss",
            $username,
            $email,
            $hashedPassword
        );

        $result = $stmt->execute();

        if($result)
        {
            $message = "Registration Successful! Please Login.";
            $message_type = "success";
        }
        else
        {
            $message = "Registration Failed!";
            $message_type = "danger";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1">

    <title>
        Register - Rental Management System
    </title>

    <!-- Font Awesome -->
    <link href="vendor/fontawesome-free/css/all.min.css"
          rel="stylesheet">

    <!-- SB Admin CSS -->
    <link href="css/sb-admin-2.min.css"
          rel="stylesheet">

</head>

<body class="bg-gradient-primary">

<div class="container">

    <div class="row justify-content-center">

        <div class="col-xl-5 col-lg-6 col-md-8">

            <div class="card o-hidden border-0 shadow-lg my-5">

                <div class="card-body p-5">

                    <!-- Header -->
                    <div class="text-center mb-4">

                        <h1 class="h3 text-gray-900 mb-2 font-weight-bold">

                            Create Account

                        </h1>

                        <p class="text-gray-600">

                            Rental Management System

                        </p>

                    </div>

                    <!-- Message -->
                    <?php if($message != "") { ?>

                        <div class="alert alert-<?php echo $message_type; ?> text-center">

                            <?php echo $message; ?>

                        </div>

                    <?php } ?>

                    <!-- Register Form -->
                    <form method="POST">

                        <!-- Username -->
                        <div class="form-group">

                            <input type="text"
                                   name="username"
                                   class="form-control form-control-user"
                                   placeholder="Enter Username"
                                   required>

                        </div>

                        <!-- Email -->
                        <div class="form-group">

                            <input type="email"
                                   name="email"
                                   class="form-control form-control-user"
                                   placeholder="Enter Email Address"
                                   required>

                        </div>

                        <!-- Password -->
                        <div class="form-group">

                            <input type="password"
                                   name="password"
                                   class="form-control form-control-user"
                                   placeholder="Enter Password"
                                   required>

                        </div>

                        <!-- Submit -->
                        <button type="submit"
                                name="register"
                                class="btn btn-primary btn-user btn-block">

                            <i class="fas fa-user-plus"></i>
                            Register Account

                        </button>

                    </form>

                    <hr>

                    <!-- Login Link -->
                    <div class="text-center">

                        <a class="small"
                           href="login.php">

                            Already have an account? Login

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