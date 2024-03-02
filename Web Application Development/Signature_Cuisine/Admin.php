<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin - Add Menu Item</title>
    <link rel="stylesheet" href="css/AdminStyle.css">
</head>
<body>

<?php
	
	$conn = mysqli_connect('localhost', 'root', '', 'items_db');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $category = $_POST['category'];
    $name = $_POST['name'];
    $price = $_POST['price'];

    // Validate and sanitize data (you can add more validation)
    $category = htmlspecialchars($category);
    $name = htmlspecialchars($name);
    $price = floatval($price);

    // Handle image upload
    $targetDirectory = "uploads/"; // Change this to the directory where you want to store the images
    $targetFile = $targetDirectory . basename($_FILES["image"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Check if the image file is a actual image or fake image
    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if ($check === false) {
        echo "File is not an image.";
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["image"]["size"] > 500000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    } else {
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
            echo "The file " . basename($_FILES["image"]["name"]) . " has been uploaded.";
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }

    // Insert into the database if the image upload was successful
    if ($uploadOk) {
        // Insert into the database
        // Modify the connection details accordingly
        $conn = new mysqli('your_host', 'your_username', 'your_password', 'your_database');

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $imagePath = $targetFile; // Save the image path in the database

        $sql = "INSERT INTO menu_items (category, name, price, image_path) VALUES ('$category', '$name', $price, '$imagePath')";

        if ($conn->query($sql) === TRUE) {
            echo "Item added successfully!";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        $conn->close();
    }
}
?>


<div class="admin-container">
    <h2>Add New Menu Item</h2>
    <form action="add_item.php" method="post" enctype="multipart/form-data">
        <label for="category">Category:</label>
        <select name="category" id="category">
            <option value="Starters">Starters</option>
            <option value="Signature_Dishes">Signature Dishes</option>
            <option value="Beverages">Beverages</option>
            <option value="Desserts">Desserts</option>
            <option value="Offers">Offers</option>
        </select>

        <label for="name">Item Name:</label>
        <input type="text" name="name" id="name" required>

        <label for="price">Item Price (LKR):</label>
        <input type="number" name="price" id="price" step="0.01" required>

        <label for="image">Item Image:</label>
        <input type="file" name="image" id="image" accept="image/*" required>

        <button type="submit">Add Item</button>
    </form>
</div>

</body>
</html>
