<?php
session_start();
if (!file_exists(('./config.php'))) {
    header('Location: ./installation.php');
    exit;
}
require('./functions.php');

// Placeholder for data fields and errors
$email = $password = $emailErr = $passwordErr = '';
$inputErrs = [];
$response = [];

if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
    // Validation and data sanitization
    // Check email
    if (empty($_REQUEST["email"])) {
        $inputErrs[] = "Email is required";
    } else if (!checkEmail($_REQUEST["email"])){
        $inputErrs[] = "Invalid Email Address";
    } else {
        $email = filterInput($_REQUEST["email"]);
    }

    if (empty($_REQUEST["password"])) {
        $inputErrs[] = "Password is required";
    } else if (!validatePass($_REQUEST["password"])) {
        $inputErrs[] = "password strength {a-z, A-Z, 0-9, special characters}";
    } else {
        $password = $_REQUEST["password"];
    }

    if (count($inputErrs) === 0) {
        try {
                require_once('./config.php');
                $pdo = new PDO("mysql:host=$host;dbname=$database", $username, $password);
        
                $stmt = $pdo->prepare("SELECT * 
                                        FROM representatives 
                                        WHERE email = :email 
                                        AND password = :pass");
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':pass', $password);
                $stmt->execute();
                $rep = $stmt->fetch(PDO::FETCH_ASSOC);
                if ($rep) {
                    // Take a rep to dashboard
                    $success = true;
                    $msg = 'logged in successfully';
                    $_SESSION['user_id'] = $rep['rep_id'];
                    $_SESSION['user_type'] = 'rep';
                    $response = array('success' => $success, 'msg' => $msg, 'userType' => 'rep');
                    header('Content-Type: application/json');
                    echo json_encode($response);
                    exit;
                    } else {
                    $stmt = $pdo->prepare("SELECT * FROM reg_customers WHERE email = :email AND password = :pass");
                    $stmt->bindParam(':email', $email);
                    $stmt->bindParam(':pass', $password);
                    $stmt->execute();
                    $cust = $stmt->fetch(PDO::FETCH_ASSOC);
                    if ($cust) {
                        $success = true;
                        $msg = 'logged in successfully';
                        // Store logged-in user information in session or perform any other action
                        $_SESSION['user_id'] = $cust['cust_id'];
                        $_SESSION['user_type'] = 'cust';
                        $response = array('success' => $success, 'msg' => $msg, 'userType' => 'cust');
                        header('Content-Type: application/json');
                        echo json_encode($response);
                        exit;
                    } else {
                        $response = array('success' => false, 'msg' => ['invalid username or password', 'no input errors']);
                        header('Content-Type: application/json');
                        echo json_encode($response);
                        exit;
                    }
            }
        } catch (Exception $e) {
            $success = false;
            $msg = $e->getMessage();
            $response = array('success' => $success, 'msg' => $msg);
            header('Content-Type: application/json');
            echo json_encode($response);
            exit;
        }
    } else {
        $response = array('success' => false, 'msg' => ['invalid username or password', 'input errors']);
        header('Content-Type: application/json');
        echo json_encode($response);
        exit;
    }

    
}




// <?php
// CartViewController.php

class CartViewController {
    private $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function execute() {
        // Check if the cart is empty
        if (empty($_SESSION['cart'])) {
            echo '<p>Your cart is empty.</p>';
            return;
        }

        // Fetch the menu items from the database based on the cart
        $itemIds = array_keys($_SESSION['cart']);
        $placeholders = rtrim(str_repeat('?, ', count($itemIds)), ', ');
        $query = $this->pdo->prepare("SELECT * FROM menu_items WHERE item_id IN ($placeholders)");
        $query->execute($itemIds);
        $menuItems = $query->fetchAll(PDO::FETCH_ASSOC);

        // Display the cart items
        echo '<h1>Cart</h1>';
        echo '<div class="cart-container">';
        echo '<table>';
        echo '<tr>
                <th>Item Name</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Total</th>
                <th></th>
            </tr>';

        $totalPrice = 0;

        foreach ($menuItems as $menuItem) {
            $itemId = $menuItem['item_id'];
            $itemName = $menuItem['name'];
            $price = $menuItem['price'];
            $quantity = $_SESSION['cart'][$itemId];
            $subtotal = $price * $quantity;
            $totalPrice += $subtotal;

            echo '<tr>
                    <td>' . $itemName . '</td>
                    <td>$' . $price . '</td>
                    <td>' . $quantity . '</td>
                    <td>$' . $subtotal . '</td>
                    <td><a href="remove-from-cart.php?item_id=' . $itemId . '">Remove</a></td>
                </tr>';
        }

        echo '</table>';

        // Display the total price and checkout button
        echo '<div class="cart-summary">';
        echo 'Total Price: $' . $totalPrice;
        echo '<a href="checkout.php" class="checkout-button">Proceed to Checkout</a>';
        echo '</div>';

        echo '</div>';
    }
}

