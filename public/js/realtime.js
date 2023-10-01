$(document).ready(function () {
    $('#searchInput').keyup(function () {
        var searchTerm = $(this).val();
        var route = $(this).data('route'); // Get the route path from the data attribute
        $.ajax({
            type: 'GET',
            url: route,
            data: { searchTerm: searchTerm },
            success: function (data) {
                // Clear the card container
                $('#filteredCards').empty();
                
                if (searchTerm == "") {
                    $('#filteredCards').empty();
                }
                else {
                    // Access the 'modules' property directly from the response object
                    console.log(data);
                    data.modules.forEach(function (module) {
                        var card = $('<div class="cardBig"></div>');
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
