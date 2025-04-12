<?php
// user.php
require_once 'config/db.php';


class User {
    public static function getUserByPhone($phone) {
        global $mysqli;
        $stmt = $mysqli->prepare("SELECT * FROM users WHERE phone = ?");
        $stmt->bind_param("s", $phone);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public static function addUser($name, $phone, $hashedPassword, $role = 'user') {
        global $mysqli;
        $stmt = $mysqli->prepare("INSERT INTO users (name, phone, password, role) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $phone, $hashedPassword, $role);
        $stmt->execute();
    }
}
?>
