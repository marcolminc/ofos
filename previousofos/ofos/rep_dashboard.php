<?php
session_start();
if (!file_exists('./config.php')) {
    header('Location: ./installation.php');
    exit;
}
if (!isset($_SESSION['rep_id'])) {
    header('Location: ./index.php');
}
require('./config.php');
require('./header.php');
?>
<nav>
            <ul class="breadcrumb">
                <li><a href="#">Menus</a></li>
                <li><a href="#">Orders</a></li>
                <li><a href="#">Profile</a></li>
            </ul>
        </nav>
<section>
    <h1><span>Rest name</span>'s menus</h1>
    <!-- Menu Titles -->
    <div class="menu-titles">
                <!-- Menu Title -->
                <div class="menu-title">
                    <h3>Menu Title 1</h3>
                    <a href="#" class="edit-badge">Edit</a>
                </div>
                <!-- Menu Items List -->
                <ul class="menu-items">
                    <li>Menu Item 1</li>
                    <li>Menu Item 2</li>
                    <li>Menu Item 3</li>
                </ul>
            </div>
<!-- Menu Titles -->
<div class="menu-titles">
                <!-- Menu Title -->
                <div class="menu-title">
                    <h3>Menu Title 2</h3>
                    <a href="#" class="edit-badge">Edit</a>
                </div>
                <!-- Menu Items List -->
                <ul class="menu-items">
                    <li>Menu Item 1</li>
                    <li>Menu Item 2</li>
                    <li>Menu Item 3</li>
                </ul>
            </div>

            <!-- Menu Titles -->
            <div class="menu-titles">
                <!-- Menu Title -->
                <div class="menu-title">
                    <h3>Menu Title 1</h3>
                    <a href="#" class="edit-badge">Edit</a>
                </div>
                <!-- Menu Items List -->
                <ul class="menu-items">
                    <li>Menu Item 1</li>
                    <li>Menu Item 2</li>
                    <li>Menu Item 3</li>
                </ul>
            </div>
<!-- Menu Titles -->
<div class="menu-titles">
                <!-- Menu Title -->
                <div class="menu-title">
                    <h3>Menu Title 2</h3>
                    <a href="#" class="edit-badge">Edit</a>
                </div>
                <!-- Menu Items List -->
                <ul class="menu-items">
                    <li>Menu Item 1</li>
                    <li>Menu Item 2</li>
                    <li>Menu Item 3</li>
                </ul>
            </div>

            <!-- Menu Titles -->
            <div class="menu-titles">
                <!-- Menu Title -->
                <div class="menu-title">
                    <h3>Menu Title 1</h3>
                    <a href="#" class="edit-badge">Edit</a>
                </div>
                <!-- Menu Items List -->
                <ul class="menu-items">
                    <li>Menu Item 1</li>
                    <li>Menu Item 2</li>
                    <li>Menu Item 3</li>
                </ul>
            </div>
            <!-- Menu Titles -->
            <div class="menu-titles">
                <!-- Menu Title -->
                <div class="menu-title">
                    <h3>Menu Title 2</h3>
                    <a href="#" class="edit-badge">Edit</a>
                </div>
                <!-- Menu Items List -->
                <ul class="menu-items">
                    <li>Menu Item 1</li>
                    <li>Menu Item 2</li>
                    <li>Menu Item 3</li>
                </ul>
            </div>

            <!-- Menu Titles -->
            <div class="menu-titles">
                <!-- Menu Title -->
                <div class="menu-title">
                    <h3>Menu Title 1</h3>
                    <a href="#" class="edit-badge">Edit</a>
                </div>
                <!-- Menu Items List -->
                <ul class="menu-items">
                    <li>Menu Item 1</li>
                    <li>Menu Item 2</li>
                    <li>Menu Item 3</li>
                </ul>
            </div>
            <!-- Menu Titles -->
            <div class="menu-titles">
                <!-- Menu Title -->
                <div class="menu-title">
                    <h3>Menu Title 2</h3>
                    <a href="#" class="edit-badge">Edit</a>
                </div>
                <!-- Menu Items List -->
                <ul class="menu-items">
                    <li>Menu Item 1</li>
                    <li>Menu Item 2</li>
                    <li>Menu Item 3</li>
                </ul>
            </div>

            <!-- Menu Titles -->
            <div class="menu-titles">
                <!-- Menu Title -->
                <div class="menu-title">
                    <h3>Menu Title 1</h3>
                    <a href="#" class="edit-badge">Edit</a>
                </div>
                <!-- Menu Items List -->
                <ul class="menu-items">
                    <li>Menu Item 1</li>
                    <li>Menu Item 2</li>
                    <li>Menu Item 3</li>
                </ul>
            </div>
</section>
</div>
<!-- add menu module -->
<div class="add-menu-module" id="add-menu-module">
  <div class="module-header">
    <h2>Add Menu</h2>
    <i class="close-btn fas fa-times"></i>
  </div>
  <form id="add-menu-form">
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
    <div class="form-group">
      <label for="item4">Item 4</label>
      <input type="text" id="item4" name="item4" placeholder="Enter item name" />
      <input type="number" id="price4" name="price4" placeholder="Enter price" />
    </div>
    <div class="form-group">
      <label for="item5">Item 5</label>
      <input type="text" id="item5" name="item5" placeholder="Enter item name" />
      <input type="number" id="price5" name="price5" placeholder="Enter price" />
    </div>
    <div class="form-actions">
      <button type="submit" id="add-menu-btn">Add Menu</button>
    </div>
    <div class="success-message" id="add-menu-success"></div>
    <div class="error-message" id="add-menu-error"></div>
  </form>
</div>

<script src="./js/index.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
  const addMenuModule = document.getElementById('add-menu-module');
  const addMenuForm = document.getElementById('add-menu-form');

  // Event listener for closing the module
  const closeBtn = addMenuModule.querySelector('.close-btn');
  closeBtn.addEventListener('click', () => {
    addMenuModule.style.display = 'none';
  });

  // Event listener for submitting the form
  addMenuForm.addEventListener('submit', (e) => {
    e.preventDefault();

    // Retrieve form data
    const formData = new FormData(addMenuForm);

    // Perform AJAX request to add menu
    const xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
      if (xhr.readyState === 4) {
        if (xhr.status === 200) {
          const response = JSON.parse(xhr.responseText);
          if (response.success) {
            // Show success message and reset form
            const successMessage = document.getElementById('add-menu-success');
            successMessage.textContent = response.message;
            addMenuForm.reset();
          } else {
            // Show error message
            const errorMessage = document.getElementById('add-menu-error');
            errorMessage.textContent = response.message;
          }
        } else {
          // Show error message
          const errorMessage = document.getElementById('add-menu-error');
          errorMessage.textContent = 'Error occurred. Please try again later.';
        }
      }
    };

    xhr.open('POST', './add_menu.php');
    xhr.send(formData);
  });
});

</script>
</body>
</html>