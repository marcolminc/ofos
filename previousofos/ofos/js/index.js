document.addEventListener("DOMContentLoaded", () => {
  loadRestaurantCards('all')
  const menuBtn = document.querySelector('.menu-btn')
  const menuList = document.querySelector('ul.menu');
  menuBtn.addEventListener('click', () => {
    menuBtn.classList.toggle('active')        
    menuList.style.display = menuBtn.classList.contains('active') ? 'block' : 'none';
  })
  //login module functionality variables
  const loginModule = document.querySelector(".login-module");
  const moduleOverlay = document.getElementById('module-overlay')
  const loginLink = document.getElementById("login-link");
  const loginButton = document.getElementById("login-btn")
  const li_signupBtn = loginModule.querySelector('#li-signup-btn');
  const liLoginBtn = loginModule.querySelector('#li-login-btn')
  const liForm = loginModule.querySelector('.login-form')
  //signup functionality variables
const signupModule = document.getElementById('signup-module')
const signupLink = document.getElementById("signup-link")
const signupButton = document.getElementById('signup-btn')
const signupForm = signupModule.querySelector('#signup-form')
const su_SignupBtn = signupModule.querySelector('.submit-btn')
const signupsuccess = signupModule.querySelector('#signup-success')
const signuperr = document.getElementById('#signup-error')

  liLoginBtn.addEventListener('click', (e) => {
    e.preventDefault()
    //AJAX request:
    const xhr = new XMLHttpRequest()
    const liForm = loginModule.querySelector('#login-form')
    const liFormData = new FormData(liForm)
    xhr.open('POST', './login.php', true)
    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest')
    xhr.onreadystatechange = function (e) {
      if (this.readyState == 4 && this.status == 200) {
        var response = JSON.parse(xhr.responseText)
        console.log(response)
        if (response.success) {
                  //redirect or perform any other action
                  if (response.userType === 'rep') {
                    window.location.href = './rep_dashboard.php'
                  } else {
                    loginModule.querySelector('#login-form').style.display = 'none'
                    //show success msg
                    loginModule.querySelector('.success-message').textContent = response.msg
                    loginModule.style.display = 'none'
                    moduleOverlay.style.display = 'none'
                    alert(response.msg + 'user type: ' + response.userType)
                    menuBtn.classList.toggle('active') 
                  }
                } else {
                  // Show error message
                document.getElementById('email-error').textContent = response.msg;
          }                
      }
    }
    // Send form data
    // var data = 'email=' + encodeURIComponent(email) + '&password=' + encodeURIComponent(password);
    xhr.send(liFormData);
  })
  const sectionOne = signupModule.querySelector('#section-one');
  const sectionTwo = signupModule.querySelector('#section-two');
  const nextBtn = signupModule.querySelector('.next-btn');
  const backBtn = signupModule.querySelector('.back-btn')

  let sectionOneData = {}
  const firstName = signupModule.querySelector('#first-name').value;
  const middleName = signupModule.querySelector('#middle-name').value;
  const lastName = signupModule.querySelector('#last-name').value;
  const email = signupModule.querySelector('#suemail').value;
  nextBtn.addEventListener('click', () => {
  // Validate section one inputs
  
  //perform validation
  sectionOneData.firstName = signupModule.querySelector('#first-name').value;
  sectionOneData.middleName = signupModule.querySelector('#middle-name').value;
  sectionOneData.lastName = signupModule.querySelector('#last-name').value;
  sectionOneData.email = signupModule.querySelector('#suemail').value;
  sectionOneData.homeAddress = signupModule.querySelector('#home-address').value
  sectionOne.style.display = 'none'
  sectionTwo.style.display = 'block'
  })
  backBtn.addEventListener('click', (e) => {
    //populate section one's fields with saved prev data
    firstName.value = sectionOneData.firstName 
    middleName.value = sectionOneData.middleName
    lastName.value = sectionOneData.lastName
    email.value = sectionOneData.email
    //show sectio one, hiding section two
    sectionOne.style.display = 'block'
    sectionTwo.style.display = 'none'
  })
  su_SignupBtn.addEventListener('click', (e) => {
    e.preventDefault()
    //get section two's fields and validate
    const officeAddress = document.getElementById('office-address').value;
              const otherAddress = document.getElementById('other-address').value;
              const username = document.getElementById('suusername').value;
              const password = document.getElementById('supassword').value;
              const confirmPassword = document.getElementById('cpassword').value;
    
    //AJAX request:
    const xhr = new XMLHttpRequest()
    const suForm = signupModule.querySelector('#signup-form')
    const suFormData = new FormData(suForm)
    xhr.open('POST', './signup.php', true)
    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest')
    xhr.onreadystatechange = function (e) {
      if (this.readyState == 4 && this.status == 200) {
        var response = JSON.parse(xhr.responseText)
        if (response.success) {
                  //redirect or perform any other action
                  // if (response.userType === 'rep') {
                  //   window.location.href = './rep_dashboard.php'
                  // } else {
                  //   loginModule.querySelector('#login-form').style.display = 'none'
                  //   //show success msg
                  //   loginModule.querySelector('.success-message').textContent = response.msg
                  //   loginModule.style.display = 'none'
                  //   alert(response.msg + 'user type: ' + response.userType)
                  // }
                } else {
                  // Show error message
                // document.getElementById('email-error').textContent = response.msg;
          }                
      }
    }
    // Send form data
    // var data = 'email=' + encodeURIComponent(email) + '&password=' + encodeURIComponent(password);
    xhr.send(suFormData);
  })
  li_signupBtn.addEventListener('click', () => signupModule.style.display= 'block')
  // Add event listener to login link
  loginLink.addEventListener("click", function(event) {
    event.preventDefault();
    moduleOverlay.style.display = 'block'
    loginModule.style.display = "block";
  });
  // Add event listener to signup link
  signupLink.addEventListener("click", function(event) {
    event.preventDefault();
    moduleOverlay.style.display = 'block'
    signupModule.style.display = "block";
  });
  // Add event listener to login button
  loginButton.addEventListener("click", function() {
    moduleOverlay.style.display = 'block'
    loginModule.style.display = "block";
  });
  // Add event listener to signup button
  signupButton.addEventListener("click", function() {
    moduleOverlay.style.display = 'block'
    signupModule.style.display = "block";
  });
// Function to hide the login module
function hideLoginModule() {
  moduleOverlay.style.display = 'none';
  loginModule.style.display = 'none';
}
function hideSignupModule() {
  moduleOverlay.style.display = 'none'
  signupModule.style.display = 'none'
}
// Event listener for close button or outside click to hide the login module
loginModule.querySelector('.close-icon').addEventListener('click', hideLoginModule)
moduleOverlay.addEventListener('click', (e) => {
  if (e.target == moduleOverlay) {
    hideLoginModule()
    hideSignupModule()
  }
})
signupModule.querySelector('.close-btn').addEventListener('click', hideSignupModule)


// further signup module functionality

 // Get the tab menu and items
 const tabMenu = document.querySelector('.tab-menu');
 const tabItems = tabMenu.querySelectorAll('li');

 // Event listener for tab clicks
 tabItems.forEach((item, index) => {
   item.addEventListener('click', () => {
     // Remove active class from all tabs
     tabItems.forEach((item) => item.classList.remove('active'));
     // Add active class to the currently clicked tab
     item.classList.add('active');
     // Get the category from the clicked tab
     const category = item.innerText.toLowerCase();
     // Call the loadRestaurantCards function to change the cards
     loadRestaurantCards(category);
   });
 });


/// ...

tabMenu.addEventListener('touchstart', (e) => {
  touchStartX = e.touches[0].clientX;
});

tabMenu.addEventListener('touchend', (e) => {
  touchEndX = e.changedTouches[0].clientX;

  // Check swipe gesture
  if (touchStartX - touchEndX > 50) {
    // Logic for swipe left
    const activeIndex = Array.from(tabItems).findIndex((item) => item.classList.contains('active'));
    const nextIndex = activeIndex + 1;

    if (nextIndex < tabItems.length) {
      tabItems[activeIndex].classList.remove('active');
      tabItems[nextIndex].classList.add('active');

      // Logic for changing product category
      const category = tabItems[nextIndex].innerText.toLowerCase();
      loadRestaurantCards(category);
    }
  } else if (touchEndX - touchStartX > 50) {
    // Logic for swipe right
    const activeIndex = Array.from(tabItems).findIndex((item) => item.classList.contains('active'));
    const prevIndex = activeIndex - 1;

    if (prevIndex >= 0) {
      tabItems[activeIndex].classList.remove('active');
      tabItems[prevIndex].classList.add('active');

      // Logic to change product category
      const category = tabItems[prevIndex].innerText.toLowerCase();
      loadRestaurantCards(category);
    }
  }

  if (window.innerWidth < 576) {
    const activeTab = tabMenu.querySelector('.active');
    activeTab.scrollIntoView({ behavior: 'smooth', inline: 'center' });
  }
});

// ...


    const moreBtn = document.querySelector('.more-btn')
    const dropList = document.querySelector('.dropdown-list')
    moreBtn.addEventListener('click', () => {
        dropList.classList.toggle('active')
    })

    function loadRestaurantCards(category) {
        var xhr = new XMLHttpRequest();
        xhr.open("GET", "./tabs.php?category=" + category);
        xhr.send();
        xhr.onload = function() {
          var restaurants = JSON.parse(this.responseText);
          var cardsMarkup = '';
          if (restaurants.length === 0) {
            cardsMarkup = 'no entries or invalid category';
          } else {
            for (let i = 0; i < restaurants.length; i++) {
              let restaurant = restaurants[i];
              let cardMarkup = '<div class="card" onclick="location.href=\'customer_view_menu.php?restaurant_id=' + restaurant.rest_id + '\'">' +
                '<img class="cover" src="' + restaurant.cover + '" alt="Cover Image">' +
                '<img class="logo" src="' + restaurant.logo + '" alt="Logo Image">' +
                '<div class="details">' +
                '<h2 class="card-header">' + restaurant.name + '</h2>' +
                '<p class="card-category">' + restaurant.category + '</p>' +
                '<p class="card-time">' + restaurant.openHrs + ' - ' + restaurant.closeHrs + '</p>' +
                '<p class="card-category">' + restaurant.contact + '</p>' +
                '<p class="card-location">' + restaurant.location + '</p>' +
                '</div>' +
                '</div>';

                cardsMarkup += cardMarkup;
            }
          }
          // Append to the container div
          const cardsContainer = document.querySelector('.product-cards');
          cardsContainer.innerHTML = cardsMarkup;
        };
      }
      


    })

