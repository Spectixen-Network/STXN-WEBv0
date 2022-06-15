<?php
session_start();
include_once 'functions/globalFunctions.php';
isLoggedElseRedirect();

html_start("Calendar", "css/style");
nav();
banner("Calendar");

?>

<div class="container-fluid">
    <div class="container-fluid">

        <div class="row">
            <div class="col-2" style="background-color: red; height: 70vh;">

            </div>
            <div class="col-10" style="background-color: blue; height: 70vh;">

                <div class="row">
                    <div class="col" style="background-color: green; height: 14vh">
                        <div class="d-flex flex-column">
                            <div class="p-2" style="background-color: purple;">
                                <p style="text-align: center; margin: 0;">1</p>
                            </div>
                            <div class="p-2" style="background-color: black;">
                                <p style="text-align: center;">test<br>test</p>
                            </div>
                        </div>
                    </div>
                    <div class="col" style="background-color: orange; height: 14vh">
                        <div class="d-flex flex-column">
                            <div class="p-2" style="background-color: purple;">
                                <p style="text-align: center; margin: 0;">2</p>
                            </div>
                            <div class="p-2" style="background-color: black;">
                                <p style="text-align: center;">test<br>test</p>
                            </div>
                        </div>
                    </div>

                    <div class="col" style="background-color: green; height: 14vh">
                        <div class="d-flex flex-column">
                            <div class="p-2" style="background-color: purple;">
                                <p style="text-align: center; margin: 0;">3</p>
                            </div>
                            <div class="p-2" style="background-color: black;">
                                <p style="text-align: center;">test<br>test</p>
                            </div>
                        </div>
                    </div>
                    <div class="col" style="background-color: orange; height: 14vh">

                    </div>

                    <div class="col" style="background-color: green; height: 14vh">

                    </div>
                    <div class="col" style="background-color: orange; height: 14vh">

                    </div>
                    <div class="col" style="background-color: green; height: 14vh">

                    </div>
                </div>
                <div class="row">
                    <div class="col" style="background-color: pink; height: 14vh">;

                    </div>
                    <div class="col" style="background-color: yellow; height: 14vh">

                    </div>

                    <div class="col" style="background-color: pink; height: 14vh">

                    </div>
                    <div class="col" style="background-color: yellow; height: 14vh">

                    </div>

                    <div class="col" style="background-color: pink; height: 14vh">

                    </div>
                    <div class="col" style="background-color: yellow; height: 14vh">

                    </div>
                    <div class="col" style="background-color: pink; height: 14vh">

                    </div>
                </div>
                <div class="row">
                    <div class="col" style="background-color: green; height: 14vh">

                    </div>
                    <div class="col" style="background-color: orange; height: 14vh">

                    </div>

                    <div class="col" style="background-color: green; height: 14vh">

                    </div>
                    <div class="col" style="background-color: orange; height: 14vh">

                    </div>

                    <div class="col" style="background-color: green; height: 14vh">

                    </div>
                    <div class="col" style="background-color: orange; height: 14vh">

                    </div>
                    <div class="col" style="background-color: green; height: 14vh">

                    </div>
                </div>
                <div class="row">
                    <div class="col" style="background-color: pink; height: 14vh">

                    </div>
                    <div class="col" style="background-color: yellow; height: 14vh">

                    </div>

                    <div class="col" style="background-color: pink; height: 14vh">

                    </div>
                    <div class="col" style="background-color: yellow; height: 14vh">

                    </div>

                    <div class="col" style="background-color: pink; height: 14vh">

                    </div>
                    <div class="col" style="background-color: yellow; height: 14vh">

                    </div>
                    <div class="col" style="background-color: pink; height: 14vh">

                    </div>
                </div>
                <div class="row">
                    <div class="col" style="background-color: green; height: 14vh">

                    </div>
                    <div class="col" style="background-color: orange; height: 14vh">

                    </div>

                    <div class="col" style="background-color: green; height: 14vh">

                    </div>
                    <div class="col" style="background-color: orange; height: 14vh">

                    </div>

                    <div class="col" style="background-color: green; height: 14vh">

                    </div>
                    <div class="col" style="background-color: orange; height: 14vh">

                    </div>

                    <div class="col" style="background-color: green; height: 14vh">

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
footer();
html_end();