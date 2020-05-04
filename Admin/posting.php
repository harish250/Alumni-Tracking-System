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
        <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="css/styles.css">
    <title>Events</title>
</head>

<body onload="setup('load')">

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
                        <dt class="col-2">Posted by: </dt>
                        <dd class="col-10" id="by"></dd>
                        <dt class="col-2">Type: </dt>
                        <dd class="col-10" id="type"></dd>
                        <dt class="col-2" >Salary: </dt>
                        <dd class="col-10" id="salary"></dd>
                        <dt class="col-2">Description: </dt>
                        <dd class="col-10" id="description"></dd>

                    </dl>
                    
                </div>
                <div class="modal-footer">
                    <span class="text-muted ml-auto"></span>
                </div>
            </div>
        </div>
    </div>

    <div class="wrapper">
        <nav id="sidebar">
            <div class="sidebar-header">
                <h3>Admin Dashboard</h3>
            </div>


            <ul class="list-unstyled components">
                <li>
                    <a href="#homeSubmenu">Home</a>

                </li>

                <li >
                    <a href="event.php">Events</a>
                </li>
                <li>
                    <a href="alumni.php">Our Alumni</a>
                </li>
                <li>
                    <a href="achievements.php">Achievements</a>
                </li>
                <li class="active">
                    <a href="#">Job Postings</a>
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
                    <a href="signout.php" class="btn btn-outline-secondary text-decoration-none" id="signoutButton">Sign
                        Out</a>
                </div>
            </nav>

            <div class="form-group row">
                <div class="col-md-10">
                    <input type="text" id="searchinput" onkeyup="pressSearchBtn(event)" class="form-control mb-2">
                </div>
                <div class="col-md-2">
                    <button class="btn btn-outline-secondary" onclick="setup('load')">
                        <span id="searchbtn" class="fas fa-search"></span>
                        Search
                    </button>
                </div>

                <small class="text-muted ml-2 ">
                    eg: COMPANY/JOB_TYPE/ROLE (Web development,Machine Learning)
                </small>
            </div>

            <div class="container" id="jobpostingcontent">
                <div class="row">
                    <div id="ack" class="text-muted mx-auto pt-5" style="display:none;">
                        <h3><em>No data to display</em></h3>
                    </div>
                    
                    <table class="col col-md-8 table table-bordered text-center" id="postingTable">
                    </table>
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
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="js/posting.js"></script>
    <script>
    $(document).ready(function() {
        $('#sidebarCollapse').on('click', function() {
            $('#sidebar').toggleClass('active');
        });
    });
    </script>
<script>
    AOS.init();
  </script>




</body>

</html>