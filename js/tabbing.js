document.addEventListener("DOMContentLoaded", () => { 
    loadRestaurantCards('drinks')
    function loadRestaurantCards(category) {
        var xhr = new XMLHttpRequest()
        xhr.open("GET", "./tabs.php?category=" + category);
        xhr.send();
        xhr.onload = function() {
            restaurants = JSON.parse(this.responseText)
            var cardsMarkup = ''
            for (let i = 0; i < restaurants.length; i++) {
                let restaurant = restaurants[i]
                let cardMarkup = '<div class ="card">' +
                '<img  class = "cover" src="' + restaurant.cover + '" alt="Cover Image">' +
                '<img class="logo" src="' + restaurant.logo + '" alt="Logo Image">' +
                '<div class="details">' +
                '<h2 class="card-header">' + restaurant.name + '</h2>' +
                '<p class="card-category">' + restaurant.category + '</p>' +
                '<p class="card-time">' + restaurant.openHrs + ' - ' + restaurant.closeHrs + '</p>' +
                '<p class="card-category">' + restaurant.contact + '</p>' +
                '<p class="card-location">' + restaurant.location + '</p>' +
                '</div>' +
                '</div>'

                cardsMarkup += cardMarkup
            }

            //append to the container div
            const cardsContainer = document.querySelector('.product-cards')
            cardsContainer.innerHTML = (cardsMarkup.length == 0) ? 'no entries or invalid category' : cardsMarkup
        }

    }
})









// document.addEventListener("DOMContentLoaded", (e) => {
//     // Function to fetch restaurant data from the server using AJAX
// function fetchRestaurants(category, callback) {
//     $.ajax({
//       url: '../../tabs.php',
//       type: 'GET',
//       data: { category: category },
//       dataType: 'json',
//       success: function(response) {
//         callback(response);
//       },
//       error: function(error) {
//         console.log('Error fetching restaurants:', error);
//       }
//     });
//   }
  
//   // Function to filter restaurants based on category
//   function filterRestaurants(category) {
//     const restaurantList = $('#product-cards');
//     restaurantList.empty();
  
//     fetchRestaurants(category, function(restaurants) {
//       restaurants.forEach(function(restaurant) {
//         const card = `
//           <div class="card">
//             <img src="images/${restaurant.coverImage}" alt="Cover Image">
//             <img class="logo" src="images/${restaurant.logoImage}" alt="Logo Image">
//             <div class="details">
//               <h2>${restaurant.name}</h2>
//               <p>Opening Hours: ${restaurant.openingHours} - ${restaurant.closingHours}</p>
//               <p>Category: ${restaurant.category}</p>
//             </div>
//           </div>
//         `;
//         restaurantList.append(card);
//       });
//     });
  
//     // Update the active tab
//     $('.tab').removeClass('active');
//     $(`.tab[data-category="${category}"]`).addClass('active');
//   }
  
//   // Initial load with all restaurants
//   filterRestaurants('all');
  
// })













//     // //jquery way
//     // $(document).ready(() => {
//     //     //load initial data
//     //     loadCards('all')

//     //     //tab click event
//     //     $('.category-tabs a').click((e)=> {
//     //         e.preventDefault()
//     //         $('.category-tabs li').removeClass('active')
//     //         $(this).parent().addClass('active')
//     //         let category = $(this).data('category')
//     //         loadCards(category)
//     //     })


//     //     //loading cards using AJAX (Jquery way)
//     //     function loadCards(cat) { 
//     //         $.ajax({
//     //             url: '../../tabs.php',
//     //             type: 'GET',
//     //             data: {category: cat},
//     //             success: (response) => {
//     //                $('#product-cards').html(response) 
//     //             },
//     //             error: (xhr, status, error) => {
//     //                 console.log(xhr.responseText)
//     //             }
//     //         })
//     //     }

//     // })




// // document.addEventListener('DOMContentLoaded', function() {
// //     var categoryTabs = document.querySelectorAll('.category-tabs a');
    
// //     // Load initial data
// //     loadRestaurantCards('all');
    
// //     // Tab click event
// //     categoryTabs.forEach(function(tab) {
// //       tab.addEventListener('click', function(e) {
// //         e.preventDefault();
// //         categoryTabs.forEach(function(tab) {
// //           tab.parentElement.classList.remove('active');
// //         });
// //         this.parentElement.classList.add('active');
// //         var category = this.getAttribute('data-category');
// //         loadRestaurantCards(category);
// //       });
// //     });
    
// //     // Load restaurant cards
// //     function loadRestaurantCards(category) {
// //       var xhr = new XMLHttpRequest();
// //       xhr.onreadystatechange = function() {
// //         if (xhr.readyState === 4 && xhr.status === 200) {
// //           document.getElementById('restaurant-cards').innerHTML = xhr.responseText;
// //         }
// //       };
// //       xhr.open('POST', '../../tabs.php', true);
// //       xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
// //       xhr.send('category=' + category);
// //     }
// //   });
  
