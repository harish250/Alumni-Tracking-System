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
    <link rel="stylesheet" href="css/chatstyle.css" />
    <link rel="stylesheet" href="css/style.css" />

</head>

<body onload="setup('load')">
    <style type="text/css"> 
        div._<?php echo $_SESSION['id']?>
        {
            justify-content: flex-end;
            
        }
        div._<?php echo $_SESSION['id']?> div.chat-content
        {
            background: #F5F5F5;
            color: #384664; 
            border-radius: 25px 0px 25px 25px ;
            order:1;
            min-width: 500px;
            max-width: 600px;
            padding: 0px 15px 0px 15px;
        }
       div._<?php echo $_SESSION['id']?> .profile-photo
        {
            margin-left: 15px;
            order: 2;
        }
    
    </style>
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
                            <a class="dropdown-item" href="events.php">Events</a>
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




    <div class="container align-center" style="padding-top: 100px;">
        <h1 class="text-center mt-2">
            "THE GROUP CHAT"
        </h1>
    </div>
    <!-- image  for display -->
   
    <!-- Welcome section -->
   

    <section id="chat-content" class="mt-2 mb-2">
        <div class="container">
            <div class="row">
                <div id="wrapper">
                    <div id="menu">
                        <p class="welcome">Welcome, <b><?php echo $_SESSION['username']; ?></b></p>
                    </div>

                    <div id="chatbox">
                    <?php
                    if(file_exists("log.html") && filesize("log.html") > 0){
                        $contents = file_get_contents("log.html");          
                        echo $contents;
                    }
                    ?>
                    </div>
                    <form name="message" action="">
                        <input name="usermsg" type="text" id="usermsg" />
                        <input name="submitmsg" type="submit" id="submitmsg" value="Send"/>
                    </form>
                </div>
                <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
                <script type="text/javascript">
                    // jQuery Document
                    $(document).ready(function () {
                        $("#submitmsg").click(function () {
                            var clientmsg = $("#usermsg").val();
                            $.post("controller.php?action=logchat", { text: clientmsg });
                            $("#usermsg").val("");
                            return false;
                        });

                        function loadLog() {
                            var oldscrollHeight = $("#chatbox")[0].scrollHeight - 20; //Scroll height before the request
                            
                            $.ajax({
                                url: "log.html",
                                cache: false,
                                success: function (html) {
                                    $("#chatbox").html(html); //Insert chat log into the #chatbox div
                                    
                                    //Auto-scroll           
                                    var newscrollHeight = $("#chatbox")[0].scrollHeight - 20; //Scroll height after the request
                                    if(newscrollHeight > oldscrollHeight){
                                        $("#chatbox").animate({ scrollTop: newscrollHeight }, 'normal'); //Autoscroll to bottom of div
                                    }   
                                }
                            });
                        }
                        
                        setInterval (loadLog, 2500);
                    });
                    </script>
            </div>
        </div>
    </section>

    <!-- Footer section -->
    <footer class="page-footer font-small stylish-color-dark pt-4 bg-dark" id="contact-us">
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
        AOS.init();
        </script>
    <script src="js/events.js"></script>
</body>

</html>