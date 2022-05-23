<?php
session_start();
include 'funkce.php';

html_start("Founders", "css/style");
nav();

banner("Founders of Spectixen Network");
?>
<div class="container-fluid d-flex" style="justify-content: center;">
    <div class="card col-sm-4" style="width:450px; text-align: center;" id="card">
        <div class="d-flex justify-content-center"><img class="card-img-top rounded-circle"
                src="/user/1/images/avatar_red_zoomed.png" style="width:400px; margin-top: 5px;" Card image"></div>
        <div class="card-body">
            <h4 class="card-title text-warning">AppleJamp</h4>
            <p class="card-text text-primary">I’m a Back-End Developer located in Czechia.</p>
            <p class="card-text text-primary">I have a serious passion for Back-End development.</p>
            <p class="card-text text-primary">Fan of games and TV series. Interested in the entire backend spectrum and
                working on ambitious projects.</p>
            <div class="container-fluid d-flex" style="text-align: center; font-size: 3em;"><span class="col-sm-4"><a
                        href="#"><i class="bi bi-discord"></i></a></span><span class="col-sm-4"><a href="#"><i
                            class="bi bi-twitter"></i></a></span><span class="col-sm-4"><a href="#"><i
                            class="bi bi-instagram"></i></a></span></div>
            <div class="card-footer"><a href="#" class="btn btn-primary">See Profile</a></div>
        </div>
    </div>
    <div class="col-sm-4"></div>
    <div class="card col-sm-4" style="width:450px; text-align: center;" id="card">
        <div class="d-flex justify-content-center"><img class="card-img-top rounded-circle d-flex"
                src="/user/2/images/SpectixenNetwork_logo.png" style="width:400px; margin-top: 5px;" Card image"></div>
        <div class="card-body">
            <h4 class="card-title text-warning">Yura</h4>
            <p class="card-text text-primary">I’m a Front-End Developer located in Czechia.</p>
            <p class="card-text text-primary">I have a serious passion for Front-End development.</p>
            <p class="card-text text-primary">Fan of games and TV series. Interested in the entire backend spectrum and
                working on ambitious projects.</p>
            <div class="container-fluid d-flex" style="text-align: center; font-size: 3em;"><span class="col-sm-4"><a
                        href="#"><i class="bi bi-discord"></i></a></span><span class="col-sm-4"><a href="#"><i
                            class="bi bi-twitter"></i></a></span><span class="col-sm-4"><a href="#"><i
                            class="bi bi-instagram"></i></a></span></div>
            <div class="card-footer"><a href="#" class="btn btn-primary">See Profile</a></div>
        </div>
    </div>
</div>
<?php
footer();
html_end();