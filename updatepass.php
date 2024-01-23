<?php
require 'includes/database.php';
require 'includes/redirect.php';
if (isset($_GET['email'])) {
    $email = $_GET['email'];
}
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $validation = updatePass($email, $_POST["password"],$_POST["confirm_password"]);
    if ($validation === true) {
        redirect("login");
    } else {
        $result = $validation;
    }
}
?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://unpkg.com/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>

<body>
    <section class="bg-light py-3 py-md-5" style="height: 100vh;">
        <div class="container">
        <?php if(isset($result)): ?>
    <div class="alert alert-danger" role="alert">
        <?php foreach($result as $key): ?>
            <h6><?php echo $key ?></h6>
        <?php endforeach ?>
    </div>
<?php endif ?>
            <div class="row justify-content-center">
                <div class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-5 col-xxl-4">
                    <div class="card border border-light-subtle rounded-3 shadow-sm">
                        <div class="card-body p-3 p-md-4 p-xl-5">
                            <div class="text-center mb-3">
                                <a href="#!">
                                    <img src="logo.png" alt="BootstrapBrain Logo" width="175" height="57">
                                </a>
                            </div>
                            <h2 class="fs-4 fw-normal text-center text-secondary mb-4">Reset password</h2>
                            <h2 class="fs-6 fw-normal text-center text-secondary mb-4">please enter your new password.</h2>
                            <form method="post">
                                <div class="row gy-2 overflow-hidden">
                                    <div class="col-12">
                                        <div class="form-floating mb-3">
                                            <input type="password" class="form-control" name="password" id="password" value="" placeholder="Password" required>
                                            <label for="password" class="form-label">New Password</label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-floating mb-3">
                                            <input type="password" class="form-control" name="confirm_password" id="password" value="" placeholder="Confirm Password" required>
                                            <label for="password" class="form-label">Confirm password</label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="d-grid my-3">
                                            <button class="btn btn-primary btn-lg" type="submit">Reset password</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>

</html>