<!DOCTYPE html>
<html lang="en">

<head>
    <title>STX-1</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <link href="css/style.css" rel="stylesheet">
</head>

<body>
    <div class="container-fluid nav-bar-content">
        <div class="navbar">
            <div class="navbar-brand">
                <a href="#">
                    <img src="images/SpectixenNetwork_logo_bez_pozadi_400x400.png" alt="" class="logo">
                    Spectixen Network
                </a>
            </div>
            <h1>Test</h1>
        </div>
    </div>



    <!--<nav>
        <div class="nav">
            <script>
            myFunction()
            </script>
            <section class="nav-container">
                <aside class="logo" href="index.php">
                    <a id="navlinks" href="index.php"><img src="images/SpectixenNetwork_logo_bez_pozadi_400x400.png">
                        <h1>Spectixen<br>Network</h1>
                    </a>
                </aside>
                <aside class="menu">
                    <div class="menu-content">
                        <aside class="navbarbuttons">
                            <ul>
                                <li><a href="index.php">Home</a></li>
                                <li><a href="about.php">About us</a></li>
                                <li><a href="games.php">Games</a></li>
                                <li><a href="contact.php">Contact</a></li>
                                <li><a href="store.php">Store</a></li>
                            </ul>
                        </aside>
                        <a href="#" id="button-a">Login</a> | <a href="register.php" id="button-b">Register</a>
                        <script>
                        // Get the button, and when the user clicks on it, execute myFunction
                        document.getElementById("button-a").onclick = function() {
                            myFunction()
                        };
                        /* myFunction toggles between adding and removing the show class, which is used to hide and show the dropdown content */
                        function myFunction() {
                            document.getElementById("login-arrow").classList.toggle("show");
                            document.getElementById("login").classList.toggle("show");
                        }
                        </script>
                    </div>
                    <div class="arrow-up" id="login-arrow"></div>
                </aside>
                <div class="login-form" id="login">
                    <div class="form">
                        <h1>Log in</h1>
                        <form method="POST" action="handle.php" class="form_">
                            <input type="hidden" name="form" value="login">
                            <input type="text" name="username" value="" placeholder="Username" required><br>
                            <input type="password" name="password" placeholder="Password" value="" required><br>';
                        </form>
                    </div>
                    <h3><a href="fgpass.php">Forgot password?</a></h3>
                </div>
            </section>
            <div class="navbar-search_mode">
                <form method="GET" action="' . $_SERVER[" SCRIPT_NAME"] . '">
                    <input type="hidden" name="sent" value="1">
                    <input id="search-box" type="search" name="UID" placeholder="Search" autocomplete="off" required>
                    <input id="search-button" type="submit" name="" value="Search">
                </form>
            </div>
            </div>
        </nav>-->


    <?php include 'funkce.php';
    some_text(); ?>
</body>

</html>