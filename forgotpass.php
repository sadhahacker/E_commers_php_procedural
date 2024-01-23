<?php
require 'includes/database.php';
require 'includes/redirect.php';

if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(isset($_POST["email"])){
        $email_error = "Please enter a valid email address.";
        $email = $_POST['email'];
    $errors = [];
    $valdate = false;
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = $email_error;
    }
    else {
      $val = exists($email);
      if($val===true){
        $valdate = true;
        header("Location: updatepass.php?email=".$email);
      }
      else {
        $errors = $val;
      }
    }
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
        <?php if(isset($errors)): ?>
    <div class="alert alert-danger" role="alert">
        <?php foreach($errors as $key): ?>
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
                  <div class="col-12 my-4">
                  <h2 class="m-0 text-center">Reset Password</h2>
                  </div>
                  <h2 class="fs-6 fw-normal text-center text-secondary mb-4">Forgot your password? No Problem enter your mail address to reset your password</h2>
                  <form method="post">
                    <div class="row gy-2 overflow-hidden">
                      <div class="col-12">
                        <div class="form-floating mb-3">
                          <input type="email" class="form-control" name="email" id="email" placeholder="name@example.com" required>
                          <label for="email" class="form-label">Email</label>
                        </div>
                      </div>
                      <div class="col-12">
                        <div class="d-grid my-3">
                          <button class="btn btn-primary btn-lg" type="submit">Reset Password</button>
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