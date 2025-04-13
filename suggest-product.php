<?php

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


// filepath: f:\projects\web_eng_lab_reports\lab_project\final_php_website\suggest-product.php
require_once 'config/db.php';
require_once 'models/product.php';

// Fetch all categories before including header
try {
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
    $categoryError = "Unable to load categories: " . $e->getMessage();
}

$formError = "";
$formSuccess = "";
$redirectCountdown = 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $brand = $_POST['brand'];
    $source = $_POST['link'];
    $image = $_POST['image'];
    $status = "pending"; // Set status to pending for moderation
    $is_israeli = 1; // Default to Israeli product
    $description = $_POST['description'] ?? '';
    $category_id = !empty($_POST['category_id']) ? $_POST['category_id'] : null;
    $user_id = $_SESSION['user_id']; // Get the user ID from the session
    
    // Add product to database - pass the user ID as an additional parameter
    $success = Product::createProduct($name, $brand, $source, $image, $is_israeli, $status, $description, $category_id, $user_id); 
    
    if ($success) {
        $formSuccess = "Thank you for your suggestion! It has been submitted for review.";
        // Set redirect countdown to 3 seconds
        $redirectCountdown = 3;
        // Fallback server-side redirect after 3 seconds
        header("Refresh: 3; URL=index.php");
    } else {
        $formError = "There was an error submitting your suggestion. Please try again.";
    }
}
// Include header AFTER all header() calls
require_once 'includes/header.php';
?>
 
<script src="https://cdn.tailwindcss.com"></script>

<div class="container mx-auto px-4 py-8 max-w-md">
    <?php if (!empty($formError)): ?>
    <div class="bg-red-50 border-l-4 border-red-400 p-4 mb-4 rounded-md">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                </svg>
            </div>
            <div class="ml-3">
                <p class="text-sm text-red-700"><?= $formError ?></p>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <?php if (!empty($formSuccess)): ?>
    <div class="bg-green-50 border-l-4 border-green-400 p-4 mb-4 rounded-md">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                </svg>
            </div>
            <div class="ml-3">
                <p class="text-sm text-green-700">
                    <?= $formSuccess ?> 
                    <span id="countdown-timer" class="font-medium">
                        Redirecting to home page in <?= $redirectCountdown ?> seconds...
                    </span>
                </p>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <?php if (empty($formSuccess)): ?>
    <div class="bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-xl font-semibold mb-4">Suggest a Boycott Israel Product</h2>
        <form action="" method="POST">
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Product Name</label>
                <input type="text" id="name" name="name" class="border border-gray-300 rounded-md w-full p-2 text-sm focus:ring-blue-500 focus:border-blue-500" required>
            </div>
            <div class="mb-4">
                <label for="brand" class="block text-sm font-medium text-gray-700 mb-1">Brand</label>
                <input type="text" id="brand" name="brand" class="border border-gray-300 rounded-md w-full p-2 text-sm focus:ring-blue-500 focus:border-blue-500" required>
            </div>
            
            <!-- Category Selection -->
            <div class="mb-4">
                <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                <select id="category_id" name="category_id" class="border border-gray-300 rounded-md w-full p-2 text-sm focus:ring-blue-500 focus:border-blue-500">
                    <option value="">-- Select a category --</option>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?= $category['id'] ?>"><?= htmlspecialchars($category['name']) ?></option>
                    <?php endforeach; ?>
                </select>
                <?php if (isset($categoryError)): ?>
                    <p class="mt-1 text-xs text-red-600"><?= $categoryError ?></p>
                <?php endif; ?>
            </div>
            
            <div class="mb-4">
                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                <textarea id="description" name="description" rows="3" class="border border-gray-300 rounded-md w-full p-2 text-sm resize-y focus:ring-blue-500 focus:border-blue-500"></textarea>
                <p class="mt-1 text-xs text-gray-500">Provide details about why this product should be boycotted</p>
            </div>
            <div class="mb-4">
                <label for="image" class="block text-sm font-medium text-gray-700 mb-1">Image Link</label>
                <input type="text" id="image" name="image" class="border border-gray-300 rounded-md w-full p-2 text-sm focus:ring-blue-500 focus:border-blue-500" required>
                <p class="mt-1 text-xs text-gray-500">Direct link to product image</p>
            </div>
            <div class="mb-6">
                <label for="link" class="block text-sm font-medium text-gray-700 mb-1">Source Link</label>
                <input type="url" id="link" name="link" class="border border-gray-300 rounded-md w-full p-2 text-sm focus:ring-blue-500 focus:border-blue-500" required>
                <p class="mt-1 text-xs text-gray-500">Link to the product page or information source</p>
            </div>
            <div class="flex justify-end space-x-3">
                <a href="index.php" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 transition-colors text-sm">Cancel</a>
                <button type="submit" name="submit-product" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors text-sm">Submit</button>
            </div>
        </form>
    </div>
    <?php endif; ?>
</div>

<!-- Image Preview and Redirect Script -->
<script>
document.getElementById('image')?.addEventListener('input', function() {
    // Create preview functionality if desired
    console.log('Image URL changed:', this.value);
});

// Countdown and redirect
<?php if ($redirectCountdown > 0): ?>
let secondsLeft = <?= $redirectCountdown ?>;
const countdownElement = document.getElementById('countdown-timer');

const countdownInterval = setInterval(() => {
    secondsLeft--;
    if (secondsLeft <= 0) {
        clearInterval(countdownInterval);
        window.location.href = 'index.php';
    } else {
        countdownElement.textContent = `Redirecting to home page in ${secondsLeft} second${secondsLeft !== 1 ? 's' : ''}...`;
    }
}, 1000);
<?php endif; ?>
</script>