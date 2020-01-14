<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Group Project">
        <meta name="author" content="Group Project">
        <title>Get-Together Bucket List</title>
        <link rel="icon" href="../favicon.ico">
        <!-- Bootstrap core CSS -->
        <link href="../css/bootstrap.min.css" rel="stylesheet">
        <!-- My styles for this template -->
        <link href="../mycss/myMapstyle.css" rel="stylesheet">
        <link href="../mycss/mystyle.css" rel="stylesheet">
        <link href="../mycss/mystyleprofile.css" rel="stylesheet">
        <!-- My styles for the table -->
        <link href="../mycss/mystyleTable.css" rel="stylesheet">
        <!-- Font-->
        <link href="https://fonts.googleapis.com/css?family=Playfair+Display" rel="stylesheet">
    </head>

    <body class="bg-light-blue">
        <?php  
        session_start();
        $username = pathinfo(basename($_SERVER['SCRIPT_NAME']), PATHINFO_FILENAME);
        $_SESSION['profile'] = $username;
        ?>
        <!-- Navigation -->
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark-blue  sticky-top">
            <div class="container">
                <div class="navbar-header">
                    <button id="nav-toggle-button" class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <a class="navbar-brand text-white ml-5 text-font-Playfair" href="../member.html">Get-Together Bucket List</a>
                </div>

                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <ul class="nav navbar-nav ml-auto">
                        <li class="nav-item active">
                            <a class="nav-link text-white text-font-Playfair" href="../member.html">Home
                                <span class="sr-only">(current)</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white text-font-Playfair" href="../memberContactUs.html">Contact Us</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <header class="masthead">
            <div class="overlay"></div>
            <div class="container">
                <div class ="row my-4 text-white text-center">
                    <div class="col-xl-10 mx-auto">
                        <h1 class="text-font-Playfair">Profile Information</h1>
                    </div>

                    <div class="col-xl-12 mx-auto text-font-Playfair bg-dark-blue">
                        <h3>Bucket List</h3>
                        <h4 class="text-font-Playfair text-center text-white mx-2 my-1">
                            <?php if( isset($_SESSION['profile']) ){echo "Bucket List Username: ". $_SESSION['profile'];}?>
                        </h4>
                        <buttom type="buttom"  class="btn btn-primary" onclick="showTable()">Print</buttom>
                        <hr class="my-2">
                        <div class="table-wrapper-scroll-y my-custom-scrollbar-activities">
                            <div class="table-responsive-md overflow-y:hidden">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th><h5 class="text-font-Playfair text-orange">Activity</h5></th>
                                            <th><h5 class="text-font-Playfair text-orange">Business Name</h5></th>
                                            <th><h5 class="text-font-Playfair text-orange">Address</h5></th>
                                            <th><h5 class="text-font-Playfair text-orange">Date</h5></th>
                                            <th><h5 class="text-font-Playfair text-orange">Join</h5></th>
                                        </tr>
                                    </thead>
                                    <tbody id="table"></tbody>
                                </table>
                            </div>
                        </div>
                    </div>   
                </div>
            </div>
        </header>

        <!-- Footer -->
        <footer class="footer bg-dark-blue">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 h-100 text-center text-lg-left my-auto">
                        <ul class="list-inline mb-2">
                            <li class="list-inline-item">
                                <a href="#">About</a>
                            </li>
                            <li class="list-inline-item">&sdot;</li>
                            <li class="list-inline-item">
                                <a href="../memberContactUs.html">Contact</a>
                            </li>
                            <li class="list-inline-item">&sdot;</li>
                            <li class="list-inline-item">
                                <a href="#">Terms of Use</a>
                            </li>
                            <li class="list-inline-item">&sdot;</li>
                            <li class="list-inline-item">
                                <a href="#">Privacy Policy</a>
                            </li>
                        </ul>
                        <p class="text-muted small mb-4 mb-lg-0">&copy; Your Website 2019. All Rights Reserved.</p>
                    </div>
                </div>
            </div>
        </footer>

        <!-- Bootstrap core JavaScript -->
        <script src="../js/jquery.min.js"></script>
        <script src="../js/bootstrap.bundle.min.js"></script>
        <script src="../js/jquery-3.3.1.js"></script>

        <!--JavaScript for Profile-->
        <script>
            function showTable() {
                var xhttp;  
                xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        document.getElementById("table").innerHTML = this.responseText;
                    }
                };
                xhttp.open("GET", "../php/printProfile.php", true);
                xhttp.send();
            }
        </script>
    </body>
</html>