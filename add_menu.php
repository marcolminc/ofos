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
require('./functions.php');
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
    $pdo = new PDO("mysql:host=$host;dbname=$database", $username, $password);
    $items = [];
    $errors = [];
    $menuTitle = $itemName = $itemPrice = null;
    if (empty($_REQUEST['menu-title'])) {
        $errors[] = 'menu title is required';
    } else {
        $menuTitle = filterInput($_REQUEST['menu-title']);
        // Loop through the form fields to retrieve item names and prices
        for ($i = 1; $i <= 3; $i++) {
            $itemName = filterInput($_REQUEST['item' . $i]);
            $itemPrice = filterInput($_REQUEST['price' . $i]);
        
            // Check if both item name and price are provided
            if (!empty($itemName) && !empty($itemPrice)) {
                    $items[] = array(
                    'name' => $itemName,
                    'price' => $itemPrice
                );
            }
        }
        if (!empty($menuTitle) && (count($items) > 0)) {
            //search rest name to concatenate with menu title:
            $stmt = $pdo->prepare("SELECT * FROM restaurants WHERE rep_id = :rep_id");
            $stmt->bindParam(':rep_id', $_SESSION['rep_id']);
            $stmt->execute();
            $restaurant = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($restaurant) {
                $menuTitle = $restaurant['name'] . '_' . 'menu_'. $menuTitle;
                $menuTitle = str_replace(' ', '_', $menuTitle);
                // Add menu title to the menu_titles table
                try {
                    $stmt = $pdo->prepare("INSERT INTO menu_titles (rest_id, menu_title) VALUES (:rest_id, :menu_title)");
                    $stmt->bindParam(':rest_id', $restaurant['rest_id']);
                    $stmt->bindParam(':menu_title', $menuTitle);
                    if ($stmt->execute()) {//execution succeed
                        $menuId = $pdo->lastInsertId();
                        // create menu-specific table
                        try {
                            $stmt = $pdo->prepare("CREATE TABLE IF NOT EXISTS `$menuTitle` (
                                entry_id INT AUTO_INCREMENT PRIMARY KEY,
                                entry_name VARCHAR(255) NOT NULL,
                                price INT NOT NULL,
                                menu_id INT,
                                FOREIGN KEY (menu_id) REFERENCES menu_titles(menu_id)
                            )");
                            if ($stmt->execute()) {
                                // Insert menu items into the menu-specific table
                                $stmt = $pdo->prepare("INSERT INTO `$menuTitle` (entry_name, price, menu_id) VALUES (:entry_name, :price, :menu_id)");
                                foreach ($items as $item) {
                                    $stmt->bindValue(':entry_name', $item['name']);
                                    $stmt->bindValue(':price', $item['price']);
                                    $stmt->bindValue(':menu_id', $menuId);
                                    if (!$stmt->execute()) {
                                        // Handle the error here, for example, you can log the error or add it to an error array
                                        $errors[] = 'Error inserting into menu table: ' . implode(' - ', $stmt->errorInfo());
                                    }
                                }
                            } else {
                                $errors[] = 'could not create table for menu';
                            }
                        } catch(PDOException $e) {
                            $errors[] = 'exception creating table or inserting';
                            $errors[] = $e->getMessage();
                        }
                    } else {
                        //other executon errors than pdo exception
                        $errors[] = 'Error inserting into menu_titles table.';
                    }
                } catch(PDOException $e) {
                    $errors[] = 'Menu title already exists:';
                    $errors[] = $e->getMessage();
                }
                
            } else {
                $errors[] = 'could not identify your restaurant';
            }
        } else {
            $errors[] = 'required atleast 1 menu item';
        }
    }
    if (count($errors) === 0) {
        $response = array (
            'success' => true,
            'message' => 'Menu added successfully'
        );
        header('Content-Type: application/json');
        echo json_encode($response);
        exit;
    } else {
        $response = array(
            'success' => false,
            'message' => implode('\n', $errors)
        );
        header('Content-Type: application/json');
        echo json_encode($response);
        exit;
    }
}
