<?php
session_start();
include 'funkce.php';

html_start("Founders", "css/style");
nav();

banner("test");

footer();

html_end();

/*
<footer>
    <div class="footer-content">
        <h3>Spectixen Network</h3>
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Minus, repellat? Lorem ipsum dolor sit amet
            consectetur adipisicing elit. Fugit quibusdam minus, nesciunt numquam adipisci praesentium, cupiditate velit
            neque unde fugiat consequatur dolore sunt, magnam exercitationem voluptatum soluta placeat dicta maxime.</p>
        <ul class="footer-links">
            <li><a href="#"><i class="fa fa-github"></i></a></li>
            <li><a href="#"><i class="fa fa-twitter"></i></a></li>
            <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
            <li><a href="#"><i class="fa fa-youtube"></i></a></li>
            <li><a href="#"><i class="fa fa-instagram"></i></a></li>
            <li><a href="#"><i class="fa fa-linkedin-square"></i></a></li>
        </ul>
    </div>
    <div class="footer-bottom">
        <p>Copyright &copy;2022 Spectixen Network. Footer created by <span>Yura</span></p>
    </div>
</footer>
*/