let vyska_prvku = document.getElementById('banner').clientHeight;
var x = 0;
window.addEventListener("scroll", () => {
    let scroll = this.scrollY;
    let opacity = scroll / vyska_prvku;
    if ((opacity >= 1) && (x == 0)) {
        opacity = 1;
        x = 1;
        document.getElementById('nav-bar').style.backgroundColor = "rgba(0, 0, 0, " + opacity + ")";
    } else {
        document.getElementById('nav-bar').style.backgroundColor = "rgba(0, 0, 0, " + opacity + ")";
    }
});