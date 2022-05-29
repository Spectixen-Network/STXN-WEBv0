<?php
session_start();
include_once 'functions/globalFunctions.php';

isLoggedElseRedirect();
html_start($_SESSION["USERNAME"], "css/style");
nav();

$con = db_connection();
if (is_admin($_SESSION["UID"]) && isset($_GET["uid"]))
{
    $uid = test_input($_GET["uid"]);
}
else
{
    $uid = $_SESSION["UID"];
}

$query = "SELECT * FROM `user` u LEFT JOIN (userinfo ui LEFT JOIN address a USING (address_id)) USING (uid) WHERE u.uid = " . $uid;
$result = mysqli_query($con, $query);
$profileInfo = mysqli_fetch_assoc($result);

?>
<div class="container-fluid">
    <div>
        <div class="col">
            <div class="row justify-content-center"><img id="profile-avatar-img" src="/user/<?php echo $uid . "/" . $profileInfo["image_path"]; ?>" alt="#">
            </div>
        </div>
    </div>
</div>

<?php
banner(username_from_uid($uid));
?>
<div class="container-fluid" id="profile-box">
    <div class="row" id="profile-content-box">
        <div class="col">
            <div class="col" id="profile-content-box-1">
                <div id="profile-basic-info">
                    <h3>Basic Information</h3>
                    <ul>
                        <div class="row">
                            <div class="col-12 col-md-8">
                                <li>Full Name</li>
                            </div>
                            <div class="col-6 col-md-4">
                                <p><?php echo $profileInfo["first_name"] . " " . $profileInfo["last_name"]; ?></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-8">
                                <li>Email Adress</li>
                            </div>
                            <div class="col-6 col-md-4">
                                <p><?php echo $profileInfo["email"]; ?></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-8">
                                <li>Gender</li>
                            </div>
                            <div class="col-6 col-md-4">
                                <p><?php echo $profileInfo["gender"]; ?></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-8">
                                <li>ID</li>
                            </div>
                            <div class="col-6 col-md-4">
                                <p><?php echo $profileInfo["uid"]; ?></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-8">
                                <li>Password</li>
                            </div>
                            <div class="col-6 col-md-4">
                                <p>###TEXT TEMPLATE ###</p>
                            </div>
                        </div>
                    </ul>
                </div>
            </div>
            <div class="col" id="profile-content-box-2">
                <div id="profile-additional-info">
                    <h3>Additional Information</h3>
                    <ul>
                        <div class="row">
                            <div class="col-12 col-md-8">
                                <li>Other Name/Nickname</li>
                            </div>
                            <div class="col-6 col-md-4">
                                <p>###TEXT TEMPLATE ###</p>
                            </div>
                        </div>
                    </ul>
                </div>
            </div>
            <div class="col" id="profile-content-box-3">
                <div id="profile-contact-info">
                    <h3>Contact Information</h3>
                    <ul>
                        <div class="row">
                            <div class="col-12 col-md-8">
                                <li>Mailing Adress</li>
                            </div>
                            <div class="col-6 col-md-4">
                                <p>###TEXT TEMPLATE ###</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-8">
                                <li>Phone Number</li>
                            </div>
                            <div class="col-6 col-md-4">
                                <p>###TEXT TEMPLATE ###</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-8">
                                <li>Fax number? IDK xD</li>
                            </div>
                            <div class="col-6 col-md-4">
                                <p>###TEXT TEMPLATE ###</p>
                            </div>
                        </div>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="col" id="profile-content-box-4">
                <div id="profile-rank">
                    <h3>Rank</h3>
                    <div class="row">
                        <div class="col-12 col-md-8">
                            <li>"MODERATOR"</li>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col" id="profile-content-box-5">
                <div id="profile-age">
                    <h3>### NEVÍM ###</h3>
                    <ul>
                        <div class="row">
                            <div class="col-8 col-md-6">
                                <p></p>
                            </div>
                            <div class="col-6 col-md-4">
                                <li><a href="#">### NEVÍM ###</a></li>
                            </div>
                            <div class="w-100"></div>
                            <div class="col-8 col-md-6">
                                <p></p>
                            </div>
                            <div class="col-6 col-md-4">
                                <li><a href="#">### NEVÍM ###</a></li>
                            </div>
                            <div class="w-100"></div>
                            <div class="col-8 col-md-6">
                                <p></p>
                            </div>
                            <div class="col-6 col-md-4">
                                <li><a href="#">### NEVÍM ###</a></li>
                            </div>
                        </div>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<?php

footer();
html_end();