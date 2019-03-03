function displayPage() {
    // make current tab go away
    var current = this.parentNode.getAttribute("data-current");  // number
    document.getElementById("tabnav_" + current)
        .setAttribute("style", "background-color: #FDF5E6; color: Darkblue;");
    document.getElementById("tabpage_" + current).style.display = "none";

    // make new tab appear
    var ident = this.id.split("_")[1];  // number
    this.setAttribute("style", "background-color: Darkblue; color: white");
    document.getElementById ("tabpage_" + ident).style.display = "block";
    this.parentNode.setAttribute("data-current", ident);
}