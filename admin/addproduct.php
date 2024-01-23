<?php
require '../includes/database.php';
$errors = array();
$sucess = array();
if ($_SERVER['REQUEST_METHOD'] == "POST") {
  $connection = db();
  if (isset($_FILES["image"]) && $_FILES["image"]["error"] == 0) {
    $targetDir = "../productimages/";
    $targetFile = $targetDir . basename($_FILES["image"]["name"]);
    if (file_exists($targetFile)) {
      $errors[] = "Sorry, the file already exists.";
    } else {
      if (!(move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile))) {
        $errors[] = "Sorry, there was an error uploading your file.";
      }
    }
  } else {
    $errors[] = "Error: " . $_FILES["image"]["error"];
  }
  if (sizeof($errors) == 0) {
    $productname = $_POST['productname'];
    $productcategory = $_POST['productcategory'];
    $productprice = $_POST['price'];
    $productdescription = $_POST['description'];
    $productimage = basename($_FILES["image"]["name"]);
    $sql = "INSERT INTO products (productimage,productname,productcategory,price,description)VALUES (?,?,?,?,?);";
    $stmt = mysqli_prepare($connection, $sql);
    mysqli_stmt_bind_param($stmt, 'sssss', $productimage, $productname, $productcategory, $productprice, $productdescription);
    mysqli_stmt_execute($stmt);
    $success = "Product add successfully";
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css" integrity="sha384-r4NyP46KrjDleawBgD5tp8Y7UzmLA05oM1iAEQ17CSuDqnUK2+k9luXQOfXJCJ4I" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/chartist.js/latest/chartist.min.css">
</head>

<body>
  <nav class="navbar p-3">
    <div class="d-flex col-12 col-md-3 col-lg-2 mb-2 mb-lg-0 flex-wrap flex-md-nowrap justify-content-between">
      <a class="navbar-brand" href="#">
        <img src="../logo.png" alt="Logo" width="175" height="50">
      </a>
      <button class="navbar-toggler d-md-none collapsed mb-3" type="button" data-toggle="collapse" data-target="#sidebar" aria-controls="sidebar" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
    </div>
    <div class="d-flex align-items-center">
      <a href="../logout.php" class="btn btn-outline-danger">Log Out</a>
    </div>
  </nav>
  <div class="container-fluid">
    <div class="row">
      <nav id="sidebar" class="col-md-3 col-lg-2 d-md-block sidebar collapse">
        <div class="position-sticky">
          <ul class="nav flex-column">
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="admin.php">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home">
                  <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                  <polyline points="9 22 9 12 15 12 15 22"></polyline>
                </svg>
                <span class="ml-2">Dashboard</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="addproduct.php">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file">
                  <path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"></path>
                  <polyline points="13 2 13 9 20 9"></polyline>
                </svg>
                <span class="ml-2">Add Products</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="listproduct.php">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shopping-cart">
                  <circle cx="9" cy="21" r="1"></circle>
                  <circle cx="20" cy="21" r="1"></circle>
                  <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                </svg>
                <span class="ml-2">List Products</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="customer.php">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-users">
                  <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                  <circle cx="9" cy="7" r="4"></circle>
                  <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                  <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                </svg>
                <span class="ml-2">Customers</span>
              </a>
            </li>
          </ul>
        </div>
      </nav>
      <main class="col-md-9 ml-sm-auto col-lg-10 px-md-4 py-4">
        <div class="container">
          <?php if (sizeof($errors) != 0) : ?>
            <div class="alert alert-danger" role="alert">
              <?php foreach ($errors as $key) : ?>
                <h6><?php echo $key ?></h6>
              <?php endforeach ?>
            </div>
          <?php endif ?>
          <?php if (isset($success)) : ?>
            <?php if ($success != "") : ?>
            <div class="alert alert-success" role="alert">
              <h6><?php echo $success ?></h6>
            </div>
            <?php endif ?>
          <?php endif ?>
          <h2 class="mb-4">Add Product</h2>

          <form enctype="multipart/form-data" method="post">
            <!-- Product Name -->
            <div class="form-group mb-3">
              <label for="productName">Product Name:</label>
              <input type="text" class="form-control" id="productName" name="productname" placeholder="Enter Product Name" required>
            </div>

            <!-- Category -->
            <div class="form-group mb-3">
              <label for="category">Category:</label>
              <input type="text" class="form-control" name="productcategory" id="category" placeholder="Enter Category" required>
            </div>

            <!-- Price -->
            <div class="form-group mb-3">
              <label for="price">Price:</label>
              <input type="number" class="form-control" name="price" id="price" placeholder="Enter Price" required>
            </div>

            <!-- Description -->
            <div class="form-group mb-4">
              <label for="description">Description:</label>
              <textarea class="form-control" id="description" rows="3" name="description" placeholder="Enter Product Description" required></textarea>
            </div>
            <div class="form-group mb-4">
              <label for="image">Product Image:</label>
              <input type="file" class="form-control-file" id="image" name="image" accept="image/*">
            </div>
            <!-- Submit Button -->
            <button type="submit" class="btn btn-primary">Add Product</button>
          </form>
        </div>
      </main>
    </div>
  </div>
  <!-- Bootstrap JS and Popper.js -->
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.min.js" integrity="sha384-oesi62hOLfzrys4LxRF63OJCXdXDipiYWBnvTl9Y9/TRlw5xlKIEHpNyvvDShgf/" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/chartist.js/latest/chartist.min.js"></script>
  <!-- Github buttons -->
  <script async defer src="https://buttons.github.io/buttons.js"></script>
  <script>
    new Chartist.Line('#traffic-chart', {
      labels: ['January', 'Februrary', 'March', 'April', 'May', 'June'],
      series: [
        [23000, 25000, 19000, 34000, 56000, 64000]
      ]
    }, {
      low: 0,
      showArea: true
    });
  </script>
</body>

</html>