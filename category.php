<?php
// Required files
require_once 'config/db.php';
require_once 'models/product.php';
require_once 'includes/header.php';

// Check if category ID is provided
if (!isset($_GET['id'])) {
    header("Location: categories.php");
    exit();
}

$categoryId = (int) $_GET['id'];

// Fetch category details
try {
    $categoryQuery = "SELECT id, name, description FROM categories WHERE id = ?";
    $stmt = mysqli_prepare($mysqli, $categoryQuery);
    mysqli_stmt_bind_param($stmt, "i", $categoryId);
    mysqli_stmt_execute($stmt);
    $categoryResult = mysqli_stmt_get_result($stmt);
    
    if (!$categoryResult || mysqli_num_rows($categoryResult) === 0) {
        header("Location: categories.php");
        exit();
    }
    
    $category = mysqli_fetch_assoc($categoryResult);
} catch (Exception $e) {
    header("Location: categories.php");
    exit();
}

// Fetch products in this category
try {
    $productsQuery = "SELECT * FROM products WHERE category_id = ? AND status = 'active'";
    $stmt = mysqli_prepare($mysqli, $productsQuery);
    mysqli_stmt_bind_param($stmt, "i", $categoryId);
    mysqli_stmt_execute($stmt);
    $productsResult = mysqli_stmt_get_result($stmt);
    
    $products = [];
    while ($row = mysqli_fetch_assoc($productsResult)) {
        $products[] = $row;
    }
} catch (Exception $e) {
    $products = [];
}
?>

<script src="https://cdn.tailwindcss.com"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

<div class="container mx-auto px-4 py-8">
    <!-- Breadcrumbs -->
    <nav class="flex mb-6 text-sm" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="index.php" class="text-gray-500 hover:text-blue-600">
                    <i class="fas fa-home mr-2"></i> Home
                </a>
            </li>
            <li>
                <div class="flex items-center">
                    <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                    <a href="categories.php" class="text-gray-500 hover:text-blue-600">Categories</a>
                </div>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                    <span class="text-gray-800 font-medium"><?= htmlspecialchars($category['name']) ?></span>
                </div>
            </li>
        </ol>
    </nav>
    
    <!-- Category Header -->
    <div class="bg-white rounded-xl shadow-md p-6 mb-8">
        <h1 class="text-2xl md:text-3xl font-bold text-gray-800 mb-3"><?= htmlspecialchars($category['name']) ?></h1>
        <?php if(!empty($category['description'])): ?>
            <p class="text-gray-600"><?= htmlspecialchars($category['description']) ?></p>
        <?php endif; ?>
        <div class="mt-4 text-sm text-gray-500">
            <span class="font-medium"><?= count($products) ?></span> products found in this category
        </div>
    </div>
    
    <!-- Search & Filter Bar -->
    <div class="bg-white rounded-lg shadow-sm p-4 mb-6 flex flex-wrap justify-between items-center">
        <div class="w-full md:w-auto mb-4 md:mb-0">
            <div class="relative">
                <input type="text" id="search" placeholder="Search in this category..." 
                       class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg w-full md:w-80 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
            </div>
        </div>
        
        <div class="flex items-center space-x-4">
            <label class="text-gray-600 text-sm">Sort by:</label>
            <select id="sort" class="border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="name_asc">Name (A-Z)</option>
                <option value="name_desc">Name (Z-A)</option>
            </select>
        </div>
    </div>
    
    <!-- Product Grid -->
    <div id="products-container" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        <?php foreach ($products as $product): ?>
            <div class="product-card bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                <img src="<?= htmlspecialchars($product['image']) ?>" 
                     alt="<?= htmlspecialchars($product['name']) ?>"
                     class="w-full h-48 object-cover"
                     onerror="this.src='assets/images/placeholder.png'; this.classList.add('bg-gray-100');">
                
                <div class="p-4">
                    <h5 class="font-semibold text-gray-800 mb-1"><?= htmlspecialchars($product['name']) ?></h5>
                    <p class="text-sm text-gray-600 mb-3"><?= htmlspecialchars($product['brand']) ?></p>
                    
                    <div class="flex justify-between items-center">
                        <a href="product.php?id=<?= $product['id'] ?>" 
                           class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                            View Details
                        </a>
                        <a href="<?= htmlspecialchars($product['link']) ?>" 
                           target="_blank" 
                           class="bg-blue-600 text-white px-3 py-1 rounded text-xs hover:bg-blue-700">
                            Source <i class="fas fa-external-link-alt ml-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    
    <!-- Empty State -->
    <?php if (empty($products)): ?>
        <div class="text-center py-12 bg-white rounded-xl shadow-md">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 mb-6">
                <i class="fas fa-box-open text-gray-400 text-2xl"></i>
            </div>
            <h3 class="text-xl font-medium text-gray-800 mb-2">No products found</h3>
            <p class="text-gray-500 mb-6">We couldn't find any products in this category yet.</p>
            <a href="categories.php" class="inline-flex items-center text-blue-600 hover:text-blue-800">
                <i class="fas fa-arrow-left mr-2"></i> Back to categories
            </a>
        </div>
    <?php endif; ?>
</div>

<script>
// Search functionality
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('search');
    const sortSelect = document.getElementById('sort');
    const productsContainer = document.getElementById('products-container');
    const productCards = document.querySelectorAll('.product-card');
    
    // Search products
    searchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase().trim();
        
        productCards.forEach(card => {
            const name = card.querySelector('h5').textContent.toLowerCase();
            const brand = card.querySelector('p').textContent.toLowerCase();
            
            if (name.includes(searchTerm) || brand.includes(searchTerm) || searchTerm === '') {
                card.classList.remove('hidden');
            } else {
                card.classList.add('hidden');
            }
        });
    });
    
    // Sort products
    sortSelect.addEventListener('change', function() {
        const sortValue = this.value;
        const cardsArray = Array.from(productCards);
        
        cardsArray.sort((a, b) => {
            const nameA = a.querySelector('h5').textContent;
            const nameB = b.querySelector('h5').textContent;
            
            if (sortValue === 'name_asc') {
                return nameA.localeCompare(nameB);
            } else {
                return nameB.localeCompare(nameA);
            }
        });
        
        // Remove all product cards
        cardsArray.forEach(card => card.remove());
        
        // Add them back in new order
        cardsArray.forEach(card => productsContainer.appendChild(card));
    });
});
</script>