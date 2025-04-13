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


<!-- Modal for Product Details -->
<div id="product-modal" class="fixed inset-0 z-50 hidden">
    <!-- Modal backdrop -->
    <div class="absolute inset-0 bg-gray-900 bg-opacity-50 backdrop-blur-sm" id="modal-backdrop"></div>
    
    <!-- Modal content -->
    <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-full max-w-2xl bg-white rounded-xl shadow-2xl overflow-hidden">
        <!-- Modal header with close button -->
        <div class="flex justify-between items-center p-4 border-b border-gray-100">
            <h3 class="text-xl font-semibold text-gray-800" id="modal-title">Product Details</h3>
            <button id="close-modal-button" class="p-2 rounded-full hover:bg-gray-100 transition-colors focus:outline-none">
                <svg class="h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        
        <!-- Modal content area -->
        <div class="p-6">
            <div class="flex flex-col md:flex-row gap-6" id="product-details">
                <div class="w-full md:w-1/3">
                    <div class="bg-gray-100 rounded-lg overflow-hidden">
                        <img id="modal-product-image" src="" alt="Product Image" class="w-full h-auto object-cover">
                    </div>
                </div>
                <div class="w-full md:w-2/3">
                    <h2 id="modal-product-name" class="text-xl font-bold text-gray-800 mb-2"></h2>
                    <p id="modal-product-brand" class="text-gray-600 mb-4"></p>
                    
                    <div class="mb-4">
                        <h4 class="text-sm font-medium text-gray-800 mb-1">Description</h4>
                        <p id="modal-product-description" class="text-gray-600"></p>
                    </div>
                    
                    <div class="mt-6 flex justify-between items-center">
                        <a id="modal-product-source" href="#" target="_blank" rel="noopener noreferrer"
                           class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                            </svg>
                            Visit Source
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Loading indicator -->
            <div id="modal-loading" class="flex flex-col items-center justify-center py-16">
                <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600"></div>
                <p class="mt-4 text-gray-600">Loading product details...</p>
            </div>
        </div>
    </div>
</div>


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
                                                <!-- Replace the current "View Details" link with this -->
                        <a href="#" 
                           data-product-id="<?= $product['id'] ?>"
                           class="text-blue-600 hover:text-blue-800 text-sm font-medium view-product-btn">
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
document.addEventListener('DOMContentLoaded', function() {
    // Modal elements
    const modal = document.getElementById('product-modal');
    const modalBackdrop = document.getElementById('modal-backdrop');
    const closeModalButton = document.getElementById('close-modal-button');
    const viewProductButtons = document.querySelectorAll('.view-product-btn');
    const modalLoading = document.getElementById('modal-loading');
    const productDetails = document.getElementById('product-details');
    
    // Function to open modal
    function openModal() {
        modal.classList.remove('hidden');
        document.body.classList.add('overflow-hidden'); // Prevent scrolling
    }
    
    // Function to close modal
    function closeModal() {
        modal.classList.add('hidden');
        document.body.classList.remove('overflow-hidden'); // Restore scrolling
        
        // Reset modal content
        setTimeout(() => {
            productDetails.classList.add('hidden');
            modalLoading.classList.remove('hidden');
        }, 300);
    }
    
    // Add click event to view product buttons
    viewProductButtons.forEach(button => {
        button.addEventListener('click', async function(e) {
            e.preventDefault();
            
            const productId = this.getAttribute('data-product-id');
            openModal();
            
            // Show loading indicator
            modalLoading.classList.remove('hidden');
            
            try {
                // Fetch product details - adjust path if needed
                const response = await fetch(`api/get-product.php?id=${productId}`);
                
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                
                const data = await response.json();
                
                // Hide loading
                modalLoading.classList.add('hidden');
                productDetails.classList.remove('hidden');
                
                // Populate modal with product details
                document.getElementById('modal-product-name').textContent = data.product.name;
                document.getElementById('modal-product-brand').textContent = data.product.brand;
                document.getElementById('modal-product-description').textContent = 
                    data.product.description || 'No description available';
                document.getElementById('modal-product-image').src = data.product.image;
                document.getElementById('modal-product-image').alt = data.product.name;
                
                // Set source link
                const sourceLink = document.getElementById('modal-product-source');
                if (data.product.link) {
                    sourceLink.href = data.product.link;
                    sourceLink.classList.remove('hidden');
                } else {
                    sourceLink.classList.add('hidden');
                }
                
                // Update modal title
                document.getElementById('modal-title').textContent = data.product.name;
                
            } catch (error) {
                console.error('Error fetching product details:', error);
                modalLoading.classList.add('hidden');
                productDetails.classList.remove('hidden');
                productDetails.innerHTML = `
                    <div class="text-center w-full py-8">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <h3 class="mt-4 text-lg font-medium text-gray-900">Error loading product</h3>
                        <p class="mt-2 text-gray-500">Unable to load product details. Please try again later.</p>
                    </div>
                `;
            }
        });
    });
    
    // Close modal when clicking the backdrop or close button
    if (closeModalButton) closeModalButton.addEventListener('click', closeModal);
    if (modalBackdrop) modalBackdrop.addEventListener('click', closeModal);
    
    // Close modal when pressing Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && modal && !modal.classList.contains('hidden')) {
            closeModal();
        }
    });
    
    // Search functionality
    const searchInput = document.getElementById('search');
    const productsContainer = document.getElementById('products-container');
    const productCards = document.querySelectorAll('.product-card');
    
    if (searchInput) {
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
    }
    
    // Sort products
    const sortSelect = document.getElementById('sort');
    if (sortSelect) {
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
    }
});
</script>