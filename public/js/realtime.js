$(document).ready(function () {
    var debounceTimer;

    $('#searchInput').keyup(function () {
        var searchTerm = $(this).val();
        var route = $(this).data('route'); // Get the route path from the data attribute

        // Select the cardBoard and its children
        var cardBoard = $('.cardBoard');

        // Clear the debounce timer if it's already running
        clearTimeout(debounceTimer);

        // Set a new debounce timer to delay the AJAX request
        debounceTimer = setTimeout(function () {
            $.ajax({
                type: 'GET',
                url: route,
                data: { searchTerm: searchTerm },
                success: function (data) {
                    // Clear the card container
                    $('#filteredCards').empty();

                    // Check if searchTerm is empty
                    if (searchTerm == "") {
                        // Show the cardBoard and its children
                        cardBoard.show();
                    } else {
                        // Hide the cardBoard and its children
                        cardBoard.hide();

                        // Access the 'modules' property directly from the response object
                        data.modules.forEach(function (module) {
                            var card = $('<div class="card"></div>');
                            var cardContent = '<p class="center"><b>' + module.nom + '</b></p>' +
                                              '<p><a href="' + module.deleteLink + '" class="looksLikeAButtonScarlet">Supprimer</a></p>' +
                                              '<p>' + module.categorie + '</p>';
                            
                            card.html(cardContent);
                            // Append more module details here if needed
                            $('#filteredCards').append(card);
                        });
                    }
                },
                error: function () {
                    console.error('AJAX request failed.');
                }
            });
        }, 300); // Adjust the debounce time (in milliseconds) as needed
    });
});
