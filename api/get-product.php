<?php
// filepath: f:\projects\web_eng_lab_reports\project\php_website\api\get-product.php
require_once __DIR__ . '/../models/product.php';

if (!isset($_GET['id'])) {
    echo json_encode(['error' => 'Product ID is required']);
    exit();
}

$productId = intval($_GET['id']);
$product = Product::getProductById($productId);
$alternatives = Product::getAlternatives($productId);

// Combine product details and alternatives in one response
$response = [
    'product' => $product,
    'alternatives' => $alternatives
];

header('Content-Type: application/json');
echo json_encode($response);
?>