$(document).ready(function () {
    function toggleDisplay() {
        // Toggle between card view and table view
        $(".cardBoard, .tableBoard").toggle();
    }
    const tableBoard = document.querySelector('.tableBoard')
    const cardBoard = document.querySelector('.cardBoard')
    const switchbtn = document.querySelector("#switchBtn");
    switchbtn.addEventListener("click", toggleDisplay);
    $(".tableBoard").toggle();

});