// Create an instance of the CartViewController and execute it
$cartViewController = new CartViewController($pdo);
$cartViewController->execute();


?>





<?php
// CartController.php

class CartController {
    private $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function addToCart($itemId, $quantity) {
        // Get the item details from the database
        $query = $this->pdo->prepare("SELECT * FROM menu_items WHERE item_id = ?");
        $query->execute([$itemId]);
        $item = $query->fetch(PDO::FETCH_ASSOC);

        // Add the item to the cart session
        $_SESSION['cart'][] = [
            'item_id' => $itemId,
            'name' => $item['name'],
            'price' => $item['price'],
            'quantity' => $quantity
        ];

        echo '<div class="success-message">Item added to cart!</div>';
    }

    public function removeFromCart($itemId) {
        // Remove the item from the cart session
        foreach ($_SESSION['cart'] as $key => $item) {
            if ($item['item_id'] == $itemId) {
                unset($_SESSION['cart'][$key]);
                echo '<div class="success-message">Item removed from cart!</div>';
                return;
            }
        }
    }

    public function updateCart($itemId, $quantity) {
        // Update the quantity of the item in the cart session
        foreach ($_SESSION['cart'] as &$item) {
            if ($item['item_id'] == $itemId) {
                $item['quantity'] = $quantity;
                echo '<div class="success-message">Cart updated!</div>';
                return;
            }
        }
    }

    public function viewCart() {
        // Display the items in the cart
        echo '<h1>Cart</h1>';
        if (empty($_SESSION['cart'])) {
            echo '<p>Your cart is empty.</p>';
        } else {
            echo '<table>';
            echo '<tr><th>Name</th><th>Price</th><th>Quantity</th><th>Actions</th></tr>';
            foreach ($_SESSION['cart'] as $item) {
                echo '<tr>';
                echo '<td>' . $item['name'] . '</td>';
                echo '<td>$' . $item['price'] . '</td>';
                echo '<td>';
                echo '<input type="number" min="1" value="' . $item['quantity'] . '" onchange="updateCart(' . $item['item_id'] . ', this.value)">';
                echo '</td>';
                echo '<td>';
                echo '<button onclick="removeFromCart(' . $item['item_id'] . ')">Remove</button>';
                echo '</td>';
                echo '</tr>';
            }
            echo '</table>';
            echo '<p>Total: $' . $this->calculateTotal() . '</p>';
            echo '<button onclick="checkout()">Checkout</button>';
        }
    }

    private function calculateTotal() {
        $total = 0;
        foreach ($_SESSION['cart'] as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        return $total;
    }
}

// Create an instance of the CartController
$cartController = new CartController($pdo);

// Check if any action is requested (add, remove, update, view)
if ($_SERVER['
REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
    switch ($_POST['action']) {
    case 'add':
    $itemId = $_POST['item_id'];
    $quantity = $_POST['quantity'];
    $cartController->addToCart($itemId, $quantity);
    break;
    case 'remove':
    $itemId = $_POST['item_id'];
    $cartController->removeFromCart($itemId);
    break;
    case 'update':
    $itemId = $_POST['item_id'];
    $quantity = $_POST['quantity'];
    $cartController->updateCart($itemId, $quantity);
    break;
    }
    }
    }
    
    // Check if the view cart action is requested
    if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'view_cart') {
    $cartController->viewCart();
    }
    

    // To use the `CartController`, you can include the code in a PHP file and include it in the relevant pages where the cart functionality is needed. You can also customize the HTML output of the `viewCart()` method to match your desired cart layout and styling.
    
    // Remember to handle the checkout process separately, which involves collecting customer information and completing the order transaction. You can create a separate page or form to handle the checkout process and interact with the necessary database tables to store the order details.
    
    // Feel free to customize the code according to your specific require



    // <?php
    session_start();
    
    // Check if the item ID and quantity are provided
    if (isset($_POST['item_id']) && isset($_POST['quantity'])) {
        $itemId = $_POST['item_id'];
        $quantity = $_POST['quantity'];
    
        // Add the item to the cart or update the quantity
        if (isset($_SESSION['cart'][$itemId])) {
            $_SESSION['cart'][$itemId] += $quantity;
        } else {
            $_SESSION['cart'][$itemId] = $quantity;
        }
    
        // Redirect back to the product page or display a success message
        header('Location: product.php?id=' . $itemId);
        exit();
    }
    