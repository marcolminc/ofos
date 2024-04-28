<?php
session_start();
if (!file_exists(('./config.php'))) {
    header('Location: ./installation.php');
    exit;
}
$ctgr = $_GET['category'] === '' ? 'all': $_GET['category'];
$ctgr = strtolower($ctgr);

require_once('./config.php');
try {
    $pdo = new PDO("mysql:host=$host; dbname=$database", $username, $password);
    if ($ctgr === 'all') {
            $query =  $pdo -> prepare('SELECT * FROM restaurants');
        } else {
            $query = $pdo -> prepare('SELECT * FROM restaurants WHERE category = :ctgr');
            $query -> bindParam(':ctgr', $ctgr);
        }
        $query -> execute();
        $restaurants = $query -> fetchAll(PDO::FETCH_ASSOC);

        
        if ($restaurants) {
            echo (json_encode($restaurants));
        } else {
            echo (json_encode('unavailable cateogory or no entries'));
        }
} catch(Exception $e) {
    echo $e->getMessage();
}
// var_dump($restaurants);
// // html for restaurant cards




