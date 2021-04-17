function searchchange(){
    console.log("Appui détecté");
    let input, filter, ul, li, boite, i, txtValue;
    input = document.getElementById("search");
    filter = input.value.toUpperCase();
    ul = document.getElementById("myUL");
    li = ul.getElementsByTagName("li");
    boite = document.getElementsByClassName("boite");
    for (i = 0; i < li.length; i++) {
        txtValue = li[i].innerText;
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
            boite[i].style.display = "";
        } else {
            boite[i].style.display = "none";
        }
    }
}
