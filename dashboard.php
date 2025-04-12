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

// Now it's safe to include the header
require_once 'includes/header.php';

// Get all products
$products = Product::getAllProducts();

$debugMode = false;
if ($debugMode) {
    echo "<pre>";
    print_r($products);
    echo "</pre>";
}
// Handle delete action
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete') {
    $productId = $_POST['product_id'];
    $success = Product::deleteProduct($productId);
    
    // Return JSON for AJAX requests
    if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest') {
        header('Content-Type: application/json');
        echo json_encode(['success' => $success]);
        exit;
    }
    
    // For regular form submissions
    header("Location: dashboard.php?deleted=" . ($success ? "success" : "error"));
    exit();
}
?>

<script src="https://cdn.tailwindcss.com"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

<!-- Toast Container -->
<div id="toast-container" class="fixed top-4 right-4 z-50 flex flex-col items-end space-y-4"></div>

<!-- Delete Confirmation Modal -->
<div id="delete-modal" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-lg shadow-lg max-w-md w-full p-6">
        <div class="flex justify-between items-center mb-4 border-b pb-3">
            <h3 class="text-lg font-semibold text-gray-900">Confirm Deletion</h3>
            <button id="close-modal" class="text-gray-500 hover:text-gray-700">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="py-4">
            <p class="text-gray-700">Are you sure you want to delete <span id="delete-product-name" class="font-semibold"></span>? This action cannot be undone.</p>
        </div>
        <div class="flex justify-end space-x-3 pt-3 border-t">
            <button id="cancel-delete" class="px-4 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300">
                Cancel
            </button>
            <button id="confirm-delete" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                Delete
            </button>
        </div>
        <input type="hidden" id="delete-product-id">
    </div>
</div>

<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-xl shadow-md overflow-hidden mb-8">
        <div class="p-6 bg-gradient-to-r from-blue-50 to-indigo-50">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-4">
                <h2 class="text-2xl font-bold text-gray-800 mb-2 md:mb-0">
                    <i class="fas fa-layer-group mr-2 text-blue-600"></i>
                    Product Dashboard
                </h2>
                <div class="flex space-x-3">
                    <a href="create-product.php" class="flex items-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-all shadow-sm">
                        <i class="fas fa-plus mr-2"></i>
                        New Product
                    </a>
                </div>
            </div>
            <p class="text-gray-600">Manage your products and review user suggestions</p>
        </div>
    </div>
    
    <!-- Display status messages -->
    <?php if (isset($_GET['error']) && $_GET['error'] === 'missing_id'): ?>
        <div class="bg-amber-50 border-l-4 border-amber-400 p-4 mb-6 rounded-md">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i class="fas fa-exclamation-triangle text-amber-400"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-amber-700">Product ID is required for editing</p>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <?php if (isset($_GET['error']) && $_GET['error'] === 'product_not_found'): ?>
        <div class="bg-red-50 border-l-4 border-red-400 p-4 mb-6 rounded-md">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i class="fas fa-exclamation-circle text-red-400"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-red-700">Product not found</p>
                </div>
            </div>
        </div>
    <?php endif; ?>
    
    <!-- Product Table -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <?php if (empty($products)): ?>
            <div class="p-16 text-center">
                <div class="bg-gray-50 rounded-full w-20 h-20 flex items-center justify-center mx-auto mb-5">
                    <i class="fas fa-box-open text-gray-300 text-3xl"></i>
                </div>
                <h3 class="text-xl font-medium text-gray-700">No products found</h3>
                <p class="text-gray-500 mt-2">Start by adding your first product</p>
                <a href="create-product.php" class="mt-4 inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                    <i class="fas fa-plus mr-2"></i> Add Product
                </a>
            </div>
        <?php else: ?>
            <table class="min-w-full border-collapse">
                <thead>
                    <tr class="bg-gray-50 text-gray-700 text-sm uppercase">
                        <th class="py-4 px-6 text-left font-semibold">Product</th>
                        <th class="py-4 px-6 text-left font-semibold">Brand</th>
                        <th class="py-4 px-6 text-left font-semibold">Category</th>
                        <th class="py-4 px-6 text-left font-semibold">Status</th>
                        <th class="py-4 px-6 text-right font-semibold">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <?php foreach ($products as $product): ?>
                    <tr class="hover:bg-gray-50">
                        <td class="py-4 px-6">
                            <div class="flex items-center">
                                <div class="h-10 w-10 flex-shrink-0 mr-3">
                                    <img class="h-10 w-10 rounded-md object-cover" src="<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>" onerror="this.src='assets/images/placeholder.png'">
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900"><?= htmlspecialchars($product['name']) ?></p>
                                </div>
                            </div>
                        </td>
                        <td class="py-4 px-6 text-gray-700"><?= htmlspecialchars($product['brand']) ?></td>
                        <td class="py-4 px-6 text-gray-700">
                            <?= !empty($product['category_name']) ? htmlspecialchars($product['category_name']) : '<span class="text-gray-400">Uncategorized</span>' ?>
                        </td>
                        <td class="py-4 px-6">
                            <?php 
                                $statusClasses = [
                                    'active' => 'bg-green-100 text-green-800',
                                    'inactive' => 'bg-gray-100 text-gray-800',
                                    'pending' => 'bg-yellow-100 text-yellow-800',
                                ];
                                $statusClass = isset($statusClasses[$product['status']]) ? $statusClasses[$product['status']] : 'bg-gray-100 text-gray-800';
                            ?>
                            <span class="px-2 py-1 text-xs font-medium rounded-full <?= $statusClass ?>">
                                <?= ucfirst(htmlspecialchars($product['status'])) ?>
                            </span>
                        </td>
                        <td class="py-4 px-6 text-right">
                            <div class="flex justify-end space-x-2">
                                <a href="edit-product.php?id=<?= $product['id'] ?>" class="px-3 py-1.5 text-xs font-medium rounded bg-blue-600 text-white hover:bg-blue-700">
                                    <i class="fas fa-pen mr-1"></i> Edit
                                </a>
                                <button 
                                    type="button"
                                    class="delete-btn px-3 py-1.5 text-xs font-medium rounded bg-red-600 text-white hover:bg-red-700"
                                    data-id="<?= $product['id'] ?>"
                                    data-name="<?= htmlspecialchars($product['name']) ?>">
                                    <i class="fas fa-trash mr-1"></i> Delete
                                </button>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</div>

