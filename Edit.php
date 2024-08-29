<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "my_product";

$connection = new mysqli($servername, $username, $password, $database);

$name = "";
$description = "";
$price = "";
$quantity = "";

$errorMessage = "";
$successMessage = "";

if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    if (!isset($_GET["Id"])) {
        header("location: index.php");
        exit;
    }
    $id = $_GET["Id"];


    $sql = "SELECT `Id`, `Name`, `Description`, `Price`, `Quantity` FROM product WHERE Id='$id'";
    $stmt = $connection->prepare($sql);

    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if (!$row) {
        header("location: index.php");
        exit;
    }
    $name = $row["Name"];
    $description = $row["Description"]; 
    $price = $row["Price"];
    $quantity = $row["Quantity"]; 
} 

if (isset($_POST['submit'])) {
    $id = $_POST["Id"];
    $name = $_POST["Name"];
    $description = $_POST["Description"];
    $price = $_POST["Price"];
    $quantity = $_POST["Quantity"];

    if (empty($name) || empty($description) || empty($price) || empty($quantity)) {
        $errorMessage = "All fields are required. Please fill in all the information.";
    } else {
        $sql = "UPDATE product SET Name=?, Description=?, Price=?, Quantity=? WHERE ID=?";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("ssssi", $name, $description, $price, $quantity, $id);
        if ($stmt->execute()) {
            $successMessage = "Product updated successfully!";
            header("location: index.php");
            exit;
        } else {
            $errorMessage = "Error updating product: " . $stmt->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
</head>
<body>
    <div class="container my-5">
        <h2>Edit Product</h2>

        <?php
        if (!empty($errorMessage)) {
            echo "
            <div class='alert alert-warning alert-dismissible fade show' role='alert'>
                <strong>$errorMessage</strong>
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>
            ";
        }
        ?>

        <form method="post">
            <input type="hidden" name="Id" value="<?php echo $id; ?>">
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Name</label>
                <div class="col-sm-5">
                    <input type="text" class="form-control" name="Name" value="<?php echo $name; ?>">
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Description</label>
                <div class="col-sm-5">
                    <input type="text" class="form-control" name="Description" value="<?php echo $description; ?>">
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Price</label>
                <div class="col-sm-5">
                    <input type="text" class="form-control" name="Price" value="<?php echo $price; ?>">
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Quantity</label>
                <div class="col-sm-5">
                    <input type="text" class="form-control" name="Quantity" value="<?php echo $quantity; ?>">
                </div>
            </div>

            <?php
            if (!empty($successMessage)) {
                echo "
                <div class='row mb-3'>
                    <div class='offset-sm-3 col-sm-6'>
                        <div class='alert alert-success alert-dismissible fade show' role='alert'>
                            <strong>$successMessage</strong>
                            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                        </div>
                    </div>
                </div>
                ";
            }
            ?>

            <div class="row mb-3">
                <div class="offset-sm-3 col-sm-3 d-grid">
                    <button type="submit" name="submit" class="btn btn-primary">Update</button>
                </div>
                <div class="col-sm-3 d-grid">
                    <a href="/my_products/index.php" class="btn btn-secondary" role="button">Cancel</a>
                </div>
            </div>
        </form>
    </div>
</body>
</html>