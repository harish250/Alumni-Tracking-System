<?php
session_start();

$type = isset($_SESSION['type']) ? $_SESSION['type']: 1;
$logged_in = (isset($_SESSION['id']) & $type == 0)?1:0;
$username =  ($logged_in)?$_SESSION['username']:'';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0,user-scalable=no">

    <title>Home</title>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css"
        integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous" />

    <link
        href="https://fonts.googleapis.com/css?family=IBM+Plex+Sans:700i|Montserrat|Roboto|Raleway|Poppins:wght@600&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css"
        integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
</head>

<body onload=<?php echo "setup('load',$logged_in)"?>>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    </script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    <nav class="navbar fixed-top navbar-expand-sm navbar-light bg-light">

        <a href="index.php" class="logo mr-4">
            <span class="logo-section mr-3">
                <img src="img/download-removebg-preview.png" alt="" />
            </span>
            <span class="navbar-brand">Alumni Tracking System</span>
        </a>
        <button class="navbar-toggler" data-toggle="collapse" data-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item mr-2">
                    <a class="nav-link active" href="index.php">Home</a>
                </li>
                <li class="nav-item mr-2">
                    <a class="nav-link" href="#aboutus-section">About</a>
                </li>
                <li class="nav-item mr-2">
                    <div class="dropdown">
                        <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            Services
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="#myloginmodal" data-toggle="modal"
                                id="gallerylink">Gallery</a>
                            <a class="dropdown-item" href="#myloginmodal" data-toggle="modal" id="postinglink">Job
                                Posting</a>
                            <a class="dropdown-item" href="#myloginmodal" data-toggle="modal" id="eventslink">Events</a>
                            <a class="dropdown-item" href="#myloginmodal" data-toggle="modal" id="groupchatlink">Group
                                Chat</a>

                        </div>
                    </div>

                </li>
                <li class="nav-item mr-2">
                    <a class="nav-link" href="#contact-us">Contact</a>
                </li>
            </ul>

            <div class="btn-group">
                <button class="btn btn-lg btn-outline-dark mr-4" type="button" data-toggle="modal"
                    data-target="#myloginmodal" id="loginButton">Login</button>
                <button class="btn btn-lg btn-outline-dark mr-4" data-toggle="modal" data-target="#mysignupmodal"
                    type="button" id="signUp">Sign Up</button>

            </div>

            <span class="navbar-text mr-2" id="loggedInAs">
                      
            </span>

            <a href="../signout.php" class="btn btn-lg btn-outline-dark mr-2 text-decoration-none d-none"
                id="signoutButton">Sign Out</a>

            <a data-toggle="modal" data-target="#editProfile">
                <span class="fas fa-user-circle fa-3x"></span>
            </a>


        </div>
    </nav>

    <!-- Modal for alerting to login  5...no use -->
    <div class="modal" id="alertLoginModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title w-100 text-center">Acknowledgment</h5>
                    <button class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <h5 class="display-5 text-center text-danger">Invalid username/password</h5>
                </div>
            </div>
        </div>
    </div>
    <!-- modal for login-->
    <div class="modal" id="myloginmodal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title w-100 text-center">Login</h5>
                    <button class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                
                    <form>
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" class="form-control" name="username" placeholder="Email Id/Roll No"
                                id="login_username"/>
                                <span class="valid-feedback text-success">
                                 <i class="far fa-check-circle" aria-hidden="true"></i> 
                                </span>
                                <span class="invalid-feedback text-danger">
                                 <i class="far fa-times-circle" aria-hidden="true"></i>
                                </span>
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" name="password" placeholder="Password"
                                id="login_password" />
                            
                                <span class="valid-feedback text-success">
                                 <i class="far fa-check-circle" aria-hidden="true"></i> 
                                </span>
                                <span class="invalid-feedback text-danger">
                                 <i class="far fa-times-circle" aria-hidden="true"></i>
                                </span>
                            <small id="text-prompt" class="form-text text-danger"></small>
                        </div>
                        <div class="form-group text-center">
                            <input type="button" value="Login" class="btn btn-lg btn-secondary" id="submitButton"
                                onclick="setup('login')">
                        </div>
                    </form>

                </div>


            </div>
        </div>
    </div>

    <!-- modal for signup -->
    <div class="modal" id="mysignupmodal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title w-100 text-center ">Signup</h5>
                    <button class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form id="submitform">
                        <div class="form-group row p-3">
                            <label for="fullname" >Name</label>
                            <input type="text" class="form-control  mb-3" name="fullname" id="fullname"
                                placeholder="Full Name" required>
                                <span class="text-success d-none" id="fullname-valid">
                                <i class="far fa-check-circle"></i>
                                </span>
                                <span class="text-danger d-none" id="fullname-invalid">
                                <i class="far fa-times-circle"></i>
                                </span>
                            <label for="email" >Email</label>
                            <input type="email" class="form-control mb-3" name="email" placeholder="Enter your Email Id"
                                id="email" required/>
                                <span class="text-success d-none" id="email-valid">
                                <i class="far fa-check-circle"></i>
                                </span>
                                <span class="text-danger d-none" id="email-invalid">
                                <i class="far fa-times-circle"></i>
                                </span>
                            <label for="password" >Password</label>
                            <input type="password" class="form-control  mb-3" name="password" placeholder="Password"
                                id="password" required>
                                <span class="text-success d-none"id="password-valid">
                                <i class="far fa-check-circle"></i>
                                </span>
                                <span class="text-danger d-none" id="password-invalid">
                                <i class="far fa-times-circle"></i>
                                </span>
                            <label for="repassword" >Re-Password</label>
                            <input type="password" class="form-control mb-3" name="repassword"
                                placeholder="Re Enter Password" id="repassword" required/>
                                <span class="text-success d-none" id="repassword-valid">
                                <i class="far fa-check-circle"></i>
                                </span>
                                <span class="text-danger d-none" id="repassword-invalid">
                                <i class="far fa-times-circle"></i>
                                </span>
                            <label for="company"  >Company</label>
                            <input type="text" class="form-control  mb-3" name="company" id="company" placeholder="Company" required>
                            <span class="text-success d-none" id="company-valid">
                                <i class="far fa-check-circle"></i>
                                </span>
                                <span class="text-danger d-none" id="company-invalid">
                                <i class="far fa-times-circle"></i>
                                </span>
                            <label for="designation">Designation</label>
                            <input type="text" id="designation" name="designation"placeholder="Designation" class="form-control  mb-3" required>
                            <span class="text-success d-none" id="designation-valid">
                                <i class="far fa-check-circle"></i>
                                </span>
                                <span class="text-danger d-none" class="designation-invalid">
                                <i class="far fa-times-circle"></i>
                                </span>
                            <label for="address">
                                Address
                            </label>
                            <input type="text" class="form-control mb-3" name="address" id="address"
                                placeholder=" Residential Address" required>
                                <span class="text-success d-none" id="address-valid">
                                <i class="far fa-check-circle"></i>
                                </span>
                                <span class="text-danger d-none" id="address-invalid">
                                <i class="far fa-times-circle"></i>
                                </span>
                            <label for="rollno" >Roll No</label>
                            <input type="text" class="form-control  mb-3" name="rollno" id="rollno"
                                placeholder="Enter Your College ID" required>
                                <span class="text-success d-none" id="rollno-valid">
                                <i class="far fa-check-circle"></i>
                                </span>
                                <span class="text-danger d-none" id="rollno-invalid">
                                <i class="far fa-times-circle"></i>
                                </span>
                             <label for="branch" >Branch</label>
                             <input type="text" id="branch" name="branch" class="form-control mb-3" placeholder="Branch" required>
                             <span class="text-success d-none" id="branch-valid">
                                <i class="far fa-check-circle"></i>
                                </span>
                                <span class="text-danger d-none" id="branch-invalid">
                                <i class="far fa-times-circle"></i>
                                </span>
                        
                            <label for="phno" >Phone Number</label>
                            <input type="text" name="phno" id="phno" class="form-control mb-3" placeholder="Phone Number" required>
                            <span class="text-success d-none" id="phno-valid">
                                <i class="far fa-check-circle"></i>
                                </span>
                                <span class="text-danger d-none" id="phno-invalid">
                                <i class="far fa-times-circle"></i>
                                </span>
                            <label for="yearofgraduation" >Year Of Graduation</label>
                            <input type="text" class="form-control mb-4 mb-3" name="yearofgraduation" id="yearofgraduation"
                                placeholder="Year Of Graduation yyyy-mm-dd" required>
                                <span class="text-success d-none" id="yearofgraduation-valid">
                                <i class="far fa-check-circle"></i>
                                </span>
                                <span class="text-danger d-none" id="yearofgraduation-invalid">
                                <i class="far fa-times-circle"></i>
                                </span>
                            <div class="form-group mx-auto">
                                <input type="button" value="Submit" class="btn btn-lg btn-secondary" onclick="setup('signup')">
                            </div>
                           
                        </div>
                    </form>
                    <h4 id="text-prompt-signup" class=" text-center text-danger"></h4>
                </div>

            </div>
        </div>
    </div>

    <!--Edit Profile -->
    <div class="modal" id="editProfile">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title w-100 text-center">Edit Profile</h5>
                    <button class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label for="fullname">Name</label>
                            <input type="text" class="form-control" name="fullname" id="fullname"
                                placeholder="Full Name">

                            <label for="email">Email</label>
                            <input type="email" class="form-control" name="email" placeholder="Enter your Email Id"
                                id="email">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" name="password" placeholder="Password"
                                id="password">

                            <label for="password">Re-Password</label>
                            <input type="password" class="form-control" name="repassword"
                                placeholder="Re Enter Password" id="repassword">

                            <label for="company">Company</label>
                            <input type="text" class="form-control" name="company" id="company" placeholder="Company">

                            <label for="address">
                                Address
                            </label>
                            <input type="text" class="form-control" name="address" id="address"
                                placeholder=" Residential Address">

                            <label for="rollno">Roll No</label>
                            <input type="text" class="form-control" name="rollno" id="rollno"
                                placeholder="Enter Your College ID">

                            <label for="branch">Branch</label>
                            <div class="dropdown mb-2">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Branch
                                    <span class="caret"></span>
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item" href="#" name="cse" id="cse" data-value="CSE">CSE</a>
                                    <a class="dropdown-item" href="#" name="eie" id="eie" data-value="EIE">EIE</a>
                                    <a class="dropdown-item" href="#" name="it" id="it" data-value="IT">IT</a>
                                    <a class="dropdown-item" href="#" name="ece" id="ece" data-value="ECE">ECE</a>
                                </div>
                            </div>

                            <label for="yearofgraduation">Year Of Graduation</label>
                            <input type="date" class="form-control mb-4" name="yearofgraduation" id="yearofgraduation"
                                placeholder="Year Of Graduation">
                            <div class="form-group text-center">
                                <input type="submit" value="Edit" class="btn btn-lg btn-secondary">
                            </div>


                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>


    <!-- Main Content Section -->
    <section id="main-content" class="img-fluid p-5 mb-3">
        <div class="dark-overlay">
            <div class="row">
                <div class="col">
                    <div class="container align-center" style="padding-top: 250px;">
                        <blockquote class="blockquote text-center">
                            <p class="mb-0">I think the success of any college can be measured by the contribution the
                                alumni make to our national life </p>
                            <footer class="blockquote-footer"><cite title="Source Title">John F. Kennedy</cite></footer>
                        </blockquote>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About us section -->
    <section id="aboutus-section" class="bg-light">

        <div class="container">
            <h1 class="text-center mb-5">About Us</h1>
            <div class="row">
                <div class="col-md-4 text-center" data-aos="fade-up-right" data-aos-duration="1000">
                <i class="fas fa-3x fa-user-plus"></i>
                    <p>Register</p>
                </div>
                <div class="col-md-4 text-center" data-aos="flip-left" data-aos-duration="2000">
                    <i class="fas fa-3x fa-sign-in-alt"></i>
                    <p>Login</p>
                </div>
                <div class="col-md-4 text-center" data-aos="fade-up-left" data-aos-duration="1000">
                   <i class="fas fa-3x fa-handshake"></i>
                    <p>Network</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section id="service-section">
        <div id="carouselExampleIndicators" class="carousel slide d-none" data-ride="carousel">

            <div class="carousel-inner">
                <!-- <div class="carousel-item active">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="card text-center">
                                    <div class="card-header">Alumni 1</div>

                                    <div class="card-body">
                                        <h2><i class="fas fa-user fa-2x"></i></h2>
                                        <h3 class="card-title">Susan Doe</h3>
                                        <p class="card-text lead">Lorem ipsum dolor sit amet, consectetur adipisicing
                                            elit. Eius, repellendus?</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card text-center">
                                    <div class="card-header">Alumni 1</div>

                                    <div class="card-body">
                                        <h2><i class="fas fa-user fa-2x"></i></h2>
                                        <h3 class="card-title ">Susan Doe</h3>
                                        <p class="card-text lead">Lorem ipsum dolor sit amet, consectetur adipisicing
                                            elit. Eius, repellendus?</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card text-center">
                                    <div class="card-header">Alumni 1</div>

                                    <div class="card-body">
                                        <h2><i class="fas fa-user fa-2x"></i></h2>
                                        <h3 class="card-title ">Susan Doe</h3>
                                        <p class="card-text lead">Lorem ipsum dolor sit amet, consectetur adipisicing
                                            elit. Eius, repellendus?</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="card text-center">
                                    <div class="card-header">Alumni 1</div>

                                    <div class="card-body">
                                        <h2><i class="fas fa-user fa-2x"></i></h2>
                                        <h3 class="card-title">Susan Doe</h3>
                                        <p class="card-text lead">Lorem ipsum dolor sit amet, consectetur adipisicing
                                            elit. Eius, repellendus?</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="card text-center">
                                    <div class="card-header">Alumni 1</div>

                                    <div class="card-body">
                                        <h2><i class="fas fa-user fa-2x"></i></h2>
                                        <h3 class="card-title">Susan Doe</h3>
                                        <p class="card-text lead">Lorem ipsum dolor sit amet, consectetur adipisicing
                                            elit. Eius, repellendus?</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card text-center">
                                    <div class="card-header">Alumni 1</div>

                                    <div class="card-body">
                                        <h2><i class="fas fa-user fa-2x"></i></h2>
                                        <h3 class="card-title">Susan Doe</h3>
                                        <p class="card-text lead">Lorem ipsum dolor sit amet, consectetur adipisicing
                                            elit. Eius, repellendus?</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card text-center">
                                    <div class="card-header">Alumni 1</div>

                                    <div class="card-body">
                                        <h2><i class="fas fa-user fa-2x"></i></h2>
                                        <h3 class="card-title">Susan Doe</h3>
                                        <p class="card-text lead">Lorem ipsum dolor sit amet, consectetur adipisicing
                                            elit. Eius, repellendus?</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="card text-center">
                                    <div class="card-header">Alumni 1</div>

                                    <div class="card-body">
                                        <h2><i class="fas fa-user fa-2x"></i></h2>
                                        <h3 class="card-title">Susan Doe</h3>
                                        <p class="card-text lead">Lorem ipsum dolor sit amet, consectetur adipisicing
                                            elit. Eius, repellendus?</p>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="card text-center">
                                    <div class="card-header">Alumni 1</div>

                                    <div class="card-body">
                                        <h2><i class="fas fa-user fa-2x"></i></h2>
                                        <h3 class="card-title">Susan Doe</h3>
                                        <p class="card-text lead">Lorem ipsum dolor sit amet, consectetur adipisicing
                                            elit. Eius, repellendus?</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card text-center">
                                    <div class="card-header">Alumni 1</div>

                                    <div class="card-body">
                                        <h2><i class="fas fa-user fa-2x"></i></h2>
                                        <h3 class="card-title">Susan Doe</h3>
                                        <p class="card-text lead">Lorem ipsum dolor sit amet, consectetur adipisicing
                                            elit. Eius, repellendus?</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card text-center">
                                    <div class="card-header">Alumni 1</div>

                                    <div class="card-body">
                                        <h2><i class="fas fa-user fa-2x"></i></h2>
                                        <h3 class="card-title">Susan Doe</h3>
                                        <p class="card-text lead">Lorem ipsum dolor sit amet, consectetur adipisicing
                                            elit. Eius, repellendus?</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="card text-center">
                                    <div class="card-header">Alumni 1</div>

                                    <div class="card-body">
                                        <h2><i class="fas fa-user fa-2x"></i></h2>
                                        <h3 class="card-title">Susan Doe</h3>
                                        <p class="card-text lead">Lorem ipsum dolor sit amet, consectetur adipisicing
                                            elit. Eius, repellendus?</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> -->
            </div>
            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
        <input type="hidden" id="session" value="<?php echo $username?>" class="d-none">
        <button type="button" hidden id="adminpagebtn" onclick="window.location = '../Admin/index.php'"></button>

    </section>

    <!-- Footer Section or Contact us  -->
    <!-- Footer -->
    <footer class="page-footer font-small stylish-color-dark pt-2 bg-dark" id="contact-us">
        <!-- Footer Links -->
        <div class="container text-center text-md-left">
            <!-- Grid row -->
            <div class="row">
                <!-- Grid column -->
                <div class="col-md-4 mx-auto">
                    <!-- Content -->
                    <h5 class="mb-4 pt-2" id="footer-head">Contact us </h5>
                    <p id="footer-head-content">Alumni Tracking System Provides you with unlimited connection with your
                        Colleges </p>
                </div>
                <!-- Grid column -->
                <hr class="clearfix w-100 d-md-none">
                <!-- Grid column -->
                <div class="col-md-2 mx-auto">
                    <!-- Links -->
                    <h5 class="font-weight-bold text-uppercase mb-4 text-white">Contact</h5>
                    <ul class="list-unstyled" id="contacts">
                        <li class="mb-3">
                            <a href="#!" style="text-decoration: none;font-weight: 500 ;">Hyderabad +91-9909893199</a>
                        </li>
                    </ul>
                </div>
                <!-- Grid column -->
                <hr class="clearfix w-100 d-md-none">
                <!-- Grid column -->
                <div class="col-md-2 mx-auto" id="quick-links">
                    <!-- Links -->
                    <h5 class="font-weight-bold text-uppercase mb-4 text-white">Quick Links</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <a href="#gallery" style="text-decoration: none;">Gallery</a>
                        </li>
                        <li class="mb-2">
                            <a href="#!" style="text-decoration: none;">Job Posting</a>
                        </li>
                        <li class="mb-2">
                            <a href="#!" style="text-decoration: none;">Events</a>
                        </li>
                        <li class="mb-2">
                            <a href="#!" style="text-decoration:none;">Group Chat</a>
                        </li>
                    </ul>
                </div>
                <!-- Grid column -->
            </div>
            <!-- Grid row -->
        </div>
        <!-- Footer Links -->
     
        <!-- Social buttons -->
        <ul class="list-unstyled list-inline text-center mb-0">
            <li class="list-inline-item">
                <a href="#" class="fab fa-facebook fa-1x" style="text-decoration: none;"></a>
            </li>
            <li class="list-inline-item">
                <a href="#" class="fab fa-twitter fa-1x" style="text-decoration: none;"></a>
            </li>
            <li class="list-inline-item">
                <a href="#" class="fab fa-google fa-1x" style="text-decoration: none;"></a>
            </li>
            <li class="list-inline-item">
                <a href="#" class="fab fa-linkedin fa-1x"></a>
            </li>

        </ul>
        <!-- Social buttons -->

        <!-- Copyright -->
        <div class="footer-copyright text-center py-2" style="color: white;">© 2020 Copyright:
            <a href="#" class="lead" style="text-decoration: none;font-weight: 700;">Alumni Tracking System</a>
        </div>
        <!-- Copyright -->

    </footer>
    <!-- Footer -->




    <script>
    AOS.init();
    </script>
    <script>
    $(".dropdown-menu a").click(function() {
        $(this).parents(".dropdown").find('.btn').html($(this).text() + ' <span class="caret"></span>');
        $(this).parents(".dropdown").find('.btn').val($(this).data('value'));
    });
    </script>
    <script src="js/scripts.js"></script>
</body>

</html>