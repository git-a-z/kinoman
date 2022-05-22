if (document.getElementById("myDropdownMenu")) {
    function myFunctionMenu() {
        console.log('clicked');
        document.getElementById("myDropdownMenu").classList.add("show-menu");
    }
}

if (document.getElementById("myDropdown")) {
    function myFunction() {
        document.getElementById("myDropdown").classList.toggle("show");
    }
}

// Close the dropdown menu if the user clicks outside of it
window.onclick = function (event) {
    if (!event.target.matches(".movie_btn")) {
        let moviebtns = document.getElementsByClassName("movie_drop");
        let i;
        for (i = 0; i < moviebtns.length; i++) {
            let openDropdown = moviebtns[i];
            if (openDropdown.classList.contains("show")) {
                openDropdown.classList.remove("show");
            }
        }
    }
};

window.onclick = function (event) {
    if (!event.target.matches(".header_blocks_dropdown")) {
        let loginBtns = document.getElementsByClassName("dropdown_drop_menu");
        let i;
        for (i = 0; i < loginBtns.length; i++) {
            let openDropdownMenu = loginBtns[i];
            if (openDropdownMenu.classList.contains("show-menu")) {
                openDropdownMenu.classList.remove("show-menu");
            }
        }
    }
};

function addDelFilmInList(user_id, film_id, list_id, new_list_id) {
    $.ajax({
        type: "POST",
        url: "/add_del_film_in_list",
        data: {
            user_id: user_id,
            film_id: film_id,
            list_id: list_id,
            new_list_id: new_list_id
        },
        success: function (response) {
            $("#film_lists").html(response);
        }
    });
}

$('#searchForm').on('submit', function (event) {
    event.preventDefault();
    let data = $('#searchForm').serialize();
    $.ajax({
        url: "/filter",
        type: "POST",
        data: data,
        success: function (response) {
            $("#search_results").html(response);
        },
    });
});

function addDelChosen(e) {
    e.preventDefault();
    addDelFilmInFavorites(e, 1);
}

function addDelFavorite(e) {
    e.preventDefault();
    addDelFilmInFavorites(e, 2);
}

function addDelMustSee(e) {
    e.preventDefault();
    addDelFilmInFavorites(e, 3);
}

function addDelFilmInFavorites(e, list_id) {
    let list_id_name = 'add_del_chosen_film_id_';
    let class_name = 'add_del_chosen';

    if (list_id === 2) {
        list_id_name = 'add_del_favorite_film_id_';
        class_name = 'add_del_favorite';
    } else if (list_id === 3) {
        list_id_name = 'add_del_must_see_film_id_';
        class_name = 'add_del_must_see';
    }

    let card = e.path.find(el => el.id && el.id.includes(list_id_name));

    if (card !== undefined) {
        let re = new RegExp(`${list_id_name}`, 'g');
        let film_id = card.id.replace(re, '');
        $.ajax({
            type: "POST",
            url: "/add_del_film_in_favorites",
            data: {
                'film_id': film_id,
                'list_id': list_id,
            },
            success: function (response) {
                let el_id = list_id_name + film_id;
                $('svg.' + class_name).each(function () {
                    if (this.id && this.id === el_id) {
                        $(this).replaceWith(response);
                    }
                });
            }
        });
    }
}
