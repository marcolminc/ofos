<?php
if (file_exists('./config.php')) {
    header('location: ./index.php');
    exit;
}
if ($_SERVER['REQUEST_METHOD'] ==='POST') {
    $host = $_POST['host'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $database = $_POST['database'];

    try {
        $pdo = new PDO("mysql:host = $host;", $username, $password);
        $pdo -> exec("CREATE DATABASE IF NOT EXISTS `$database`");
        $pdo -> exec ("USE $database");

        $pdo -> exec ("CREATE TABLE IF NOT EXISTS admins (
            id INT AUTO_INCREMENT PRIMARY KEY,
            first_name VARCHAR(60) NOT NULL,
            middle_name VARCHAR(60) DEFAULT NULL,
            last_name VARCHAR(60) NOT NULL,
            email VARCHAR(100) NOT NULL UNIQUE,
            password CHAR(60) NOT NULL,
            reg_date DATETIME DEFAULT CURRENT_TIMESTAMP
        )");

        $pdo -> exec ("CREATE TABLE IF NOT EXISTS representatives (
            rep_id INT AUTO_INCREMENT PRIMARY KEY,
            first_name VARCHAR(60) NOT NULL,
            middle_name VARCHAR(60) DEFAULT NULL,
            last_name VARCHAR(60) NOT NULL,
            email VARCHAR(100) NOT NULL UNIQUE,
            username VARCHAR(60) NOT NULL,
            password VARCHAR (100) NOT NULL,
            reg_date DATETIME DEFAULT CURRENT_TIMESTAMP
        )");

        $pdo -> exec ("CREATE TABLE IF NOT EXISTS restaurants (
            rest_id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(100) NOT NULL,
            category ENUM('food', 'drinks', 'grocery', 'other') NOT NULL,
            logo VARCHAR(255),
            cover VARCHAR(255),
            openHrs TIME NOT NULL,
            closeHrs TIME NOT NULL,
            location VARCHAR(255) NOT NULL,
            contact VARCHAR(15) NOT NULL,
            rep_id INT NOT NULL,
            FOREIGN KEY (rep_id) REFERENCES representatives(rep_id)
        )");

        $pdo -> exec ("CREATE TABLE IF NOT EXISTS reg_customers (
            cust_id INT AUTO_INCREMENT PRIMARY KEY,
            first_name VARCHAR(60) NOT NULL,
            middle_name VARCHAR(60) DEFAULT NULL,
            last_name VARCHAR(60) NOT NULL,
            email VARCHAR(100) NOT NULL UNIQUE,
            home_addr VARCHAR(100) NOT NULL,
            office_addr VARCHAR(100) NULL,
            other_addrr VARCHAR(100) NULL,
            username VARCHAR(60) NOT NULL,
            password VARCHAR (100) NOT NULL,
            reg_date DATETIME DEFAULT CURRENT_TIMESTAMP
        )");

        $pdo -> exec ("CREATE TABLE IF NOT EXISTS orders (
            order_id INT AUTO_INCREMENT PRIMARY KEY,
            order_date DATETIME DEFAULT CURRENT_TIMESTAMP,
            cust_id INT NULL,
            guest_id INT NULL,
            guest_name VARCHAR(255) NULL,
            guest_addr VARCHAR(255) NULL,
            payment_type ENUM('PAYPAL', 'MASTERCARD', 'CASH') NOT NULL,
            order_status ENUM('PENDING', 'DELIVERED') NOT NULL,
            FOREIGN KEY (cust_id) REFERENCES reg_customers(cust_id)
        )");

        $pdo -> exec ("CREATE TABLE IF NOT EXISTS order_items (
            order_id INT PRIMARY KEY,
            order_item VARCHAR(255) NOT NULL,
            item_price INT NOT NULL,
            item_quantity INT (3) NOT NULL,
            FOREIGN KEY (order_id) REFERENCES orders(order_id)
        )");

        $pdo -> exec ("CREATE TABLE IF NOT EXISTS payments (
            pay_id INT AUTO_INCREMENT PRIMARY KEY,
            order_id INT NOT NULL,
            pay_status VARCHAR(255) NOT NULL,
            pay_resp TEXT NOT NULL,
            pay_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        )");
        //menus tittles table:
        $pdo -> exec("CREATE TABLE IF NOT EXISTS menu_titles (
            menu_id INT AUTO_INCREMENT PRIMARY KEY,
            rest_id INT NOT NULL,
            menu_title VARCHAR(255) NOT NULL,
            FOREIGN KEY (rest_id) REFERENCES restaurants(rest_id)
         )");

        //menu table template
        // CREATE TABLE IF NOT EXISTS menu_restaurant_menu_title (
        //     entry_id INT AUTO_INCREMENT PRIMARY KEY,
        //     entry_name VARCHAR(255) NOT NULL,
        //     price DECIMAL(10, 2) NOT NULL,
        //     menu_id INT,
        //     FOREIGN KEY (menu_id) REFERENCES menu_titles(menu_id)
        //  );



        $errors = array();
        $first_name = trim($_POST['f-name']);
        if (empty($first_name)) {
            $errors[] = 'first name is required';
        }
        $middle_name = trim($_POST['m-name']);
        $last_name = trim($_POST['l-name']);
        if (empty($last_name)) {
            $errors[] = 'last name is required';
        }
        $email = trim($_POST['email']);
        if (empty($email)) {
            $errors = 'email is required';
        }
        $pass = trim($_POST['pass']);
        $cpass = trim($_POST['cpass']);
        if (!empty($pass) && !empty($cpass)) {
            if ($pass != $cpass) {
                $errors[] = "passwords don't match";
            } else {
                $pwd = password_hash($pass, PASSWORD_BCRYPT);
            }
        } else {
            $errors[] = 'please fill and confirm password';
        }

        if (empty($errors)) {
            $stmt = $pdo -> prepare("INSERT INTO admins (first_name, middle_name, last_name, email, password)
            VALUES (:first_name, :middle_name, :last_name, :email, :password)");
            $stmt -> bindParam(':first_name', $first_name);
            $stmt -> bindParam(':middle_name', $middle_name);
            $stmt -> bindParam(':last_name', $last_name);
            $stmt -> bindParam(':email', $email);
            $stmt -> bindParam(':password', $pwd);
            $stmt -> execute();

            $config = "<?php\n\n";
            $config .= "\$host = '$host';\n";
            $config .= "\$username = '$username';\n";
            $config .= "\$password = '$password';\n";
            $config .= "\$database = '$database';\n";
            $config .= "?>";

            file_put_contents('./config.php', $config);
            header('Location: ./index.php');
        } else {
            echo $errors;
            exit;
        }
    } catch (PDOException $e) {
        echo "<p>Error: ". $e -> getMessage(). "</p>";
    }
}
require_once('./header.php');
?>

    <div class="container">
        <section>
            <div class="install-form">
                <h1>New Host Server Installation</h1>
                <form action="./installation.php" method="post" onsubmit="return validate()">
                    <fieldset>
                        <legend>Database configuration</legend>
                        <div class="form-group">
                            <label>Database Host:</label>
                            <input type="text" class="input" name="host" required>
                        </div>
                        <div class="form-group">
                            <label>Username:</label>
                            <input type="text" class="input" name="username" required>
                        </div>
                        <div class="form-group">
                            <label>Password:</label>
                            <input type="password" class="input" name="password">
                        </div>
                        <div class="form-group">
                            <label>Database Name:</label>
                            <input type="text" class="input" name="database" required>
                    </fieldset>
                    <fieldset>
                        <legend>Master Admin</legend>
                        <div class="form-group">
                            <label for="f-name">First Name</label>
                            <input type="text" name="f-name" id="f-name" required>
                        </div>
                        <div class="form-group">
                            <label for="m-name">Middle name</label>
                            <input type="text" name="m-name" id="m-name">
                        </div>
                        <div class="form-group">
                            <label for="l-name">Last Name</label>
                            <input type="text" name="l-name" id="l-name" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" id="email" required>
                        </div>
                        <div class="form-group">
                            <label for="pass">Password</label>
                            <input type="password" name="pass" id="pass" required>
                        </div>
                        <div class="form-group">
                            <label for="cpass">Confirm Password</label>
                            <input type="password" name="cpass" id="cpass" required>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-submit" value="submit">Install</button>
                        </div>
                    </fieldset>
                </form>
            </div>
        </section>
    </div>
    <script src="./js/index.js"></script>
    <script src="./js/install.js"></script>
</body>
</html>
