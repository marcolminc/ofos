<?php
if (!file_exists(('./config.php'))) {
    header('Location: ./installation.php');
    exit;
}
include('./header.php');
if (!isset($_GET['restaurant_id'])) {
    header('Location: ./index.php');
    echo '<script>alert(\'hooray\')</script>';
} else {
    require('./functions.php');
    $rest_id = filterInput($_GET['restaurant_id']);
    require('./config.php');
    $pdo = new PDO("mysql:host=$host;dbname=$database", $username, $password);
    $query = $pdo->prepare("SELECT * FROM restaurants WHERE rest_id = :rest_id");
    $query->bindParam(':rest_id', $rest_id);
    $query->execute();
    $profile = $query->fetch(PDO::FETCH_ASSOC);
    ;
    // var_dump($profile);
}



?>
    
    <div class="jumbotron" style="background-image: url('<?php echo $profile['cover'] ?>');">
        <img class="logo" src="<?php echo $profile['logo'] ?>" alt="Restaurant Logo">
        <h1 class="name"><?php echo $profile['name'] ?></h1>
    </div>
    
    <div class="menu-list-container">
        <h2>Menu Lists</h2>
        
        <?php
        // Database connection
        // $pdo = new PDO("mysql:host=localhost;dbname=your_database_name", "username", "password");
        
        // Get restaurant ID from the URL parameter
        $restaurant_id = $_GET['restaurant_id'];
        
        // Retrieve menu lists for the specific restaurant
        // $query = $pdo->prepare("SELECT * FROM restaurant_menu_lists WHERE restaurant_id = :restaurant_id");
        // $query->bindParam(':restaurant_id', $restaurant_id);
        // $query->execute();
        // $menu_lists = $query->fetchAll(PDO::FETCH_ASSOC);
        
        // // Display menu lists
        // if ($menu_lists) {
        //     foreach ($menu_lists as $menu_list) {
        //         echo '<div class="menu-section">';
        //         echo '<h3>'.$menu_list['menu_list_title'].'</h3>';
                
        //         // Retrieve menu items for the current menu list
        //         $query = $pdo->prepare("SELECT * FROM restaurant_menu_items WHERE menu_list_id = :menu_list_id");
        //         $query->bindParam(':menu_list_id', $menu_list['menu_list_id']);
        //         $query->execute();
        //         $menu_items = $query->fetchAll(PDO::FETCH_ASSOC);
                
        //         if ($menu_items) {
        //             echo '<ul>';
                    
        //             foreach ($menu_items as $menu_item) {
        //                 echo '<li class="menu-item">';
        //                 echo $menu_item['menu_item_name'].' - '.$menu_item['menu_item_price'];
        //                 echo '<input type="number" name="quantity" value="1" min="1">';
        //                 echo '</li>';
        //             }
                    
        //             echo '</ul>';
        //         } else {
        //             echo 'No menu items available.';
        //         }
                
        //         echo '</div>';
        //     }
        // } else {
        //     echo 'No menu lists available.';
        // }
        ?>
        
        <!-- <div class="accordion"> -->
  <div class="accordion-item">
    <div class="accordion-header">Accordion <i class="fas fa-chevron-down"></i></div>
    <div class="accordion-content">
      <ul>
        <li><h3>Item 1</h3> <button class="add-to-cart">Add to Cart</button></li>
        <li><h3>Item 2</h3> <button class="add-to-cart">Add to Cart</button></li>
        <li><h3>Item 3</h3> <button class="add-to-cart">Add to Cart</button></li>
        <li><h3>Item 1</h3> <button class="add-to-cart">Add to Cart</button></li>
        <li><h3>Item 2</h3> <button class="add-to-cart">Add to Cart</button></li>
        <li><h3>Item 3</h3> <button class="add-to-cart">Add to Cart</button></li>
        <li><h3>Item 1</h3> <button class="add-to-cart">Add to Cart</button></li>
        <li><h3>Item 2</h3> <button class="add-to-cart">Add to Cart</button></li>
      </ul>
    </div>
  </div>
  <div class="accordion-item">
    <div class="accordion-header">Accordion 2</div>
    <div class="accordion-content">
      <ul>
        <li>Item A <button class="add-to-cart">Add to Cart</button></li>
        <li>Item B <button class="add-to-cart">Add to Cart</button></li>
        <li>Item C <button class="add-to-cart">Add to Cart</button></li>
      </ul>
    </div>
  </div>
  <div class="accordion-item">
    <div class="accordion-header">Accordion 1</div>
    <div class="accordion-content">
      <ul>
        <li>Item 1 <button class="add-to-cart">Add to Cart</button></li>
        <li>Item 2 <button class="add-to-cart">Add to Cart</button></li>
        <li>Item 3 <button class="add-to-cart">Add to Cart</button></li>
      </ul>
    </div>
  </div>
  <div class="accordion-item">
    <div class="accordion-header">Accordion 2</div>
    <div class="accordion-content">
      <ul>
        <li>Item A <button class="add-to-cart">Add to Cart</button></li>
        <li>Item B <button class="add-to-cart">Add to Cart</button></li>
        <li>Item C <button class="add-to-cart">Add to Cart</button></li>
      </ul>
    </div>
  </div>
  <div class="accordion-item">
    <div class="accordion-header">Accordion 1</div>
    <div class="accordion-content">
      <ul>
        <li>Item 1 <button class="add-to-cart">Add to Cart</button></li>
        <li>Item 2 <button class="add-to-cart">Add to Cart</button></li>
        <li>Item 3 <button class="add-to-cart">Add to Cart</button></li>
      </ul>
    </div>
  </div>
  <div class="accordion-item">
    <div class="accordion-header">Accordion 2</div>
    <div class="accordion-content">
      <ul>
        <li>Item A <button class="add-to-cart">Add to Cart</button></li>
        <li>Item B <button class="add-to-cart">Add to Cart</button></li>
        <li>Item C <button class="add-to-cart">Add to Cart</button></li>
      </ul>
    </div>
  </div>
<!-- </div> -->



    </div>
    
    <footer>
        <!-- Add your footer content here -->
    </footer>
    </div>
    <script src="./js/index.js"></script>
    <script src="./js/customerview.js"></script>
</body>
</html>
