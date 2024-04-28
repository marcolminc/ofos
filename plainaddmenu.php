<?php
session_start();
if (!file_exists('./config.php')) {
    header('Location: ./installation.php');
    exit;
}
if (!isset($_SESSION['rep_id'])) {
    header('Location: ./index.php');
}

require('./header.php');
?>
<div class="add-menu-module d-block" id="add-menu-module">
  <div class="module-header">
    <h4>Add Menu</h4>
    <i class="close-btn fas fa-times"></i>
  </div>
  <form id="menu-add-form" method="post" action="./plainhandler.php">
    <div class="form-group">
      <label for="menu-title">Menu Title</label>
      <input type="text" id="menu-title" name="menu-title" placeholder="Enter menu title" />
    </div>
    <div class="form-group">
      <label for="item1">Item 1</label>
      <input type="text" id="item1" name="item1" placeholder="Enter item name" />
      <input type="number" id="price1" name="price1" placeholder="Enter price" />
    </div>
    <div class="form-group">
      <label for="item2">Item 2</label>
      <input type="text" id="item2" name="item2" placeholder="Enter item name" />
      <input type="number" id="price2" name="price2" placeholder="Enter price" />
    </div>
    <div class="form-group">
      <label for="item3">Item 3</label>
      <input type="text" id="item3" name="item3" placeholder="Enter item name" />
      <input type="number" id="price3" name="price3" placeholder="Enter price" />
    </div>
    <div class="form-actions">
      <!-- <button type="submit" id="add-menu-submit-btn">Submit</button> -->
      <button type="submit" name="add-menu" id="add-menu">Add Menu</button>
    </div>
    <div class="success-message" id="add-menu-success"></div>
    <div class="error-message" id="add-menu-error"></div>
  </form>
</div>