<script>
// Toast notification system
function showToast(message, type = 'success') {
    const toastContainer = document.getElementById('toast-container');
    const toast = document.createElement('div');
    
    // Set classes based on notification type
    const bgColor = type === 'success' ? 'bg-green-500' : 'bg-red-500';
    const icon = type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle';
    
    toast.className = `${bgColor} text-white px-4 py-3 rounded-lg shadow-lg flex items-center mb-4`;
    toast.innerHTML = `
        <i class="fas ${icon} mr-2"></i>
        <span>${message}</span>
        <button class="ml-auto text-white hover:text-gray-100">
            <i class="fas fa-times"></i>
        </button>
    `;
    
    toastContainer.appendChild(toast);
    
    // Add event listener to close button
    const closeBtn = toast.querySelector('button');
    closeBtn.addEventListener('click', () => {
        toast.remove();
    });
    
    // Auto-dismiss after 5 seconds
    setTimeout(() => {
        toast.classList.add('opacity-0');
        setTimeout(() => toast.remove(), 300);
    }, 5000);
}

// Delete product confirmation modal
document.addEventListener('DOMContentLoaded', function() {
    const deleteModal = document.getElementById('delete-modal');
    const productNameSpan = document.getElementById('delete-product-name');
    const productIdInput = document.getElementById('delete-product-id');
    const cancelDeleteBtn = document.getElementById('cancel-delete');
    const confirmDeleteBtn = document.getElementById('confirm-delete');
    const closeModalBtn = document.getElementById('close-modal');
    
    // Open modal when delete button is clicked
    document.querySelectorAll('.delete-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const productId = this.getAttribute('data-id');
            const productName = this.getAttribute('data-name');
            
            productNameSpan.textContent = productName;
            productIdInput.value = productId;
            deleteModal.classList.remove('hidden');
        });
    });
    
    // Close modal
    function closeModal() {
        deleteModal.classList.add('hidden');
    }
    
    cancelDeleteBtn.addEventListener('click', closeModal);
    closeModalBtn.addEventListener('click', closeModal);
    
    // Handle delete confirmation
    confirmDeleteBtn.addEventListener('click', async function() {
        const productId = productIdInput.value;
        
        try {
            const response = await fetch('dashboard.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: `action=delete&product_id=${productId}`
            });
            
            const data = await response.json();
            
            if (data.success) {
                showToast('Product deleted successfully', 'success');
                // Remove the row from the table
                const productRow = document.querySelector(`.delete-btn[data-id="${productId}"]`).closest('tr');
                productRow.remove();
            } else {
                showToast('Failed to delete product', 'error');
            }
        } catch (error) {
            showToast('An error occurred', 'error');
            console.error(error);
        }
        
        closeModal();
    });
    
    // Check for URL parameters to show notifications
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('deleted') === 'success') {
        showToast('Product deleted successfully');
    } else if (urlParams.get('deleted') === 'error') {
        showToast('Failed to delete product', 'error');
    } else if (urlParams.get('created') === 'success') {
        showToast('Product created successfully');
    } else if (urlParams.get('updated') === 'success') {
        showToast('Product updated successfully');
    }
});
</script>