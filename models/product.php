<?php
// product.php
require_once __DIR__ . '/../config/db.php';

class Product {

    public static function createProduct($name, $brand, $source, $image, $is_israeli = 1, $status = 'active', $description = '') {
        global $mysqli;
        // Changed query to include status and description
        $query = "INSERT INTO products (name, brand, link, image, is_israeli, status, description) 
                  VALUES (?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = mysqli_prepare($mysqli, $query);
        // Change 'ssssis' to 'ssssiss' - adding the final 's' for description
        mysqli_stmt_bind_param($stmt, 'ssssiss', 
                              $name, $brand, $source, $image, $is_israeli, $status, $description);
        
        $success = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        
        return $success;
    }
    
    // Get all products
        // Get all products with category data
    public static function getAllProducts() {
        global $mysqli;
        $query = "SELECT p.*, c.name AS category_name, c.description AS category_description 
                  FROM products p
                  LEFT JOIN categories c ON p.category_id = c.id
                  WHERE p.is_israeli = 1";
        $result = mysqli_query($mysqli, $query);
        
        if ($result) {
            return mysqli_fetch_all($result, MYSQLI_ASSOC);
        } else {
            return [];
        }
    }
    
    public static function getProductById($id) {
        global $mysqli;
        $query = "SELECT p.*, c.name AS category_name, c.description AS category_description
                  FROM products p
                  LEFT JOIN categories c ON p.category_id = c.id
                  WHERE p.id = ?";
        
        $stmt = mysqli_prepare($mysqli, $query);
        mysqli_stmt_bind_param($stmt, 'i', $id);
        mysqli_stmt_execute($stmt);
        
        $result = mysqli_stmt_get_result($stmt);
        return mysqli_fetch_assoc($result);
    }
    
    public static function getRequestedProducts() {
        global $mysqli;
        $query = "SELECT p.*, c.name AS category_name, c.description AS category_description
                  FROM products p
                  LEFT JOIN categories c ON p.category_id = c.id
                  WHERE p.is_israeli = 1 AND p.status = 'pending'";
        $result = mysqli_query($mysqli, $query);
        
        if ($result) {
            return mysqli_fetch_all($result, MYSQLI_ASSOC);
        } else {
            return [];
        }
    }
 
    // Add alternative product to alternative_products table
    public static function addAlternative($productName, $brand, $image, $link, $ref_id, $description, $status = 'active') {
        global $mysqli;
        
        // Convert empty ref_id to NULL or 0 for database integrity
        $ref_id = empty($ref_id) ? 0 : (int)$ref_id;
        
        $query = "INSERT INTO alternative_products (name, brand, image, link, ref_id, description, status) 
                  VALUES (?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = mysqli_prepare($mysqli, $query);
        mysqli_stmt_bind_param($stmt, 'ssssiss', 
                              $productName, $brand, $image, $link, $ref_id, $description, $status);
        
        $success = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        
        return $success;
    }

    public static function getAlternatives($productId) {
        global $mysqli;
        $query = "SELECT * FROM alternative_products WHERE ref_id = ? AND status = 'active'";
        
        $stmt = mysqli_prepare($mysqli, $query);
        mysqli_stmt_bind_param($stmt, 'i', $productId);
        mysqli_stmt_execute($stmt);
        
        $result = mysqli_stmt_get_result($stmt);
        
        if ($result) {
            return mysqli_fetch_all($result, MYSQLI_ASSOC);
        } else {
            return [];
        }
    }

    // Add suggested Israeli product
    public static function addSuggestedProduct($name, $brand, $image, $link) {
        global $mysqli;
        $query = "INSERT INTO suggested_products (name, brand, image, source_link) VALUES (?, ?, ?, ?)";
        
        $stmt = mysqli_prepare($mysqli, $query);
        mysqli_stmt_bind_param($stmt, 'ssss', $name, $brand, $image, $link);
        
        if (mysqli_stmt_execute($stmt)) {
            return true;
        } else {
            return false;
        }
    }

    // Delete product by ID
    public static function deleteProduct($productId) {
        global $mysqli;
        $query = "DELETE FROM products WHERE id = ?";
        
        $stmt = mysqli_prepare($mysqli, $query);
        mysqli_stmt_bind_param($stmt, "i", $productId);
        
        $success = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        
        return $success;
    } 
        public static function updateProduct($id, $name, $brand, $source, $image, $status, $category_id, $description = null) {
        global $mysqli;
        
        // Remove updated_at from the query since it doesn't exist in the table
        $query = "UPDATE products 
                 SET name = ?, 
                     brand = ?, 
                     link = ?, 
                     image = ?, 
                     status = ?, 
                     category_id = ?, 
                     description = ?
                 WHERE id = ?";
        
        $stmt = mysqli_prepare($mysqli, $query);
        
        // Bind parameters: strings, integer for category_id, string for description, integer for id
        mysqli_stmt_bind_param($stmt, 'sssssisi', 
                              $name, $brand, $source, $image, $status, $category_id, $description, $id);
        
        $success = mysqli_stmt_execute($stmt);
        
        if (!$success) {
            // Log error for debugging
            error_log("Failed to update product ID $id: " . mysqli_error($mysqli));
        }
        
        mysqli_stmt_close($stmt);
        
        return $success;
    }
}
?>