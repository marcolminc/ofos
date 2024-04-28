<?php
session_start();
if (!file_exists('./config.php')) {
    header('Location: ./installation.php');
    exit;
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
                $rest_id = $_REQUEST['rest_id'];
                    $stmt = $pdo->prepare("SELECT * FROM menu_titles WHERE rest_id = :rest_id");
                    $stmt->bindParam(':rest_id', $rest_id);
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
                } catch (Exception $e) {
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
