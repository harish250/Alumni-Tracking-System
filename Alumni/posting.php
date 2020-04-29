<?php
session_start();
   
if(!isset($_SESSION['id']))
  header("location:index.php");
   
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
        href="https://fonts.googleapis.com/css?family=IBM+Plex+Sans:700i|Montserrat|Roboto|Raleway|Alfa+Slab+One|Oswald|Arvo:ital@1&family=Bitter:wght@700&display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="css/style.css" />
</head>

<body onload="setup('customview')">

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
    </script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="js/posting.js"></script>
    <!-- Nav bar -->
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
                            <a class="dropdown-item" href="#">Job Posting</a>
                            <a class="dropdown-item" href="events.html">Events</a>
                            <a class="dropdown-item" href="#">Group Chat</a>
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

            <a href="signout.php" class="btn btn-lg btn-outline-dark mr-2 text-decoration-none" id="signoutButton">Sign
                Out</a>

            <a data-toggle="modal" data-target="#editProfile">
                <span class="fas fa-user-circle fa-3x"></span>
            </a>
        </div>
    </nav>




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

    <!--Job Posting Description Modal  -->
    <div class="modal" id="jobDescriptionModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-center"></h5>
                    <button class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <!-- type and salary -->
                    <dl class="row">
                        <dt class="col-2">Type: </dt>
                        <dd class="col-10" id="type"></dd>
                        <dt class="col-2" >Salary: </dt>
                        <dd class="col-10" id="salary"></dd>
                        <dt class="col-2">Description: </dt>
                        <dd class="col-10" id="description"></dd>

                    </dl>
                    
                </div>
                <div class="modal-footer">
                    <!-- <a href="mailto:" class="btn btn-success">Apply Now</a> -->
                    <span class="text-muted ml-auto"></span>
                </div>
            </div>
        </div>
    </div>

    <!-- job posting section  -->
    <section id="showcase-content" class="img-fluid">
        <div class="dark-overlay">
            <div class="row">
                <div class="col">
                    <div class="container text-center" style="margin-top: 250px;">
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

    <!-- job posting content displayer -->
    <div class="posting-outline p-3">
        <div id="posting-section" class="container p-5 bg-white">
            <h2 class="text-center">Latest Job Postings</h2>
            <button class="btn btn-primary" data-toggle="collapse" data-target="#filterOptions">
                <i class="fas fa-tasks"></i> Filter
            </button>

            <div class="collapse form-check mt-3" id="filterOptions">
                <div class="mb-1">
                    <input class="form-check-input" type="radio" name="posting" id="myposting"
                        value="<?php echo $_SESSION['id']?>" checked>
                    <label class="form-check-label" for="myposting">My Posting</label>
                </div>
                <br>
                <div>
                    <input class="form-check-input" type="radio" name="posting" id="allpostings" value='all'>
                    <label class="form-check-label" for="allpostings">All Postings</label>

                </div>

                <button data-target="#filterOptions" data-toggle="collapse" class="btn btn-secondary d-block ml-auto"
                    onclick="setup('customview')">
                    Apply Filter
                </button>
            </div>
            <hr>
            <!-- col-12 offset-md-4 col-md-8 -->
            <div class="row">
                <div id="ack" class="text-muted mx-auto pt-5" style="display:none;">
                    <h3><em>No data to display</em></h3>
                </div>
                
                <table class="col offset-md-2 col-md-8 table table-bordered text-center" id="postingTable">
                </table>
            </div>

        </div>
    </div>



    <!--Section for posting job -->

    <section id="job-posting-form" class="my-3 p-5">
        <div class="container">
            <h5 class="text-center pt-3">Add a Job Posting</h5>
            <div class="row">
                <div class="col p-3">
                    <form>
                        <div class="form-group row">
                            <div class="col-sm-2">
                                <label for="post_company" class="col-form-label">Company:</label>
                            </div>
                            <div class="col-sm-10">
                                <input type="text" name="company" id="post_company" class="form-control"
                                    placeholder="Company">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-2">

                                <label class="col-form-label">Job Type:</label>
                            </div>
                            <div class="col-sm-10">
                            
                                <div >
                                    <!-- <button class="btn btn-secondary dropdown-toggle" type="button"
                                        id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">
                                        Job Type
                                        <span class="caret"></span>
                                    </button> -->

                                    <select id="options">
                                        <option value="Full Time">Full Time job</a>
                                        <option value="Part Time">Part time job</a>
                                        <option value="Work from Home">Work From Home</a>
                                        <option value="Internship">Internships</a>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-2">
                                <label for="post_salary" class="col-form-label">Salary:</label>

                            </div>
                            <div class="col-sm-10">
                                <input type="numeric" name="salary" id="post_salary" class="form-control"
                                    placeholder="Salary">
                            </div>

                        </div>
                        <div class="form-group row">
                            <div class="col-sm-2">
                                <label for="post_desc" class="col-form-label">Job Description:</label>

                            </div>
                            <div class="col-sm-10">
                                <textarea class="form-control" id="post_desc" rows="3"></textarea>
                            </div>

                        </div>

                        <div class="form-group text-center">
                            <button type="button" class="btn btn-lg btn-secondary" onclick="setup('post')">Post</button>
                            <span class="lead" id="post_ack"></span>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <input type="hidden" id="session_id" value="<?php echo $_SESSION['id']?>" class="d-none">
    </section>

    <footer class="page-footer font-small stylish-color-dark pt-4 bg-dark" id="#contact-us">
        <!-- Footer Links -->
        <div class="container text-center text-md-left">
            <!-- Grid row -->
            <div class="row">
                <!-- Grid column -->
                <div class="col-md-4 mx-auto">
                    <!-- Content -->
                    <h5 class="mb-4" id="footer-head">Contact us </h5>
                    <p id="footer-head-content">Alumni Tracking System Provides you with unlimited connection with your
                        Colleges </p>
                </div>
                <!-- Grid column -->
                <hr class="clearfix w-100 d-md-none">
                <!-- Grid column -->
                <div class="col-md-2 mx-auto">
                    <!-- Links -->
                    <h5 class="font-weight-bold text-uppercase mt-3 mb-4 text-white">Contact</h5>
                    <ul class="list-unstyled" id="contacts">
                        <li class="mb-3">
                            <a href="#!" style="text-decoration: none;font-weight: 500 ;">Hyderabad +91-9909893199</a>
                        </li>
                        <li class="mb-3">
                            <a href="#!" style="text-decoration: none; font-weight: 500;">Delhi +91-9651301646</a>
                        </li>
                        <li class="mb-3">
                            <a href="#!" style="text-decoration: none;font-weight: 500;">Kolkata +91-9964365878</a>
                    </ul>
                </div>
                <!-- Grid column -->
                <hr class="clearfix w-100 d-md-none">
                <!-- Grid column -->
                <div class="col-md-2 mx-auto" id="quick-links">
                    <!-- Links -->
                    <h5 class="font-weight-bold text-uppercase mt-3 mb-4 text-white">Quick Links</h5>
                    <ul class="list-unstyled">
                        <li class="mb-3">
                            <a href="#gallery" style="text-decoration: none;">Gallery</a>
                        </li>
                        <li class="mb-3">
                            <a href="#!" style="text-decoration: none;">Job Posting</a>
                        </li>
                        <li class="mb-3">
                            <a href="#!" style="text-decoration: none;">Events</a>
                        </li>
                        <li class="mb-3">
                            <a href="#!" style="text-decoration:none;">Notice Board</a>
                        </li>
                    </ul>
                </div>
                <!-- Grid column -->
            </div>
            <!-- Grid row -->
        </div>
        <!-- Footer Links -->
        <hr>
        -->
        <hr>
        <!-- Social buttons -->
        <ul class="list-unstyled list-inline text-center">
            <li class="list-inline-item">
                <a href="#" class="fab fa-facebook fa-3x" style="text-decoration: none;"></a>
            </li>
            <li class="list-inline-item">
                <a href="#" class="fab fa-twitter fa-3x" style="text-decoration: none;"></a>
            </li>
            <li class="list-inline-item">
                <a href="#" class="fab fa-google fa-3x" style="text-decoration: none;"></a>
            </li>
            <li class="list-inline-item">
                <a href="#" class="fab fa-linkedin fa-3x"></a>
            </li>

        </ul>
        <!-- Social buttons -->

        <!-- Copyright -->
        <div class="footer-copyright text-center py-3" style="color: white;">© 2020 Copyright:
            <a href="#" class="lead" style="text-decoration: none;font-weight: 700;">Alumni Tracking System</a>
        </div>
        <!-- Copyright -->

    </footer>
    <script>
    $(".dropdown-menu a").click(function() {
        $(this).parents(".dropdown").find('.btn').html($(this).text() + ' <span class="caret"></span>');
        $(this).parents(".dropdown").find('.btn').val($(this).data('value'));
    });
    </script>
</body>

</html>