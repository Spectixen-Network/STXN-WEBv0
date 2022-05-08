<?php
session_start();
include 'funkce.php';
html_start("Home", "css/style");
nav();
?>

<div id="banner" class="container-fluid" style="padding: 0; height: 89vh;">
    <?php svg_image(); ?>
</div>

<script>
    let vyska_prvku = document.getElementById("banner").clientHeight;
    var x = 0;
    window.addEventListener("scroll", (event) => {
        let scroll = this.scrollY;
        let opacity = scroll / vyska_prvku;
        if ((opacity >= 1) && (x == 0)) {
            opacity = 1;
            x = 1;
            document.getElementById("nav-bar").style.backgroundColor = "rgba(0, 0, 0, " + opacity + ")";
        } else {
            document.getElementById("nav-bar").style.backgroundColor = "rgba(0, 0, 0, " + opacity + ")";
        }
    });
</script>

<?php
echo '<div class="container" style="padding-top: 5vh">';
some_text();
echo '</div>';
html_end();
