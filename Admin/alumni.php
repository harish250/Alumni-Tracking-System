<?php
session_start();
   
if(!isset($_SESSION['id']))
header("location: ../Alumni/index.php");
   
?>

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
        integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css"
        integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
    <link
        href="https://fonts.googleapis.com/css?family=IBM+Plex+Sans:700i|Montserrat|Roboto|Raleway|Poppins:wght@600&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="css/styles.css">
    <title>Admin Dashboard</title>
</head>

<body onload="setup('search')">

    <div class="wrapper">
        <nav id="sidebar">
            <div class="sidebar-header">
                <h3>Admin Dashboard</h3>
            </div>


            <ul class="list-unstyled components">
                <li>
                    <a href="index.php">Home</a>
                </li>

                <li>
                    <a href="event.php">Events</a>
                </li>
                <li class="active">
                    <a href="#">Our Alumni</a>
                </li>
                <li>
                    <a href="achievements.php">Achievements</a>
                </li>
                <li>
                    <a href="posting.php">Job Postings</a>
                </li>

            </ul>


        </nav>

        <div class="container-fluid">

            <nav class="navbar navbar-expand-lg navbar-light bg-light">

                <button type="button" id="sidebarCollapse" class="btn btn-secondary">
                    <i class="fa fa-align-justify"></i>
                </button>

                <!--<a class="navbar-brand" href="#">Navbar</a> -->
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav mx-auto">
                        <li class="nav-item active">
                            <a class="nav-link" href="#">Admin DashBoard <span class="sr-only">(current)</span></a>
                        </li>

                    </ul>
                    <a href="../signout.php" class="btn btn-outline-secondary text-decoration-none" id="signoutButton">Sign
                        Out</a>
                </div>
            </nav>
            <!--Alumni Modal -->
            <div class="modal" id="alumniModal">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title"></h4>
                            <button class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                            <dl class="row">
                                <dt class="col-3">Roll No: </dt>
                                <dd class="col-9" id="roll"></dd>
                                <dt class="col-3">Branch: </dt>
                                <dd class="col-9" id="branch"></dd>
                                <!-- example cse 2017 -->
                                <dt class="col-3">Company: </dt>
                                <dd class="col-9" id="company"></dd>
                                <dt class="col-3">Address: </dt>
                                <dd class="col-9" id="address"></dd>

                                <dt class="offset-sm-3 col-sm-10 col-12 mt-3 mb-2 h5">
                                    Contributions:
                                </dt>
                                <dd class="offset-sm-1 col-5">
                                    <button type="button" class="btn btn-primary">
                                        Images Uploaded <span class="badge badge-light" id="img"></span>
                                    </button>
                                </dd>
                                <dd class="ml-3 col-5">
                                    <button type="button" class="btn btn-secondary">
                                        Job Postings <span class="badge badge-light" id="posting"></span>
                                    </button>
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Connect -->
            <div class="modal" id="connectModal">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Connect Via</h4>
                            <button class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body text-center">
                            <a class="btn btn-info btn-lg mr-3" id="call_btn">call <i class="fa fa-phone"
                                    aria-hidden="true"></i></a>
                            <a class="btn btn-secondary btn-lg" id="mail_btn">mail <span
                                    class="far fa-envelope"></span></a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-md-10">
                    <input type="text" id="searchinput" onkeyup="pressSearchBtn(event)" class="form-control mb-2">
                </div>
                <div class="col-md-2">
                    <button class="btn btn-outline-secondary" onclick="setup('search')">
                        <span id="searchbtn" class="fas fa-search"></span>
                        Search
                    </button>
                </div>

                <small class="text-muted ml-2 ">
                    eg: BATCH_YEAR/BRANCH/NAME/COMPANY/DESIGNATION
                </small>
            </div>

            <div class="container" id="alumnicontent">
                <div class="row">
                    <div class="col-md-3 card mb-3 mt-5 p-3">
                        <div class="card-body">
                            <h4 class="card-title">Govind Asawa</h4>
                            <h5 class="card-subtitle"><span class="badge badge-secondary badge-lg">2017 Batch</span>
                            </h5>
                            <h5 class="card-text">Google</h5>


                            <a name="connect" id="connect" class="btn btn-lg btn-outline-success" href="#"
                                role="button">Connect</a>


                        </div>
                    </div>

                </div>


            </div>


        </div>
    </div>


    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"
        integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous">
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
        integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous">
    </script>
    <script src="js/alumni.js"></script>
    <script>
    $(document).ready(function() {
        $('#sidebarCollapse').on('click', function() {
            $('#sidebar').toggleClass('active');
        });
    });
    </script>





</body>

</html>