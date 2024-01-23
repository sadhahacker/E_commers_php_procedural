<?php
require 'includes/database.php';
require 'includes/redirect.php';
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $validation_result = registerValidation($_POST['email'], $_POST['password'], $_POST['confirm_password'], $_POST['phone']);
    if ($validation_result === true) {
        $connection = db();
        $user = "user";
        $plaintext_password = $_POST['password'];
        $hash = password_hash($plaintext_password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO users (email, password, phone, usertype) VALUES (?,?,?,?);";
        $stmt = mysqli_prepare($connection, $sql);
        mysqli_stmt_bind_param($stmt, 'ssss', $_POST['email'], $hash, $_POST['phone'],$user);
        mysqli_stmt_execute($stmt);
        redirect("login");
    } else {
        $result = $validation_result;
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://unpkg.com/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@18.2.1/build/css/intlTelInput.css">
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
                            <h2 class="fs-6 fw-normal text-center text-secondary mb-4">Sing up an account</h2>
                            <form method="post">
                                <div class="row gy-2 overflow-hidden">
                                    <div class="col-12">
                                        <div class="form-floating mb-3">
                                            <input type="email" class="form-control" name="email" id="email" placeholder="name@example.com" required>
                                            <label for="email" class="form-label">Email</label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-floating mb-3">
                                            <input type="password" class="form-control" name="password" id="password" value="" placeholder="Password" required>
                                            <label for="password" class="form-label">Password</label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-floating mb-3">
                                            <input type="password" class="form-control" name="confirm_password" id="password" value="" placeholder="Confirm Password" required>
                                            <label for="password" class="form-label">Confirm password</label>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-floating mb-3">
                                            <input type="tel" class="form-control" name="phone" id="phone" placeholder="+91 1234567890" pattern="[+][0-9]{2} [0-9]{10}" required>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="d-flex gap-2 justify-content-between">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="" name="rememberMe" id="rememberMe">
                                                <label class="form-check-label text-secondary" for="rememberMe">
                                                    Keep me logged in
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="d-grid my-3">
                                            <button class="btn btn-primary btn-lg" type="submit">Sign up</button>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <p class="m-0 text-secondary text-center">Already have an account? <a href="login.php" class="link-primary text-decoration-none">Sign in</a></p>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/intl-tel-input@18.2.1/build/js/intlTelInput.min.js"></script>
    <script>
        const input = document.querySelector("#phone");
        window.intlTelInput(input, {
            utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input/build/js/utils.js",
            initialCountry: "in"
        });
    </script>
</body>

</html>