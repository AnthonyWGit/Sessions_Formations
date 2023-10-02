$(document).ready(function ()
{
    function toggleDisplay()
    {
        //First we hide initial display
        $(cardBoard).hide()
        //creating the table 

    }
    
    $(tableBoard).hide()
    
    const switchbtn = document.querySelector("#switchBtn")
    const cardBoard = document.querySelector(".cardBoard")
    const tableBoard = document.querySelector("#tableBoard")
    switchbtn.addEventListener("click", toggleDisplay)
})
