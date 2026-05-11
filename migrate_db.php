<?php
include 'includes/db.php';
try {
    $pdo->exec("ALTER TABLE users ADD COLUMN restaurant_id INT(11) NULL");
    $pdo->exec("ALTER TABLE users ADD CONSTRAINT fk_user_restaurant FOREIGN KEY (restaurant_id) REFERENCES restaurants(restaurant_id) ON DELETE SET NULL");
    echo "Success: restaurant_id added to users table.";
} catch (PDOException $e) {
    echo "Error or already exists: " . $e->getMessage();
}
?>
