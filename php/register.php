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
        <!-- Font-->
        <link href="https://fonts.googleapis.com/css?family=Playfair+Display" rel="stylesheet">

    </head>
    <body class="bg-light-blue">
        <?php session_start();?>
        <!-- Navigation -->
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark-blue  sticky-top">
            <div class="container">
                <div class="navbar-header">
                    <button id="nav-toggle-button" class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <a class="navbar-brand text-white ml-5 text-font-Playfair" href="../index.html">Get-Together Bucket List</a>
                </div>
                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <ul class="nav navbar-nav ml-auto">
                        <li class="nav-item active">
                            <a class="nav-link text-white text-font-Playfair" href="../index.html">Home

                            </a>
                        </li>
                        <li class="nav-item">
                            <div class="dropdown">
                                <a class="nav-link text-white dropdown-toggle text-font-Playfair" href="" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">Account</a>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                    <a class="dropdown-item" href="../login.html">Sign In</a>
                                    <a class="dropdown-item" href="register.php">Register<span class="sr-only">(current)</span></a>
                                </div>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white text-font-Playfair" href="../contactUs.html">Contact Us</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <header class="masthead">
            <div class="overlay"></div> 
            <div class="container">
                <!-- Heading Row -->

                <div class="row justify-content-center  text-white">
                    <div class="col-md-10 text-center">
                        <h1 class=" text-font-Playfair">Get-Together Bucket List</h1>
                        <hr class="my-2">
                        <h4 class=" text-font-Playfair">Already a Member?-><a class="text-orange pl-2" href="../login.html">Sign In</a></h4>
                    </div> <!--/.col-lg-10 -->
                </div>


                <div class="row justify-content-center">

                    <div class="col-md-8 bg-dark-blue">
                        <h2 class="text-font-Playfair text-center text-white">Create a new account</h2>
                    </div>
                    <div class="col-md-8 py-3 pb-2 border border-warning bg-light">
                        <form autocomplete="off" action="" method="">
                            <div class="form-row text-font-Playfair">
                                <div class="form-group col-md-6">
                                    <label data-toggle="tooltip" data-placement="top" data-html="true" title="<h6><b>First Name must only be letters without whitespaces.</b></h6>" for="firstName">First Name:</label>
                                    <input type="text" class="form-control" name="registerFirst" placeholder="First name"  required autofocus>

                                </div>
                                <div class="form-group col-md-6">
                                    <label data-toggle="tooltip" data-placement="top" data-html="true" title="<h6><b>Last Name must only be letters without whitespaces.</b></h6>" for="lastName">Last Name:</label>
                                    <input type="text" class="form-control" name="registerLast" placeholder="Last name"  required>
                                </div>

                                <div class="form-group col-md-6">
                                    <label data-toggle="tooltip" data-placement="top" data-html="true" title="<h6><b>Username must not have special characters or whitespaces.</b></h6>" for="registerUserName" >UserName:</label>
                                    <input type="text" class="form-control"  name="registerUserName" placeholder="Unique username"  required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="inputEmail">Email address</label>
                                    <input type="email" class="form-control"  name="registerEmail" placeholder="Email address"  required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label data-toggle="tooltip" data-placement="top" data-html="true" title="<h6><b>Your password must be 8-12 characters long,include at least one number and one letter, and must not contain spaces.</b></h6>"  for="inputPassword" >Password:</label>
                                    <input type="password"  class="form-control" id="myInput" name="registerPassword" placeholder="Password"  required>
                                    <hr class="my-1">
                                    <input type="checkbox" onclick="myFunction()" >  Show Password
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="register">Ready to create an account</label>
                                    <hr class="my-0">
                                    <input name="register" type="text" class="btn btn-block btn-primary" data-toggle="popover" title="Please Go to->Sign In"
                                data-content="Creating a new Account is not possible right now. You need to Sign in as a guest." value="Register">
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-8 bg-dark-blue">
                        <h4 class="text-font-Playfair text-center text-orange mx-2">
                            <?php if( isset($_SESSION['Error']) ){echo $_SESSION['Error']; unset($_SESSION['Error']); }?>
                        </h4>
                        <hr class="my-1">
                        <h4 class="text-font-Playfair text-center text-orange mx-2 ">
                            <?php if(isset($_SESSION['WrongInput']) ){echo $_SESSION['WrongInput']; unset($_SESSION['WrongInput']); }?>
                        </h4>
                    </div>

                </div><!--div class="row justify-content-center"-->
            </div><!--class="container"-->
        </header>


        <!-- Footer -->
        <footer class="footer bg-dark-blue">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 h-100 text-center text-lg-left mr-auto">
                        <ul class="list-inline mb-2">
                            <li class="list-inline-item">
                                <a href="#">About</a>
                            </li>
                            <li class="list-inline-item">&sdot;</li>
                            <li class="list-inline-item">
                                <a href="../contactUs.html">Contact</a>
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
    <script src="../js/popper.min.js"></script>
    <script src="../js/bootstrap.bundle.min.js"></script>

        <!--Code for JavaScript-->
        <script>
            function myFunction() {
                var x = document.getElementById("myInput");
                if (x.type === "password") {
                    x.type = "text";
                } else {
                    x.type = "password";
                }
            }
            $(function () {
                $('[data-toggle="tooltip"]').tooltip()
            })
        </script>
        <script>

        $(function () {
            $('[data-toggle="popover"]').popover()
        })

    </script>
    </body>
</html>