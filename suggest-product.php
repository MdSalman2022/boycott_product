<?php
// filepath: f:\projects\web_eng_lab_reports\project\php_website\suggest-product.php
// suggest-product.php
require_once 'config/db.php';
require_once 'models/product.php';
require_once 'includes/header.php';
// Ensure user is logged in and is admin
// if (!isset($_SESSION['user_id'])) {
//     header("Location: login.php");
//     exit();
// }


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $brand = $_POST['brand'];
    $source = $_POST['link'];
    $image = $_POST['image'];
    $status = "inactive"; // Get status from form
    $is_israeli = 1; // Default to Israeli product
    
    // Add product to database
    $success = Product::createProduct($name, $brand, $source, $image, $is_israeli, $status); 
    
    if ($success) {
        header("Location: index.php");
        exit();
    }
}
?> 
 
<script src="https://cdn.tailwindcss.com"></script>

<div class="container mx-auto px-4 py-8 max-w-md">
    <div class="bg-white p-4 rounded shadow">
        <h2 class="text-lg font-semibold mb-2">Suggest a Boycott Israel Product</h2>
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="mb-1.5">
                <label for="name" class="text-sm">Product Name</label>
                <input type="text" id="name" name="name" class="border w-full p-1.5 text-sm" required>
            </div>
            <div class="mb-1.5">
                <label for="brand" class="text-sm">Brand</label>
                <input type="text" id="brand" name="brand" class="border w-full p-1.5 text-sm" required>
            </div>
            <div class="mb-1.5">
                <label for="description" class="text-sm">Description</label>
                <textarea id="description" name="description" rows="3" class="border w-full p-1.5 text-sm resize-y" required></textarea>
            </div>
            <div class="mb-1.5">
                <label for="image" class="text-sm">Image Link</label>
                <input type="text" id="image" name="image" class="border w-full p-1.5 text-sm" required>
            </div>
            <div class="mb-2">
                <label for="link" class="text-sm">Source Link</label>
                <input type="url" id="link" name="link" class="border w-full p-1.5 text-sm" required>
            </div>
            <div class="flex justify-end">
                <a href="index.php" class="mr-2 bg-gray-400 text-white px-2 py-1 rounded text-sm">Cancel</a>
                <button type="submit" name="submit-product" class="bg-blue-600 text-white px-2 py-1 rounded text-sm">Submit</button>
            </div>
        </form>
    </div>
</div>