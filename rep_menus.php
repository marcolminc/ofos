<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
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

// Function to fetch data from the menu table template based on menu_title
function fetchMenuData($pdo, $menuTitle) {
    try {
        $tableName = str_replace(' ', '_', $menuTitle);
        $stmt = $pdo->prepare("SELECT * FROM `$tableName`");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        return array('error' => shortenErrorMessage($e->getMessage()));
    }
}
function shortenErrorMessage($errorMessage) {
    // Check if the error message contains the substring "Base table or view not found"
    $pos = strpos($errorMessage, "Base table or view not found");
    
    // If the substring is found, return the shortened message
    if ($pos !== false) {
        return substr($errorMessage, 0, $pos + strlen("Base table or view not found"));
    }
    
    // If the substring is not found, return the original error message
    return $errorMessage;
}


    $pdo = new PDO("mysql:host=$host;dbname=$database", $username, $password);
    $menus = [];
    $errors = [];

            try {
                // Fetch rest_id via rep_id
                $stmt = $pdo->prepare("SELECT rest_id FROM restaurants WHERE rep_id = :rep_id");
                $stmt->bindParam(':rep_id', $_SESSION['rep_id']);
                if ($stmt->execute()) {
                    $rest_id = $stmt->fetch(PDO::FETCH_ASSOC);
                    // Fetch menu titles for the given rest_id
                    $stmt = $pdo->prepare("SELECT * FROM menu_titles WHERE rest_id = :rest_id");
                    $stmt->bindParam(':rest_id', $rest_id['rest_id']);
                    if ($stmt->execute()) {
                        // Fetched titles
                        $menuTitles = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($menuTitles as $menuTitleTuple) {
                            $menuTitle = $menuTitleTuple['menu_title'];
                            $menuEntries = fetchMenuData($pdo, $menuTitle);
                            $truncatedTitle = substr($menuTitle, strpos($menuTitle, 'menu_') + 5);
                            $menus[$truncatedTitle] = $menuEntries;
                        }
                    } else {
                        // Failed to fetch titles
                        $errors[] = 'failed to fetch titles';
                    }
                } else {
                    // Error fetching rest_id
                    $errors[] = 'error fetching rest_id';
                }
            } catch (PDOException $e) {
                $errors[] = shortenErrorMessage($e->getMessage());
            }

    if (count($errors) === 0) {
        header('Content-Type: application/json');
        echo json_encode($menus);
        exit;
    } else {
        header('Content-Type: application/json');
        echo json_encode(implode('\n', $errors));
        exit;
    }
