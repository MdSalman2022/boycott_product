<?php
require_once 'config/db.php';
require_once 'models/product.php';
require_once 'includes/header.php';

// Ensure user is logged in and is admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}


// Fetch all categories for dropdown
try {
  // Use the $mysqli connection from db.php
  $categoriesQuery = "SELECT id, name FROM categories ORDER BY name ASC";
  $result = mysqli_query($mysqli, $categoriesQuery);
  
  if (!$result) {
      throw new Exception(mysqli_error($mysqli));
  }
  
  // Fetch all categories into an array
  $categories = [];
  while ($row = mysqli_fetch_assoc($result)) {
      $categories[] = $row;
  }
} catch (Exception $e) {
  // Handle database error
  $categories = [];
  echo "Database error: " . $e->getMessage();
}
// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $brand = $_POST['brand'];
    $source = $_POST['source'];
    $image = $_POST['image'];
    $status = $_POST['status'];
    $category_id = $_POST['category_id']; // Get category ID from form
    $is_israeli = 1; // Default to Israeli product
    
    // Add product to database (updated to include category_id)
    $success = Product::createProduct($name, $brand, $source, $image, $is_israeli, $status, $category_id); 
    
    // if ($success) {
    //     header("Location: dashboard.php");
    //     exit();
    // }
}
?>


<script src="https://cdn.tailwindcss.com"></script>

<div class="container mx-auto px-4 py-8">
  <h2 class="text-xl font-semibold mb-6">Create New Product</h2>
  
  <div class="bg-white rounded-lg shadow-md p-6">
    <form action="" method="POST">
      <div class="mb-4">
        <label for="name" class="block text-gray-700 font-medium mb-2">Product Name</label>
        <input type="text" id="name" name="name" required
               class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
      </div>
      
      <div class="mb-4">
        <label for="brand" class="block text-gray-700 font-medium mb-2">Brand</label>
        <input type="text" id="brand" name="brand" required
               class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
      </div>

      <div class="mb-4">
        <label for="source" class="block text-gray-700 font-medium mb-2">Source Link</label>
        <input type="text" id="source" name="source" required
               class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
      </div>
      
      <div class="mb-4">
        <label for="image" class="block text-gray-700 font-medium mb-2">Image URL</label>
        <input type="url" id="image" name="image" required
               class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
      </div>
      
      <div class="mb-4">
        <label for="category_id" class="block text-gray-700 font-medium mb-2">Category</label>
        <select id="category_id" name="category_id" required
               class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
          <option value="">Select a category</option>
          <?php foreach ($categories as $category): ?>
            <option value="<?= $category['id'] ?>"><?= htmlspecialchars($category['name']) ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      
      <div class="mb-4">
        <label for="status" class="block text-gray-700 font-medium mb-2">Status</label>
        <select id="status" name="status" required
               class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
          <option value="active" selected>Active</option>
          <option value="inactive">Inactive</option>
          <option value="pending">Pending Review</option>
        </select>
      </div>
      
      <div class="flex justify-end">
        <a href="dashboard.php" class="px-4 py-2 bg-gray-300 text-gray-700 rounded mr-2">Cancel</a>
        <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded">Create Product</button>
      </div>
    </form>
  </div>
</div>