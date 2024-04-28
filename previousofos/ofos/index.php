<?php
session_start();
if (!file_exists(('./config.php'))) {
    header('Location: ./installation.php');
    exit;
}

// if ($_SERVER['REQUEST_METHOD'] == 'POST') {
//     require('./login.php');
// }

// $msg = isset($_GET['error']) ? $_GET['error'] : null;
// echo $msg;

//page header
if (isset($_SESSION['user_id'])) {
  echo "<script>alert(\'$_SESSION(['user_id'])\')</script>"; 
}
require_once('./header.php')
?>

            <section>
                <ul class="tab-menu">
                    <li class="active">All</li>
                    <li>Food</li>
                    <li>Drinks</li>
                    <li>Grocery</li>
                    <li>Shopping</li>
                </ul>
                <div class="product-cards"> </div>
            </section>
        </div>
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
                        <input type="text" id="home-address" name="home-address" placeholder="required" />
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
        <!-- <script src="./js/tabbing.js"></script> -->
        <script src="./js/index.js"></script>
        
    </body>
</html>