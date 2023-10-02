$(document).ready(function ()
{
    function toggleDisplay()
    {
        $(cardBoard).hide()
    }

    const switchbtn = document.querySelector("#switchBtn")
    const cardBoard = document.querySelector(".cardBoard")
    switchbtn.addEventListener("click", toggleDisplay)
})
