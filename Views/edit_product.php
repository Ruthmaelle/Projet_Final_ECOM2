<?php
require_once("../DB/connexion.php");
require_once("../classes/GestionProduct.php");
require_once("../classes/GestionUser.php");
session_start();

if (!isset($_SESSION['user_name']) || $_SESSION['user_name'] !== 'SuperAdmin') {
    header('Location: login.php'); // Redirect non-SuperAdmins
    exit();
}

$gestionProduct = new GestionProduct($dbco);
$gestionUser = new GestionUser($dbco);

$product_id = $_GET['id'] ?? null;
if(!$product_id || !$gestionProduct->productValid($product_id)) {
    echo "<script>alert('Invalid product ID!'); window.location.href = 'manage_products.php';</script>";
    exit();
}

$product = $gestionUser->getProductById($product_id);

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'name' => $_POST['name'],
        'quantity' => $_POST['quantity'],
        'price' => $_POST['price'],
        'description' => $_POST['description'],
        'image' => $_FILES['image']['name']
    ];

    //ajouter l'img a partir de mes fichiers poko mache
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $allowed = ['jpg', 'jpeg', 'png', 'webp'];  // Allowed file types
        $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);

        if (in_array(strtolower($extension), $allowed)) {
            $folder = "../images/";  // Adjust the path accordingly
            $filePath = $folder . basename($_FILES['image']['name']);

            // Move the file to the target folder
            if (move_uploaded_file($_FILES['image']['tmp_name'], $filePath)) {
                $data['image'] = $_FILES['image']['name'];  // Save only the file name in the database
            } else {
                echo "<script>alert('Failed to move uploaded file.');</script>";
            }
        } else {
            echo "<script>alert('Invalid file type.');</script>";
        }
    }


    if($gestionProduct->updateProduct($product_id, $data)) {
        echo "<script>alert('Product updated successfully!'); window.location.href = 'manage_products.php';</script>";
    }else {
        echo "<script>alert('Failed to update product!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Product</title>
    <style>
        form {
            margin: 20px;
            padding: 20px;
            border: 1px solid #ccc;
        }
        form div {
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
<form action="" method="post" enctype="multipart/form-data">
    <div>
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" value="<?= htmlspecialchars($product['name']) ?>" required><br>
    </div>

    <div>
        <label for="quantity">Quantity:</label>
        <input type="number" id="quantity" name="quantity" value="<?= $product['quantity'] ?>" required><br>
    </div>

    <div>
        <label for="price">Price:</label>
        <input type="number" id="price" name="price" value="<?= $product['price'] ?>" step="0.01" required><br>
    </div>

    <div>
        <label for="description">Description:</label>
        <textarea id="description" name="description" required><?= htmlspecialchars($product['description']) ?></textarea><br>
    </div>

    <div>
        <label for="image">Image:</label>
        <input type="file" id="image" name="image"><br>
        <img src="../images/<?= $product['img_url'] ?>" alt="Product Image" height="100" id="preview"><br>
    </div>

    <button type="submit">Update Product</button>
</form>
<script>
    function previewFile() {
        const preview = document.getElementById('preview');
        const file = document.querySelector('input[type=file]').files[0];
        const reader = new FileReader();

        reader.addEventListener("load", function () {
            preview.src = reader.result;
        }, false);

        if (file) {
            reader.readAsDataURL(file);
        }
    }
</script>
</body>
</html>