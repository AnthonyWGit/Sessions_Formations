$(document).ready(function () {
    $('#searchInput').keyup(function () {
        var searchTerm = $(this).val();
        var route = $(this).data('route'); // Get the route path from the data attribute

        // Select the cardBoard and its children
        var cardBoard = $('.cardBoard');

        $.ajax({
            type: 'GET',
            url: route,
            data: { searchTerm: searchTerm },
            success: function (data) {
                // Clear the card container
                $('#filteredCards').empty();

                // Check if searchTerm is empty
                if (searchTerm === "") {
                    // Show the cardBoard and its children
                    cardBoard.show();
                } else {
                    // Hide the cardBoard and its children
                    cardBoard.hide();

                    // Access the 'modules' property directly from the response object
                    console.log(data);
                    data.modules.forEach(function (module) {
                        var card = $('<div class="card"></div>');
                        card.text(module.nom + '|' + module.categorie);
                        console.log(module);
                        // Append more module details here if needed
                        $('#filteredCards').append(card);
                    });
                }
            },
            error: function () {
                console.error('AJAX request failed.');
            }
        });
    });
});
