import autocomplete from 'autocomplete.js';
import 'autocomplete.js/dist/autocomplete.jquery';

document.addEventListener('DOMContentLoaded', function() {
    const pagination = document.querySelector('.pagination');
    const totalCount = parseInt(pagination.dataset.totalCount);
    const currentPage = parseInt(pagination.dataset.currentPage);

    let HTML = "";

    if (totalCount <= 6) {
        for (let i = 1; i <= totalCount; i++) {
            HTML += addItem(i);
        }
    }
    else {

// Always print first page button
        HTML += addItem("1");

// Print "..." if currentPage is > 3
        if (currentPage > 6) {
            HTML += "...";
        }

// special case where last page is selected...
        if (currentPage === totalCount) {
            HTML += addItem(currentPage - 2);
        }


// Print previous number button if currentPage > 3
        if (currentPage > 2) {
            HTML += addItem(currentPage - 1);
        }

//Print current page number button as long as it not the first or last page
        if (currentPage !== 1 && currentPage !== totalCount) {
            HTML += addItem(currentPage);
        }

//print next number button if currentPage < lastPage - 3
        if (currentPage < totalCount - 1) {
            HTML += addItem(currentPage + 1);
        }

// special case where first page is selected...
        if (currentPage === 1) {
            HTML += addItem(currentPage + 2);
        }


//print "..." if currentPage is < lastPage -2
        if (currentPage < totalCount - 2) {
            HTML += "...";
        }

//Always print last page button if there is more than 1 page
        if (totalCount > 1) {
            HTML += addItem(totalCount);
        }
    }

    pagination.innerHTML = HTML;
});

$('.movie-details').on('click', function() {
    const modalDetails = $('.movie-details-modal');
    const movieDetailsPath = this.dataset.path;
    $.get(movieDetailsPath, function (data) {
        modalDetails.find(".modal-body").html(data);
        modalDetails.show();
    });
});

$('.dismiss-modal').on('click', function() {
    $('.modal').hide();
});

$( "#autocomplete" ).each(function() {
    const autocompleteUrl = this.dataset.autocompleteUrl;
    $(this).autocomplete({hint: false}, [
        {
            source: function(query, response) {
                $.ajax({
                    url: autocompleteUrl+'?query='+query
                }).then(function(data) {
                    data = JSON.parse(data)
                    response(data['results'])
                });
            },
            displayKey: 'title'
        }
    ])
});

function addItem(number) {
    return "<li class=\"page-item\"><a class=\"page-link\" href=\""+ homeRoute+"?page=" + number + "\">"+ number +"</a></li>";
}

