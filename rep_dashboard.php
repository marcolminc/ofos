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
    <h2>menus</h2>
    <!-- menu title accordions -->
    <div class="container-fluid container-md container-lg container-xl">
    <button type="button" class="launch-add-menu-btn m-2">Add Menu</button>
    <!-- accordions row -->
    <div class="row accordion accordion-flush" id="menus-container">
      <!-- <div class="accordion accordion-flush d-flex flex-wrap" id="title_accordions">
          
      </div>  -->
    </div>       

</section>
</div>
<!-- add menu module -->
<div class="add-menu-module" id="add-menu-module">
  <div class="module-header">
    <h4>Add Menu</h4>
    <i class="close-btn fas fa-times"></i>
  </div>
  <form id="add-menu-form" method="post">
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
      <button type="button" id="add-menu-btn" value="submit">Add</button>
    </div>
    <div class="success-message" id="add-menu-success"></div>
    <div class="error-message" id="add-menu-error"></div>
  </form>
</div>
<!-- ./add menu module -->
<!-- module overlay -->
<div class="module-overlay" id="module-overlay"></div>
<!-- ./module overlay -->

<script src="./js/index.js"></script>
<script src="./bootstrap5/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
  const addMenuModule = document.getElementById('add-menu-module');
  const addMenuForm = addMenuModule.querySelector('#add-menu-form');
  const overlay = document.querySelector('.module-overlay')
  const launchAddMenuBtn = document.querySelector('.launch-add-menu-btn')
  const addMenuBtn = addMenuModule.querySelector('#add-menu-btn')
  function hideAddMenuModule() {
  overlay.style.display = 'none'
  addMenuModule.style.display = 'none'
}
  launchAddMenuBtn.addEventListener('click', function() {
    overlay.style.display = 'block'
    addMenuModule.style.display = "block";
  });

  // Event listener for close button or outside click to hide the login module
addMenuModule.querySelector('.close-btn').style.cursor="pointer"
addMenuModule.querySelector('.close-btn').addEventListener('click', hideAddMenuModule)
overlay.addEventListener('click', (e) => {
  if (e.target == overlay) {
    hideAddMenuModule()
  }
})

//event listener for the form
addMenuBtn.addEventListener('click', (e) => {
  e.preventDefault()
  //AJAX Request
  const xhr = new XMLHttpRequest()
  const addMenuForm = addMenuModule.querySelector('#add-menu-form');
  const addMenuFormData = new FormData(addMenuForm)
  xhr.open("POST", "./add_menu.php", true)
  xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest')
  xhr.onreadystatechange = function (e) {
    if (this.readyState == 4 && this.status == 200) {
      var response = JSON.parse(xhr.responseText)
      if (response.success) {
        addMenuModule.style.display = 'none'
        overlay.style.display = 'none'
        alert(response.message)
        addMenuForm.reset()
        showMenus('rep')
      } else {
        addMenuModule.querySelector('.error-message').textContent = response.message
        // addMenuForm.reset()
      }
    } 
  }
  //send form data
  xhr.send(addMenuFormData)
})
//function to create accordions:
function createAccordionRep(data) {
  var accordion = document.getElementById("menus-container");
  accordion.innerHTML = ''

  for (var menuTitle in data) {
    if (data.hasOwnProperty(menuTitle)) {
      var accordionItem = document.createElement("div");
      accordionItem.className = "accordion-item col-8 col-md-6 col-lg-4 ";

      var accordionHeader = document.createElement("h2");
      accordionHeader.className = "accordion-header";
      accordionHeader.id = "heading_" + menuTitle.replace(/\s/g, "_");

      var accordionButton = document.createElement("button");
      accordionButton.className = "accordion-button collapsed";
      accordionButton.type = "button";
      accordionButton.setAttribute("data-bs-toggle", "collapse");
      accordionButton.setAttribute("data-bs-target", "#collapse_" + menuTitle.replace(/\s/g, "_"));
      accordionButton.setAttribute("aria-expanded", "false");
      accordionButton.setAttribute("aria-controls", "collapse_" + menuTitle.replace(/\s/g, "_"));
      accordionButton.textContent = menuTitle;

      accordionHeader.appendChild(accordionButton);
      accordionItem.appendChild(accordionHeader);

      var accordionCollapse = document.createElement("div");
      accordionCollapse.id = "collapse_" + menuTitle.replace(/\s/g, "_");
      accordionCollapse.className = "accordion-collapse collapse";
      accordionCollapse.setAttribute("aria-labelledby", "heading_" + menuTitle.replace(/\s/g, "_"));
      accordionCollapse.setAttribute("data-bs-parent", "#menus-container");

      var accordionBody = document.createElement("div");
      accordionBody.className = "accordion-body";
      var menuEntries = data[menuTitle];
      var menuList = document.createElement("ul");
      menuList.className = 'list-unstyled '
      menuEntries.forEach(function (entry) {
        var listItem = document.createElement("li")
        listItem.className = 'd-flex align-items-center justify-content-between'
        listItem.innerHTML = `<p class="lead">${entry['entry_name']}</p><span>Tsh. ${entry['price']}</span>`
        menuList.appendChild(listItem);
      });

      accordionBody.appendChild(menuList);
      accordionCollapse.appendChild(accordionBody);
      accordionItem.appendChild(accordionCollapse);

      accordion.appendChild(accordionItem);
    }
  }
}

showMenus()
function showMenus () {
  const xhr = new XMLHttpRequest()
  const url = "./rep_menus.php";
  const data = new URLSearchParams()
  xhr.open("POST", url, true)
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded")
  xhr.onload = function () {
    if (this.status === 200) {
      const menus = JSON.parse(this.responseText);
      createAccordionRep(menus)
    } else {
        console.error('AJAX Error:', this.status, this.statusText);
    }
}
xhr.onerror = function () {
  console.error("Network error occurred.");
}
  xhr.send(data)
}
 
});

</script>
</body>
</html>