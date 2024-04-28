<?php
session_start();
if (!file_exists(('./config.php'))) {
    header('Location: ./installation.php');
    exit;
}

//if (isset($_SESSION['user_id'])) {
//
//}

