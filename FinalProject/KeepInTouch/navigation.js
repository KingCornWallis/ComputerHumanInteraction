function displayPage() {
    // make current tab go away
    var current = this.parentNode.getAttribute("data-current");  // number
    document.getElementById("tabnav_" + current)
    .setAttribute("style", "background-color: light-gray; color: black;");
    document.getElementById("tabpage_" + current).style.display = "none";
    // make new tab appear
    var ident = this.id.split("_")[1];  // number
    this.setAttribute("style", "background-color: teal; color: white");
    document.getElementById ("tabpage_" + ident).style.display = "block";
    this.parentNode.setAttribute("data-current", ident);
}