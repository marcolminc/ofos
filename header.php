<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>w3</title>
        <link rel="stylesheet" href="./bootstrap5/css/bootstrap.min.css">
        <link rel="stylesheet" href="./bootstrap-icons-1.10.5/font/bootstrap-icons.min.css">
        <link rel="stylesheet" href="./fontawesome/css/all.min.css">
        <link rel="stylesheet" href="./fontawesome/css/fontawesome.min.css">
        <link rel="stylesheet" href="./fontawesome/css/solid.min.css">
        <link rel="stylesheet" href="./css/style.css">
        <script src="./js/cart.js" async></script>
        <script src="./bootstrap5/js/bootstrap.bundle.min.js"></script>
    </head>
    <body>
        <div class="container">
            <header>
                <nav>
                    <div class="logo" onclick="location.href='./index.php'">
                        <h1>INTY</h1>
                    </div>
                    <div class="header-menu-container">
                        <button class="s-n  m-n l xl home-btn" type="button" onclick="location.href='./index.php'">Home</button>
                        <button class="s-n m-n l xl login-btn" type="button" id="login-btn">Login</button>
                        <button class="s-n m-n l xl signup-btn" type="button" id="signup-btn">Signup</button>
                        <button class="s-n m-n l xl more-btn" type="button">More</button>
                        <button class="s-n  m l xl cart-btn text-light" type="button" onclick="openCartModal();"><i class="bi bi-cart text-light"></i></button>
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
                    <li><a onclick="openCartModal();"><i class="bi bi-cart"></i> Cart</a></li>
                    <li><a href="#" id="login-link">Login</a></li>
                    <li><a href="#" id="signup-link">Signup</a></li>
                    <li><a href="./separate_reg_rep.php">Signup as a Business</a></li>
                    <li><a href="#">About</a></li>
                    <li><a href="#">FAQS</a></li>
                    <li><a href="#">Contact</a></li>
                </ul>
                <ul class=" s-n m-n dropdown-list list-group">
                    <li class="list-group-item bg-transparent"><a class="text-decoration-none text-white" href="./separate_reg_rep.php">Signup as a Business</a></li>
                    <li class="list-group-item bg-transparent"><a class="text-decoration-none text-white" href="#">About</a></li>
                    <li class="list-group-item bg-transparent"><a class="text-decoration-none text-white" href="#">FAQS</a></li>
                    <li class="list-group-item bg-transparent"><a class="text-decoration-none text-white" href="#">Contact</a></li>
                  </ul>
            </header>
            <!-- Floating cart button for small devices -->
            <a onclick="openCartModal();" class="floating-cart-btn btn rounded-circle d-sm-none ">
                <i class="bi bi-cart text-light"></i>
            </a>
            <!-- cart modal -->
            <div id="cartModal" class="cart-modal col-11 ">
                <div class="cart-header">
                    <h2>Shopping Cart</h2>
                    <a id="closeCartBtn"><i class="fas fa-times"></i></a>
                </div>
                <div class="cart-body">
                    <ul id="cartItemsList" class="cart-items-list">
                        <!-- Cart entries will be added dynamically here -->

                    </ul>
                    <div class="cart-total text-end text-body-emphasis p-2 m-2"><span>Total: Tsh. </span><span class="total"></span></div>
                    <div class="form-control d-flex align-items-center justify-content-between bg-transparent">
                        <button type="button" id="cart-checkout" class="btn btn-success">Checkout</button>
                        <button type="button" id="cart-continue" class="text-decoration-none "><i class="bi bi-cart-plus text-light"></i></button type=button>
                    </div>
                </div>
            </div>
            <!-- ./cart modal -->
            <!-- overlay -->
            <div id="overlay" class="overlay"></div>
            <!-- ./cart modal -->
<!-- the login module -->
<div class="login-module" id="login-module">
        <div class="module-header">
        <h2>Login</h2>
        <i class="close-icon fas fa-times"></i>
        </div>
              <form id="login-form" method="post">
                  <div class="form-group">
                    <label for="email">Email</label>
                      <input type="email" id="email" name="email" placeholder="Enter your email" />
                      <span class="error" id="email-error"></span>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" placeholder="Enter your password" />
                        <span class="error" id="password-error"></span>
                      </div>
                      <div class="form-actions">
                        <button type="button" id="li-login-btn" value="submit">Login</button>
                        <button type="button" id="li-signup-btn">Sign Up</button>
                      </div>
                      <div class="success-message" id="success-message"></div>
                    </form>
                  </div>
            <!-- customer signup module v2 -->
            <div class="signup-module" id="signup-module">
                  <div class="module-header">
                    <h2>Sign Up</h2>
                    <i class="close-btn fas fa-times"></i>
                  </div>
                  <form id="signup-form">
                    <section id="section-one">
                      <div class="form-group">
                        <label for="first-name">First Name</label>
                        <input type="text" id="first-name" name="first-name" placeholder="John" />
                      </div>
                      <div class="form-group">
                        <label for="middle-name">Middle Name</label>
                        <input type="text" id="middle-name" name="middle-name" placeholder="Hunt" />
                      </div>
                      <div class="form-group">
                        <label for="last-name">Last Name</label>
                        <input type="text" id="last-name" name="last-name" placeholder="Wick" />
                      </div>
                      <div class="form-group">
                        <label for="suemail">Email</label>
                        <input type="email" id="suemail" name="suemail" placeholder="Enter your email" />
                      </div>
                      <div class="form-group">
                        <label for="home-address">Home Address</label>
                        <input type="text" id="home-address" name="home-address" placeholder="optional" />
                      </div>
                      <button type="button" class="next-btn">Next</button>
                    </section>
                    <section id="section-two" style="display: none;"> 
                    <div class="form-group">
                        <label for="office-address">Office Address</label>
                        <input type="text" id="office-address" name="office-address" placeholder="required" />
                      </div>
                      <div class="form-group">
                        <label for="other-address">Other Address</label>
                        <input type="text" id="other-address" name="other-address" placeholder="optional" />
                      </div>
                      <div class="form-group">
                        <label for="suusername">Username</label>
                        <input type="password" id="suusername" name="suusername" />
                      </div>
                      <div class="form-group">
                        <label for="supassword">Password</label>
                        <input type="password" id="supassword" name="supassword" placeholder="Enter your password" />
                      </div>
                      <div class="form-group">
                        <label for="cpassword">Confirm Password</label>
                        <input type="password" id="cpassword" name="cpassword" placeholder="Confirm your password" />
                      </div>
                      <div class="form-actions">
                        <button type="submit" class="submit-btn">Sign Up</button>
                      <button type="button" class="back-btn">Back</button>
                      </div>
                    </section>
                  </form>
                  <div class="success-message" id="signup-success"></div>
                  <div class="error-message" id="signup-error"></div>
                </div>
                  <!-- module overlay -->
                  <div class="module-overlay" id="module-overlay"></div>