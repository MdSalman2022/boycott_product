<?php

// To this:
require_once __DIR__ . '/../models/product.php';

// Ensure we have a product_id
if (!isset($_GET['product_id']) || empty($_GET['product_id'])) {
    // Return empty array if no product_id is provided
    echo json_encode([]);
    exit();
}

// Get the product ID from the request
$productId = intval($_GET['product_id']);

// Fetch alternatives using the Product class method
$alternatives = Product::getAlternatives($productId);

// Set the content type to JSON
header('Content-Type: application/json');

// Return the alternatives as JSON
echo json_encode($alternatives);
?>