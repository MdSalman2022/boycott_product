<?php
// filepath: f:\projects\web_eng_lab_reports\lab_project\final_php_website\suggested-products.php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    // Not logged in, redirect to login page
    header("Location: login.php");
    exit;
}

require_once 'config/db.php';
require_once 'models/product.php';

$userId = $_SESSION['user_id'];
$userName = $_SESSION['name'] ?? 'User';

// Fetch products suggested by the current user
try {
    $query = "SELECT p.*, c.name AS category_name 
             FROM products p 
             LEFT JOIN categories c ON p.category_id = c.id
             WHERE p.created_by = ? 
             ORDER BY p.created_at DESC";
    
    $stmt = mysqli_prepare($mysqli, $query);
    mysqli_stmt_bind_param($stmt, "i", $userId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    $suggestedProducts = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $suggestedProducts[] = $row;
    }
} catch (Exception $e) {
    $error = "Unable to fetch your suggested products: " . $e->getMessage();
}

// Include header
require_once 'includes/header.php';
?>

<div class="container mx-auto px-4 py-8">
    <div class="max-w-5xl mx-auto">
        <!-- Header Section -->
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-8">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-gray-800 mb-2">My Suggested Products</h1>
                <p class="text-gray-600">Products you've suggested for the boycott list</p>
            </div>
            <a href="suggest-product.php" class="mt-4 md:mt-0 inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                Suggest New Product
            </a>
        </div>

        <?php if (!empty($error)): ?>
            <div class="bg-red-50 border-l-4 border-red-400 p-4 mb-6 rounded-md">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-red-700"><?= htmlspecialchars($error) ?></p>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <?php if (empty($suggestedProducts)): ?>
            <!-- Empty state -->
            <div class="text-center py-12 bg-gray-50 rounded-lg border border-gray-100 shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                </svg>
                <h3 class="mt-4 text-lg font-medium text-gray-900">No suggested products yet</h3>
                <p class="mt-2 text-gray-500 max-w-md mx-auto">You haven't suggested any products for the boycott list yet. Start by suggesting a product you believe should be boycotted.</p>
                <div class="mt-6">
                    <a href="suggest-product.php" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Suggest Your First Product
                    </a>
                </div>
            </div>
        <?php else: ?>
            <!-- Product grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php foreach ($suggestedProducts as $product): ?>
                    <div class="bg-white rounded-lg border border-gray-200 overflow-hidden shadow-sm hover:shadow-md transition-shadow">
                        <div class="relative pb-2/3">
                            <img 
                                src="<?= htmlspecialchars($product['image']) ?>" 
                                alt="<?= htmlspecialchars($product['name']) ?>"
                                class="absolute h-full w-full object-cover"
                                onerror="this.src='images/placeholder.jpg'; this.onerror='';"
                            >
                        </div>
                        <div class="p-4">
                            <div class="flex justify-between items-start mb-2">
                                <h3 class="text-lg font-semibold text-gray-900 line-clamp-2"><?= htmlspecialchars($product['name']) ?></h3>
                                <span class="px-2 py-1 text-xs rounded-full <?= $product['status'] === 'active' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' ?>">
                                    <?= ucfirst(htmlspecialchars($product['status'])) ?>
                                </span>
                            </div>
                            <p class="text-sm text-gray-600 mb-2">Brand: <span class="font-medium"><?= htmlspecialchars($product['brand']) ?></span></p>
                            <?php if (!empty($product['category_name'])): ?>
                                <p class="text-xs text-gray-500 mb-3">Category: <?= htmlspecialchars($product['category_name']) ?></p>
                            <?php endif; ?>
                            
                            <?php if (!empty($product['description'])): ?>
                                <div class="mt-2 mb-3">
                                    <p class="text-sm text-gray-700 line-clamp-3"><?= htmlspecialchars($product['description']) ?></p>
                                </div>
                            <?php endif; ?>
                            
                            <div class="flex justify-between items-center mt-4">
                                <a href="<?= htmlspecialchars($product['link']) ?>" target="_blank" rel="noopener noreferrer" class="text-blue-600 hover:text-blue-800 text-sm flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                                    </svg>
                                    Source
                                </a>
                                <span class="text-xs text-gray-500">
                                    <?= date('M j, Y', strtotime($product['created_at'])) ?>
                                </span>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Add for line-clamp support -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add line-clamp support for older browsers
    const lineClampElements = document.querySelectorAll('.line-clamp-2, .line-clamp-3');
    lineClampElements.forEach(el => {
        if (el.classList.contains('line-clamp-2')) {
            el.style.display = '-webkit-box';
            el.style.webkitLineClamp = '2';
            el.style.webkitBoxOrient = 'vertical';
            el.style.overflow = 'hidden';
        } else if (el.classList.contains('line-clamp-3')) {
            el.style.display = '-webkit-box';
            el.style.webkitLineClamp = '3';
            el.style.webkitBoxOrient = 'vertical';
            el.style.overflow = 'hidden';
        }
    });
});
</script>
 