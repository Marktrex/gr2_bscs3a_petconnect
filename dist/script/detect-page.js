// Get the current URL
let currentUrl = window.location.href;

// Select all the navbar links
let navbarLinks = document.querySelectorAll('nav a');

// Iterate over each link
navbarLinks.forEach(link => {
    // Compare the href attribute with the current URL
    if (link.href === currentUrl) {
        // If they match, add an attribute 'active' with the value 'true'
        link.setAttribute('active', 'true');
    }
});