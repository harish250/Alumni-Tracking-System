<?php
session_start();

if(!isset($_SESSION['id']) || $_SESSION['type'] == 1)
{
    //he tried entering pass $_SESSION['tried'] = true ...that means invalid username or password
    //or he just visited then isset($_SESSION['tried']) == false ,so do nothing
    header("location:index.php");
}
   
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0,user-scalable=no">
    <title>Document</title>

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css"
        integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css"
        integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.css"
        integrity="sha256-HAaDW5o2+LelybUhfuk0Zh2Vdk8Y2W2UeKmbaXhalfA=" crossorigin="anonymous" />
    <link
        href="https://fonts.googleapis.com/css?family=IBM+Plex+Sans:700i|Montserrat|Roboto|Raleway|Alfa+Slab+One|Oswald&display=swap"
        rel="stylesheet" />
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css" />

</head>

<body onload="setup('load')">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
    </script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    </script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

    <nav class="navbar fixed-top navbar-expand-sm navbar-light bg-light">
        <a href="index.php" class="logo mr-4">
            <span class="logo-section mr-3">
                <img src="img/download-removebg-preview.png" alt="" />
            </span>
            <span class="navbar-brand mr-5">Alumni Tracking System</span>
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
                            <a class="dropdown-item" href="gallery.php">Gallery</a>
                            <a class="dropdown-item" href="posting.php">Job Posting</a>
                            <a class="dropdown-item" href="#">Events</a>
                            <a class="dropdown-item" href="chat.php">Group Chat</a>

                        </div>
                    </div>

                </li>
                <li class="nav-item mr-2">
                    <a class="nav-link" href="#contact-us">Contact</a>
                </li>
            </ul>

            <span class="navbar-text mr-2" id="loggedInAs">
                Welcome <?php  echo $_SESSION['username'] ?>
            </span>

            <a href="../signout.php" class="btn btn-lg btn-outline-dark mr-2 text-decoration-none" id="signoutButton">Sign
                Out</a>

            <a data-toggle="modal" data-target="#editProfile">
                <span class="fas fa-user-circle fa-3x"></span>
            </a>
            </a>
        </div>

    </nav>

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
                            <input type="text" class="form-control" name="username" placeholder="Enter your Email Id"
                                id="username">
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" name="password" placeholder="Password"
                                id="password">
                        </div>
                        <div class="form-group text-center">
                            <input type="submit" value="Login" class="btn btn-lg btn-secondary">
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>



    <!-- modal for signup -->
    <div class="modal" id="mysignupmodal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title w-100 text-center">Signup</h5>
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
                                <input type="submit" value="Submit" class="btn btn-lg btn-secondary">
                            </div>


                        </div>
                    </form>
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




    <!-- image  for display -->
    <section id="image-display" class="img-fluid">
        <div class="dark-overlay">
            <div class="row">
                <div class="col">
                    <div class="container align-center" style="padding-top: 250px;">
                        <h1 class="text-center mt-5">
                            "Events Like Never Before"
                        </h1>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Welcome section -->
    <section id="welcome-section">
        <div class="container text-center">
            <h1 class="p-3">We Welcome you to our college fest</h1>
            <p class="mb-4 p-3">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Accusantium, consequuntur
                nesciunt quos neque quae totam vel dicta fuga necessitatibus dolorum amet expedita quisquam magni modi
                veniam quis repellendus ab molestiae?</p>
            <div class="row">
                <div class="col-md-4 mb-5">
                    <i class="fas fa-user-tie fa-3x mb-2"></i>
                    <h4>Visit</h4>
                </div>
                <div class="col-md-4 mb-5">
                    <i class="fas fa-handshake fa-3x mb-2"></i>
                    <h4>Meet</h4>
                </div>
                <div class="col-md-4 mb-5">
                    <i class="fas fa-music fa-3x mb-2"></i>
                    <h4>Enjoy</h4>
                </div>
            </div>
        </div>
    </section>

    <section id="events-content" class="m-3">

        <div class="container">
          <div class="row">
            
          </div>
            <!-- <div class="row">
                <div class="media mt-4 col" data-aos="fade-right" data-aos-duration="2000">
                    <a class="d-flex align-self-center" href="#">
                        <img src="img/logo.png" alt="" class="img-fluid ml-5">
                    </a>
                    <div class="media-body m-5">
                        <h5>Kmit Evening</h5>
                        <p class="d-none d-sm-block">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Nihil ex
                            rem voluptatem voluptates vero. Culpa consectetur quidem repellat vel! Rerum voluptatibus
                            odio dolor distinctio, est pariatur eligendi vitae deserunt veniam?</p>
                        <h5>Timmings 6:30pm to 9:30pm</h5>
                        <h5>Date 25/03/2020</h5>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="media mt-4 col" data-aos="fade-left" data-aos-duration="2000">
                    <a class="d-flex align-self-center" href="#">
                        <img src="img/logo.png" alt="" class="img-fluid ml-5">
                    </a>
                    <div class="media-body m-5">
                        <h5>PatangUtsav</h5>
                        <p class="d-none d-sm-block">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Nihil ex
                            rem voluptatem voluptates vero. Culpa consectetur quidem repellat vel! Rerum voluptatibus
                            odio dolor distinctio, est pariatur eligendi vitae deserunt veniam?</p>
                        <h5>Timmings 6:30pm to 9:30pm</h5>
                        <h5>Date 25/03/2020</h5>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="media mt-4 mb-3 col" data-aos="fade-right" data-aos-duration="2000">
                    <a class="d-flex align-self-center" href="#">
                        <img src="img/logo.png" alt="" class="img-fluid ml-5">
                    </a>
                    <div class="media-body m-5">
                        <h5>Dandiya Nights</h5>
                        <p class="d-none d-sm-block">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Nihil ex
                            rem voluptatem voluptates vero. Culpa consectetur quidem repellat vel! Rerum voluptatibus
                            odio dolor distinctio, est pariatur eligendi vitae deserunt veniam?</p>
                        <h5>Timmings 6:30pm to 9:30pm</h5>
                        <h5>Date 25/03/2020</h5>
                    </div>
                </div>
            </div> -->
        </div>


    </section>
    <!-- Footer section -->
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

    <script>
    AOS.init();
    </script>
    <script src="js/events.js"></script>
</body>

</html>