<?php
// Required files
require_once 'config/db.php';
require_once 'includes/header.php';

// Fetch all categories from database
try {
    $query = "SELECT id, name, description FROM categories ORDER BY name ASC";
    $result = mysqli_query($mysqli, $query);
    
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
    echo "Database error: " . $e->getMessage();
    $categories = [];
}

// Get category count
$categoryCount = count($categories);

// Get product counts for each category
foreach ($categories as $key => $category) {
    $countQuery = "SELECT COUNT(*) as count FROM products WHERE category_id = " . $category['id'];
    $countResult = mysqli_query($mysqli, $countQuery);
    if ($countResult) {
        $countRow = mysqli_fetch_assoc($countResult);
        $categories[$key]['product_count'] = $countRow['count'];
    } else {
        $categories[$key]['product_count'] = 0;
    }
}
?>

<script src="https://cdn.tailwindcss.com"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

<div class="container mx-auto px-4 py-8">
    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl shadow-md p-6 mb-10">
        <div class="max-w-3xl mx-auto text-center">
            <h1 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">Product Categories</h1>
            <p class="text-lg text-gray-600">
                Browse our product categories to find alternatives for Israeli products.
                We have <?= $categoryCount ?> categories to explore.
            </p>
        </div>
    </div>
    
    <!-- Categories Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php foreach ($categories as $category): ?>
            <a href="category.php?id=<?= $category['id'] ?>" 
               class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-xl font-semibold text-gray-800"><?= htmlspecialchars($category['name']) ?></h2>
                        <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                            <?= $category['product_count'] ?> products
                        </span>
                    </div>
                    
                    <p class="text-gray-600 mb-4 line-clamp-2">
                        <?= !empty($category['description']) ? 
                            htmlspecialchars($category['description']) : 
                            'Explore ' . htmlspecialchars($category['name']) . ' products and alternatives.' ?>
                    </p>
                    
                    <div class="flex justify-end">
                        <span class="inline-flex items-center text-blue-600 hover:text-blue-800 font-medium">
                            View Products <i class="fas fa-arrow-right ml-2"></i>
                        </span>
                    </div>
                </div>
            </a>
        <?php endforeach; ?>
    </div>
    
    <!-- Empty State -->
    <?php if (empty($categories)): ?>
        <div class="text-center py-12 bg-white rounded-xl shadow-md">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-blue-100 mb-6">
                <i class="fas fa-folder-open text-blue-600 text-2xl"></i>
            </div>
            <h3 class="text-xl font-medium text-gray-800 mb-2">No categories found</h3>
            <p class="text-gray-500 mb-6">We couldn't find any product categories.</p>
        </div>
    <?php endif; ?>
</div>

<!-- Now let's create a corresponding category.php page to display products from a specific category -->