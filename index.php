<?php
session_start();
if (!file_exists(('./config.php'))) {
    header('Location: ./installation.php');
    exit;
}

//if (isset($_SESSION['user_id'])) {
//
//}
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
    
        <!-- <script src="./js/tabbing.js"></script> -->
        <script src="./js/index.js"></script>
        
    </body>
</html>