<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>w3</title>
        <link rel="stylesheet" href="./fontawesome/css/fontawesome.min.css">
        <link rel="stylesheet" href="./fontawesome/css/solid.min.css">
        <link rel="stylesheet" href="./css/style.css">
        <script src="./js/jquery-3.6.3.min.js"></script>
    </head>
    <body>
        <div class="container">
            <header>
                <nav>
                    <div class="logo" onclick="location.href='./index.php'">
                        <h1>INTY</h1>
                    </div>
                    <div class="header-menu-container">
                        <button type="button">Search</button>
                        <button class="s-n  m-n l xl home-btn" type="button" onclick="location.href='./index.php'">Home</button>
                        <button class="s-n m-n l xl login-btn" type="button" id="login-btn">Login</button>
                        <button class="s-n m-n l xl signup-btn" type="button" id="signup-btn">Signup</button>
                        <button class="s-n m-n l xl more-btn" type="button">More</button>
                        <button class="s-n  m l xl cart-btn" type="button">Cart</button>
                        <div class=" l-n xl-n menu-btn-cover">
                            <div class="menu-btn">
                                <span class="bar"></span>
                                <span class="bar"></span>
                                <span class="bar"></span>
                            </div>
                        </div>
                        
                    </div>
                </nav>
                <ul class="menu">
                    <li><a href="./index.php">Home</a></li>
                    <li><a href="#" id="login-link">Login</a></li>
                    <li><a href="#" id="signup-link">Signup</a></li>
                    <li><a href="./separate_reg_rep.php">Signup as a Business</a></li>
                    <li><a href="#">About</a></li>
                    <li><a href="#">FAQS</a></li>
                    <li><a href="#">Contact</a></li>
                </ul>
                <ul class=" s-n m-n dropdown-list">
                    <li><a href="./separate_reg_rep.php">Signup as a Business</a></li>
                    <li><a href="#">About</a></li>
                    <li><a href="#">FAQS</a></li>
                    <li><a href="#">Contact</a></li>
                  </ul>
            </header>