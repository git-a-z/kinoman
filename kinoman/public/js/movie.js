function myFunction() {
    document.getElementById("myDropdown").classList.toggle("show");
}

// Close the dropdown menu if the user clicks outside of it
window.onclick = function(event) {
  if (!event.target.matches('.movie_btn')) {

    let moviebtns = document.getElementsByClassName("movie_drop");
    let i;
    for (i = 0; i < moviebtns.length; i++) {
      let openDropdown = moviebtns[i];
      if (openDropdown.classList.contains('show')) {
        openDropdown.classList.remove('show');
      }
    }
  }
}