<?php
session_start();
include '../funkce.php';
include  'adminPanelFunctions.php';

html_start("Admin", "../css/style");
nav();

echo
'
        <div class="container-fluid ">
            <div class="container-fluid" id="adminPanelHeader">
                <h1>Users Panel</h1>
            </div>
            <div class="row">';
adminSidebar();
?>
<div class="col-10">
    <div class="row">
        <div class="col-6" style="background-color: red;">
            <span>
                <p>AppleJamp</p>
            </span>
            <span>
                <p>Yura</p>
            </span>
        </div>
        <div class="col-6" style="background-color: blue;">

        </div>
    </div>
</div>
<?php
echo '      </div>
        </div>';

html_end();