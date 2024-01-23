<?php
require '../includes/database.php';
require '../includes/redirect.php';
$connection = db();
$id=$_GET['id'];
$sql = "SELECT * FROM products where id=$id;";
$result = mysqli_query($connection, $sql);
$row = mysqli_fetch_assoc($result);
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $productname = $_POST["productname"];
    $productcategory = $_POST["productcategory"];
    $price = $_POST["price"];
    $description = $_POST["description"];
    if ($_FILES['image']['error'] == 0){
        $image = basename($_FILES["image"]["name"]);
        $sql = "UPDATE products SET `productname`=?, `productcategory`=?, `price`=?, `description`=?, `productimage`=? WHERE `id`=?";
        $stmt = mysqli_prepare($connection, $sql);
        mysqli_stmt_bind_param($stmt, "ssissi", $productname, $productcategory, $price, $description, $image, $id);
        mysqli_stmt_execute($stmt);
        redirect("listproduct");
    }else{
    $sql = "UPDATE products SET `productname`=?, `productcategory`=?, `price`=?, `description`=? WHERE `id`=?";
    $stmt = mysqli_prepare($connection, $sql);
    mysqli_stmt_bind_param($stmt, "ssisi", $productname, $productcategory, $price, $description, $id);
    mysqli_stmt_execute($stmt);
    redirect("listproduct");
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
    <main class="col-md-9 ml-sm-auto col-lg-10 px-md-4 py-4">
        <div class="container">
            <h2 class="mb-4">Add Product</h2>

            <form enctype="multipart/form-data" method="post">
                <!-- Product Name -->
                <div class="form-group mb-3">
                    <label for="productName">Product Name:</label>
                    <input type="text" class="form-control" id="productName" name="productname" placeholder="Enter Product Name" value="<?php echo $row['productname'] ?>" required>
                </div>

                <!-- Category -->
                <div class="form-group mb-3">
                    <label for="category">Category:</label>
                    <input type="text" class="form-control" name="productcategory" id="category" placeholder="Enter Category" value="<?php echo $row['productcategory'] ?>" required>
                </div>

                <!-- Price -->
                <div class="form-group mb-3">
                    <label for="price">Price:</label>
                    <input type="number" class="form-control" name="price" id="price" placeholder="Enter Price" value="<?php echo $row['price'] ?>" required>
                </div>

                <!-- Description -->
                <div class="form-group mb-4">
                    <label for="description">Description:</label>
                    <textarea class="form-control" id="description" rows="3" name="description" placeholder="Enter Product Description" required><?php echo $row['description'] ?></textarea>
                </div>
                <div class="form-group mb-4">
                    <label for="image">Product Image:</label>
                    <input type="file" class="form-control-file" id="image" name="image" accept="image/*">
                </div>
                <!-- Submit Button -->
                <button type="submit" class="btn btn-primary">Update Product</button>
            </form>
        </div>
    </main>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src = "https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.min.js" integrity = "sha384-oesi62hOLfzrys4LxRF63OJCXdXDipiYWBnvTl9Y9/TRlw5xlKIEHpNyvvDShgf/" crossorigin = "anonymous" ></script>
    <script src="https://cdn.jsdelivr.net/chartist.js/latest/chartist.min.js"></script>
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