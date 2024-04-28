<?php
session_start();
if (!file_exists('./config.php')) {
    header('Location: ./installation.php');
    exit;
}
if (!isset($_SESSION['rep_id'])) {
    header('Location: ./index.php');
}
require('./config.php');

// Establish database connection using PDO
$pdo = new PDO("mysql:host=$host;dbname=$database", $username, $password);
// Retrieve form data
$menuTitle = $_REQUEST['menu-title'];
echo $menuTitle;
$items = array();

// Loop through the form fields to retrieve item names and prices
for ($i = 1; $i <= 5; $i++) {
    $itemName = $_REQUEST['item' . $i];
    $itemPrice = $_REQUEST['price' . $i];
    
    // Check if both item name and price are provided
    if (!empty($itemName) && !empty($itemPrice)) {
        $items[] = array(
            'name' => $itemName,
            'price' => $itemPrice
        );
    }
}

// Check if menu title and at least one item is provided
if (!empty($menuTitle) && count($items) > 0) {
    //search rest name to concatenate with menu title:
    $stmt = $pdo -> prepare("SELECT * FROM restaurants WHERE rep_id = :rep_id");
    $stmt ->bindParam(':rep_id', $_SESSION['rep_id']);
    $stmt -> execute();
    $restaurant = $stmt ->fetch(PDO::FETCH_ASSOC);
    if ($restaurant) {
        $restName = $restaurant['name'];
        $menuTitle = $restName . '_' . $menuTitle;
        // Add menu title to the menu_titles table
        $stmt = $pdo->prepare("INSERT INTO menu_titles (rest_id, menu_title) VALUES (:rest_id, :menu_title)");
        $stmt->bindParam(':rest_id', $restaurant['rest_id']);
        $stmt->bindParam(':menu_title', $menuTitle);
        $stmt->execute();
        $menuId = $pdo->lastInsertId();
    }
    
    
    // Create the menu-specific table for menu items
    $tableName = str_replace(' ', '_', $menuTitle);
    $stmt = $pdo->prepare("CREATE TABLE IF NOT EXISTS menu_$tableName (
        entry_id INT AUTO_INCREMENT PRIMARY KEY,
        entry_name VARCHAR(255) NOT NULL,
        price DECIMAL(10, 2) NOT NULL,
        menu_id INT,
        FOREIGN KEY (menu_id) REFERENCES menu_titles(menu_id)
    )");
    $stmt->execute();
    
    // Insert menu items into the menu-specific table
    $stmt = $pdo->prepare("INSERT INTO menu_$tableName (entry_name, price, menu_id) VALUES (:entry_name, :price, :menu_id)");
    foreach ($items as $item) {
        $stmt->bindValue(':entry_name', $item['name']);
        $stmt->bindValue(':price', $item['price']);
        $stmt->bindValue(':menu_id', $menuId);
        $stmt->execute();
    }
    
    // Send success response
    $response = array(
        'success' => true,
        'message' => 'Menu added successfully.'
    );
} else {
    // Send error response
    $response = array(
        'success' => false,
        'message' => 'Invalid data. Please provide a menu title and at least one item.'
    );
}

// Return JSON response
header('Content-Type: application/json');
echo json_encode($response);
?>
