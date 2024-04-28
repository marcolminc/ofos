<?php
if (!file_exists(('./config.php'))) {
    header('Location: ./installation.php');
    exit;
}
include('./header.php');
if (!isset($_GET['restaurant_id'])) {
    header('Location: ./index.php');
    
} else {
    require('./functions.php');
    $rest_id = filterInput($_GET['restaurant_id']);
    require('./config.php');
    $pdo = new PDO("mysql:host=$host;dbname=$database", $username, $password);
    $query = $pdo->prepare("SELECT * FROM restaurants WHERE rest_id = :rest_id");
    $query->bindParam(':rest_id', $rest_id);
    $query->execute();
    $profile = $query->fetch(PDO::FETCH_ASSOC);
}



?>
    
    <div class="jumbotron" style="background-image: url('<?php echo $profile['cover'] ?>');">
        <img class="logo" src="<?php echo $profile['logo'] ?>" alt="Restaurant Logo">
        <h1 class="name"><?php echo $profile['name'] ?></h1>
    </div>
    
    <div class="container-fluid container-md container-lg bg-light container-xl" id="cust-menu-view">
        <h2 class="display-6 m-2">Menus</h2>
        <div class="row accordion accordion-flush bg-light" id="menus-container">

          </div>
          <!-- ./title_accordions -->
  </div>
  </div>
    <!-- ./container-md main container -->

    <script src="./bootstrap5/js/bootstrap.bundle.js"></script>
    <script src="./js/index.js"></script>
    <script>

        let showCartFlag = true;
        const continueFillingBtn = cartModal.querySelector('#cart-continue')
        continueFillingBtn.addEventListener('click', () => {
            showCartFlag = false
            closeCartModal()
            alert('continue filling cart')
        })
        function addToCart(menuEntry, element) {
            // Store the original content and disable the button
            const originalContent = element.innerHTML;
            element.innerHTML = '<div class="spinner-border spinner-border-sm text-sucess" role="status">' +
                '<span class="visually-hidden">Loading...</span></div>';
            element.disabled = true;
            //show cart

            // Simulate the time-consuming process (you can replace this with actual logic)
            setTimeout(() => {
                let cart = JSON.parse(localStorage.getItem('cart')) || [];
                // Check if the menuEntry already exists in the cart
                const existingItemIndex = cart.findIndex(item => item.entry_id === menuEntry.entry_id && item.entry_name === menuEntry.entry_name);

                if (existingItemIndex !== -1) {
                    // If the menuEntry already exists, increase its quantity by 1
                    cart[existingItemIndex].quantity += 1;
                } else {
                    // If the menuEntry doesn't exist, add it to the cart with quantity 1
                    cart.push({ ...menuEntry, quantity: 1 });

                }

                localStorage.setItem('cart', JSON.stringify(cart))
                // updateCartTotal()

                // Replace the cart icon with the check icon
                element.innerHTML = '<i class="bi bi-check"></i>';

                // Re-enable the button after showing the check icon
                element.disabled = false;

                // Revert back to the cart icon after 2 seconds
                setTimeout(() => {
                    element.innerHTML = originalContent;
                    const FAB = document.querySelector('.floating-cart-btn');
                    FAB.style.display = cart.length > 0 ? 'block' : 'none';
                }, 1000); // Set duration to show the check icon for 2 seconds

                if (showCartFlag) {
                    openCartModal()
                }
            }, 500); // Simulating a 1-second delay, replace this with actual logic
        }

        function afterChange(entry, e) {
            const input = e.target
            if (isNaN(input.value) || input.value <= 0) {
                input.value = 1
            } else if (isNaN(input.value) || input.value >= 10) {
                alert('maximum quantity reached (10)')
                input.value = 10
            }
            const cartItems = JSON.parse(localStorage.getItem('cart') || [])
            // Find the index of the item in the cart with the specified entryId and entryName
            const itemIndex = cartItems.findIndex(item => item.entry_id === entry.entry_id && item.entry_name === entry.entry_name);
            if (itemIndex !== -1) {
                cartItems[itemIndex].quantity = parseInt(input.value)
                // Save the updated cart back to localStorage
                localStorage.setItem('cart', JSON.stringify(cartItems));
                // Update the cart total dynamically
                updateCartTotal()
            }
        }
        //updating cart total
        function updateCartTotal() {
            const totalPlaceHolder = cartModal.querySelector('span.total')
            const cartItems = JSON.parse(localStorage.getItem('cart')) || [];
            totalPlaceHolder.textContent = calculateTotalAmount(cartItems)
        }
        function calculateTotalAmount(cart) {
            let totalAmount = 0;
            cart.forEach(item => {
                totalAmount += item.price * item.quantity;
            });
            return totalAmount;
        }

        function openCartModal() {
            const cartModal = document.getElementById('cartModal')
            const totalPlaceholder = cartModal.querySelector('span.total')
            menuBtn.classList.remove('active')
            menuList.style.display = 'none'
            cartModal.style.display = 'block';
            cartOverlay.style.display = 'block';
            document.body.style.overflow = 'hidden'; // Prevent scrolling on the main content
            //retrieve the cart items from localStorage
            const cartItems = JSON.parse(localStorage.getItem('cart')) || [];
            const FAB = document.querySelector('.floating-cart-btn');
            FAB.style.display = cartItems.length > 0 ? 'block' : 'none';
            const cartItemList = cartModal.querySelector('#cartItemsList')
            cartItemList.innerHTML = ''
            //populate cart item list
            let totalAmount = 0
            cartItems.forEach(function (item) {
                const listItem = document.createElement('li');
                listItem.className = 'cart-item';

                const itemName = document.createElement('span');
                itemName.className = 'lead item-name'
                itemName.textContent = item.entry_name;

                const quantityInput = document.createElement('input');
                quantityInput.type = 'number';
                quantityInput.value = item.quantity || 1; // Use the item's quantity if available, otherwise default to 1
                quantityInput.min = '1';
                quantityInput.max = '10'
                quantityInput.step = '1';
                quantityInput.className = 'form-control cart-quantity-input p-0';
                quantityInput.addEventListener('change', function (e) {
                    afterChange(item,e)
                })
                const itemPrice = document.createElement('span')
                itemPrice.className = 'price'
                itemPrice.textContent = 'Tshs.' + item.price
                const removeLink = document.createElement('a');
                removeLink.href = '#';
                removeLink.innerHTML = '<i class="bi bi-cart-dash text-danger"></i>';
                removeLink.className = 'cart-remove-link'
                removeLink.addEventListener('click', function (event) {
                    event.preventDefault();
                    removeFromCart(item);
                });

                listItem.appendChild(itemName);
                listItem.appendChild(quantityInput);
                listItem.appendChild(itemPrice)
                listItem.appendChild(removeLink);
                cartItemsList.appendChild(listItem);

                // Calculate the total amount incurred
                totalAmount += item.price * (item.quantity || 1);
            });

            // Show the total amount
            totalPlaceholder.textContent = totalAmount

            // Show the cart modal
            cartModal.style.display = 'block';
        }

        document.addEventListener('DOMContentLoaded', () => {
        function createAccordionCustomers(data) {
            const accordion = document.getElementById("menus-container");
            accordion.innerHTML = '';

  for (const menuTitle in data) {
    if (data.hasOwnProperty(menuTitle)) {
        const accordionItem = document.createElement("div");
        accordionItem.className = "accordion-item bg-light mb-1 mt-1 col-12 col-md-6 col-lg-4 ";

        const accordionHeader = document.createElement("h2");
        accordionHeader.className = "accordion-header";
      accordionHeader.id = "heading_" + menuTitle.replace(/\s/g, "_");

        const accordionButton = document.createElement("button");
        accordionButton.className = "accordion-button collapsed";
      accordionButton.type = "button";
      accordionButton.setAttribute("data-bs-toggle", "collapse");
      accordionButton.setAttribute("data-bs-target", "#collapse_" + menuTitle.replace(/\s/g, "_"));
      accordionButton.setAttribute("aria-expanded", "false");
      accordionButton.setAttribute("aria-controls", "collapse_" + menuTitle.replace(/\s/g, "_"));
      accordionButton.textContent = menuTitle;

      accordionHeader.appendChild(accordionButton);
      accordionItem.appendChild(accordionHeader);

        const accordionCollapse = document.createElement("div");
        accordionCollapse.id = "collapse_" + menuTitle.replace(/\s/g, "_");
      accordionCollapse.className = "accordion-collapse collapse";
      accordionCollapse.setAttribute("aria-labelledby", "heading_" + menuTitle.replace(/\s/g, "_"));
      accordionCollapse.setAttribute("data-bs-parent", "#menus-container");

        const accordionBody = document.createElement("div");
        accordionBody.className = "accordion-body";
        const menuEntries = data[menuTitle];
        const menuList = document.createElement("ul");
        menuList.className = 'list-unstyled '
      menuEntries.forEach(function (entry) {
          const listItem = document.createElement("li");
          listItem.className = 'd-flex align-items-center justify-content-between'
        listItem.innerHTML = `
  <p class="lead">${entry['entry_name']}</p>
  <span>Tsh. ${entry['price']}</span>
  <a onclick='addToCart(${JSON.stringify(entry)}, this)' class="text-decoration-none">
    <h5><i class="bi bi-cart-plus text-success"></i></h5>
  </a>
`;

        menuList.appendChild(listItem);
      });

      accordionBody.appendChild(menuList);
      accordionCollapse.appendChild(accordionBody);
      accordionItem.appendChild(accordionCollapse);

      accordion.appendChild(accordionItem);
    }
    }
  }

      showMenusCust()
      function showMenusCust () {
        const xhr = new XMLHttpRequest()
        const url = "./cust_menus.php";
        const data = new URLSearchParams()
        data.append('rest_id', <?php echo $rest_id ?>)
        xhr.open("POST", url, true)
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded")
        xhr.onload = function () {
          if (this.status === 200) {
            const menus = JSON.parse(this.responseText);
            createAccordionCustomers(menus)
          } else {
              console.error('AJAX Error:', this.status, this.statusText);
          }
      }
      xhr.onerror = function () {
        console.error("Network error occurred.");
      }
        xhr.send(data)
      }

      })
    </script>
    <!-- <script src="./js/custom-accordion.js"></script> -->
</body>
</html>
