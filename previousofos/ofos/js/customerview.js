document.addEventListener('DOMContentLoaded', () => {
    // the accordions for menu lists customer view
    const accordions = document.querySelectorAll('.accordion-item')
    accordions.forEach(function(accordion) {
    const header = accordion.querySelector('.accordion-header')
    const content = accordion.querySelector('.accordion-content')
    const icon = header.querySelector('.fas')
    header.addEventListener('click', () => {
        content.classList.toggle('active')
        icon.classList.toggle('fa-chevron-down');
        icon.classList.toggle('fa-chevron-up');
      })
    })
})