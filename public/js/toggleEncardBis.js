// script.js
const darkModeToggle = document.querySelector('#toggleBtn');
const html = document.documentElement;
const b = document.querySelectorAll("b");
const button = document.querySelectorAll("button");
const cardP = document.querySelectorAll(".card p");
const zoomA = document.querySelectorAll(".zoom a");
const encard = document.querySelector(".encard");
const tda = document.querySelectorAll("td a");
const llabs = document.querySelectorAll(".encard .looksLikeAButtonScarlet");
const table = document.querySelectorAll("table");
const tr = document.querySelectorAll("tr");
const th = document.querySelectorAll("th");
const td = document.querySelectorAll("td");
const thead = document.querySelectorAll("thead");
const boldItalic = document.querySelectorAll(".boldItalicBasic");
const tdBold = document.querySelectorAll("td.boldItalicBasic");
// Function to toggle dark mode
function toggleDarkMode() {
    html.classList.toggle('dark-mode');
    encard.classList.toggle('dark-mode');
    b.forEach(link => {
        link.classList.toggle('dark-mode');
    });
    cardP.forEach(link => {
        link.classList.toggle('dark-mode');
    });
    zoomA.forEach(link => {
        link.classList.toggle('dark-mode');
    });
    tda.forEach(link => {
        link.classList.toggle('dark-mode');
    });
    llabs.forEach(link => {
        link.classList.toggle('dark-mode');
    });
    table.forEach(link => {
        link.classList.toggle('dark-mode');
    });
    boldItalic.forEach(link => {
        link.classList.toggle('dark-mode');
    });
    tr.forEach(link => {
        link.classList.toggle('dark-mode');
    });
    th.forEach(link => {
        link.classList.toggle('dark-mode');
    });
    td.forEach(link => {
        link.classList.toggle('dark-mode');
    });
    thead.forEach(link => {
        link.classList.toggle('dark-mode');
    });
    tdBold.forEach(link => {
        link.classList.toggle('dark-mode');
    });
    button.forEach(link => {
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