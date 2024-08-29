<?php
// Check if the form is submitted using POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database connection details
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "my_product";

    // Create a connection to the MySQL database
    $connection = new mysqli($servername, $username, $password, $database);

    // Check if the connection was successful
    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }

    // Check if the 'submit' button was clicked
    if (isset($_POST['submit'])) {
        // Retrieve form data
        $name = $connection->real_escape_string($_POST['Name']);
        $description = $connection->real_escape_string($_POST['Description']);
        $price = $connection->real_escape_string($_POST['Price']);
        $quantity = $connection->real_escape_string($_POST['Quantity']);

        // SQL query to insert form data into the 'product' table, including Update_at
        $sql = "INSERT INTO product (Name, Description, Price, Quantity, Update_at) VALUES ('$name', '$description', '$price', '$quantity', NOW())";

        // Execute the query and check if it was successful
        if ($connection->query($sql) === TRUE) {
            echo "Successfully Added";
        } else {
            echo "Error: " . $sql . "<br>" . $connection->error;
        }

        // Close the database connection
        $connection->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD</title>
</head>
<body>
    <h2>Create New Product</h2><br>
    <form method="post" action="Create.php">
        <label for="name">Name:</label><br>
        <input type="text" id="name" name="Name" required><br><br>

        <label for="description">Description:</label><br>
        <input type="text" id="description" name="Description" required><br><br>

        <label for="price">Price:</label><br>
        <input type="text" id="price" name="Price" required><br><br>

        <label for="quantity">Quantity:</label><br>
        <input type="text" id="quantity" name="Quantity" required><br><br>

        <input type="submit" name="submit" value="Add Product">
    </form>

    <br>
    <a href="index.php">Back to Product List</a>
</body>
</html>
