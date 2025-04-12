<?php
// Make sure to do all header changes before including header.php
require_once 'config/db.php';
require_once 'models/product.php';

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Ensure user is logged in and is admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Check if ID parameter exists
if (!isset($_GET['id'])) {
    header("Location: dashboard.php?error=missing_id");
    exit();
}

$productId = $_GET['id'];

// Get product data
$product = Product::getProductById($productId);

if (!$product) {
    header("Location: dashboard.php?error=product_not_found");
    exit();
}

// Now it's safe to include the header
require_once 'includes/header.php';

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
    $category_id = $_POST['category_id'];
    $description = isset($_POST['description']) ? $_POST['description'] : null;
    
    // Update product in database
    $success = Product::updateProduct(
        $productId,
        $name, 
        $brand, 
        $source, 
        $image, 
        $status, 
        $category_id,
        $description
    );
    
    if ($success) {
        $updateMessage = "Product updated successfully!";
    } else {
        $error = "Failed to update product";
    }
}
?>

<script src="https://cdn.tailwindcss.com"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Edit Product</h2>
            <p class="text-gray-600 text-sm mt-1">Update product details</p>
        </div>
        <a href="dashboard.php" class="text-blue-600 hover:text-blue-800 flex items-center">
            <i class="fas fa-arrow-left mr-1"></i> Back to Dashboard
        </a>
    </div>
    
    <?php if (isset($error)): ?>
    <div class="bg-red-50 border-l-4 border-red-400 p-4 mb-6 rounded-md">
        <div class="flex">
            <div class="flex-shrink-0">
                <i class="fas fa-exclamation-circle text-red-400"></i>
            </div>
            <div class="ml-3">
                <p class="text-sm text-red-700"><?= $error ?></p>
            </div>
        </div>
    </div>
    <?php endif; ?>
    
    <?php if (isset($updateMessage)): ?>
    <div class="bg-green-50 border-l-4 border-green-400 p-4 mb-6 rounded-md">
        <div class="flex">
            <div class="flex-shrink-0">
                <i class="fas fa-check-circle text-green-400"></i>
            </div>
            <div class="ml-3">
                <p class="text-sm text-green-700"><?= $updateMessage ?></p>
            </div>
        </div>
    </div>
    <?php endif; ?>
    
    <div class="bg-white rounded-lg shadow-md p-6">
        <form action="" method="POST">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label for="name" class="block text-gray-700 font-medium mb-2">Product Name</label>
                    <input type="text" id="name" name="name" required
                        value="<?= htmlspecialchars($product['name']) ?>"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                
                <div>
                    <label for="brand" class="block text-gray-700 font-medium mb-2">Brand</label>
                    <input type="text" id="brand" name="brand" required
                        value="<?= htmlspecialchars($product['brand']) ?>"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                
                <div>
                    <label for="source" class="block text-gray-700 font-medium mb-2">Source Link</label>
                    <input type="url" id="source" name="source" required
                        value="<?= htmlspecialchars($product['link']) ?>"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                
                <div>
                    <label for="image" class="block text-gray-700 font-medium mb-2">Image URL</label>
                    <input type="url" id="image" name="image" required
                        value="<?= htmlspecialchars($product['image']) ?>"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <p class="mt-1 text-sm text-gray-500">Direct link to product image</p>
                </div>
                
                <div>
                    <label for="category_id" class="block text-gray-700 font-medium mb-2">Category</label>
                    <select id="category_id" name="category_id" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Select a category</option>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?= $category['id'] ?>" 
                                <?= (isset($product['category_id']) && $product['category_id'] == $category['id']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($category['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div>
                    <label for="status" class="block text-gray-700 font-medium mb-2">Status</label>
                    <select id="status" name="status" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="active" <?= $product['status'] === 'active' ? 'selected' : '' ?>>Active</option>
                        <option value="inactive" <?= $product['status'] === 'inactive' ? 'selected' : '' ?>>Inactive</option>
                        <option value="pending" <?= $product['status'] === 'pending' ? 'selected' : '' ?>>Pending Review</option>
                    </select>
                </div>
            </div>
            
            <div class="mb-6">
                <label for="description" class="block text-gray-700 font-medium mb-2">Description (Optional)</label>
                <textarea id="description" name="description" rows="4"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 resize-y"><?= htmlspecialchars($product['description'] ?? '') ?></textarea>
            </div>
            
            <div class="mt-8 border-t pt-6 flex justify-between">
                <a href="dashboard.php" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 transition-colors">
                    Cancel
                </a>
                <div>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">
                        Update Product
                    </button>
                </div>
            </div>
        </form>
    </div>
    
    <!-- Image Preview -->
    <div class="mt-8">
        <h3 class="text-lg font-medium text-gray-800 mb-3">Current Image Preview</h3>
        <div class="bg-gray-100 border border-gray-200 rounded-lg p-4 flex justify-center">
            <img id="image-preview" src="<?= htmlspecialchars($product['image']) ?>" 
                 class="max-h-48 object-contain" 
                 alt="Product Preview"
                 onerror="this.src='assets/images/placeholder.png'; this.classList.add('opacity-50');">
        </div>
    </div>
</div>

<script>
// Live image preview update
document.getElementById('image').addEventListener('input', function() {
    const preview = document.getElementById('image-preview');
    preview.src = this.value || 'assets/images/placeholder.png';
});

// Show success message and redirect after delay if needed
<?php if (isset($updateMessage)): ?>
setTimeout(() => {
    window.location.href = 'dashboard.php?updated=success';
}, 1500);
<?php endif; ?>
</script>