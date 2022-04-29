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
