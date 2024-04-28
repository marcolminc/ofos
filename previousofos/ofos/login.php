<?php
// session_start();
// if (!file_exists(('./config.php'))) {
//     header('Location: ./installation.php');
//     exit;
// }
// require('./config.php');

// if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
//     $email = $pass = null;
//     $errors = array();
//     if (empty( $_POST['email'])) {
//         $errors[] = 'required email';
//     } else if (strpos($_POST['email'], '@')) {
//         $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
//         if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
//             $errors[] = 'email format maybe incorrect';
//         }
//     }
//     if (empty($_POST['password'])) {
//         $errors[] = 'required password';
//     } else {
//         $pass = trim($_POST['password']);
//     }
//     if (empty($errors)) {
//         require './config.php';
//         $pdo = new PDO("mysql:host=$host;dbname=$database", $username, $password);
//         try {
//             $stmt = $pdo -> prepare("SELECT * FROM representatives WHERE email = :email");
//             $stmt -> bindParam(':email', $email);
//                 $stmt -> execute();
//                 $rep = $stmt -> fetch(PDO::FETCH_ASSOC);
//                 if ($rep) {
//                     if ($rep['password'] === $pwd) {
//                         $_SESSION['rep_id'] = $rep['rep_id'];
//                         $_SESSION['user_type'] = 'rep';
//                         $_SESSION['username'] = $rep['username'];
//                         //response
//                     } else {
//                         $errors[] = 'invalid email or password';
//                     }
//                 } else {
//                     $stmt = $pdo -> prepare("SELECT * FROM representatives WHERE email = :email");
//                     $stmt -> bindParam(':email', $email);
//                     $stmt -> execute();
//                     $cust = $stmt -> fetch(PDO::FETCH_ASSOC);
//                     if ($cust) {
//                         if ($cust['password'] === $pass) {
//                             $_SESSION['cust_id'] = $cust['cust_id'];
//                             $_SESSION['user_type'] = 'cust';
//                             $_SESSION['username'] = $cust['username'];
//                             //response
//                         } else {
//                             $errors[] = 'invalid email or password';
//                         }
//                     }
//                 }
//         } catch(Exception $e) {

//         }
//     }
// }

session_start();
if (!file_exists('./config.php')) {
    header('Location: ./installation.php');
    exit;
}
require('./config.php');

if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
    $email = $pass = null;
    $errors = array();

    if (empty($_POST['email'])) {
        $errors[] = 'required email';
    } else if (strpos($_POST['email'], '@')) {
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'email format maybe incorrect';
        }
    }

    if (empty($_POST['password'])) {
        $errors[] = 'required password';
    } else {
        $pass = trim($_POST['password']);
    }

    if (empty($errors)) {
        try {
            $pdo = new PDO("mysql:host=$host;dbname=$database", $username, $password);
            $stmt = $pdo->prepare("SELECT * FROM representatives WHERE email = :email");
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            $rep = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($rep) {
                if ($rep['password'] === $pass) {
                    $_SESSION['rep_id'] = $rep['rep_id'];
                    $_SESSION['user_type'] = 'rep';
                    $_SESSION['username'] = $rep['username'];

                    $response = array('success' => true, 'msg' => 'Logged in successfully', 'userType' => 'rep');
                    header('Content-Type: application/json');
                    echo json_encode($response);
                    exit;
                } else {
                    $errors[] = 'Invalid email or password';
                }
            } else {
                $stmt = $pdo->prepare("SELECT * FROM reg_customers WHERE email = :email");
                $stmt->bindParam(':email', $email);
                $stmt->execute();
                $cust = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($cust) {
                    if ($cust['password'] === $pass) {
                        $_SESSION['cust_id'] = $cust['cust_id'];
                        $_SESSION['user_type'] = 'cust';
                        $_SESSION['username'] = $cust['username'];

                        $response = array('success' => true, 'msg' => 'Logged in successfully', 'userType' => 'cust');
                        header('Content-Type: application/json');
                        echo json_encode($response);
                        exit;
                    } else {
                        $errors[] = 'Invalid email or password';
                    }
                } else {
                    $errors[] = 'Invalid email or password';
                }
            }
        } catch (Exception $e) {
            $errors[] = 'Error: ' . $e->getMessage();
        }
    }

    $response = array('success' => false, 'msg' => implode(', ', $errors));
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}
?>

