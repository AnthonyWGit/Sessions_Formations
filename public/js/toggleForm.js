// script.js
const darkModeToggle = document.querySelector('#toggleBtn');
const html = document.documentElement;
const b = document.querySelectorAll("b");
const cardP = document.querySelectorAll(".card p");
const zoomA = document.querySelectorAll(".zoom a");
const formInside = document.querySelector(".formInside");
const formRowLabel = document.querySelectorAll(".formRow label");
// Function to toggle dark mode
function toggleDarkMode() {
    html.classList.toggle('dark-mode');
    formInside.classList.toggle('dark-mode');
    b.forEach(link => {
        link.classList.toggle('dark-mode');
    });
    cardP.forEach(link => {
        link.classList.toggle('dark-mode');
    });
    zoomA.forEach(link => {
        link.classList.toggle('dark-mode');
    });
    formRowLabel.forEach(link => {
        link.classList.toggle('dark-mode');
    });
}

// Check for user's preferred mode (light or dark) in local storage
const currentMode = localStorage.getItem('mode');

// Apply the saved mode or default to light mode
if (currentMode === 'dark') {
    toggleDarkMode();
}

// Toggle between light and dark mode when the button is clicked
darkModeToggle.addEventListener('click', () => {
    toggleDarkMode();
    
    // Save the current mode to local storage
    if (html.classList.contains('dark-mode')) 
    {
        localStorage.setItem('mode', 'dark');
    } else 
    {
        localStorage.setItem('mode', 'light');
    }
});