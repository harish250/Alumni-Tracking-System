<?php
session_start();
   
if(!isset($_SESSION['id']))
  header("location: ../Alumni/index.php");
   
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Achievements</title>


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
</head>


<body onload="setup('load')">

    <div class="wrapper">
        <nav id="sidebar">
            <div class="sidebar-header">
                <h3>Admin Dashboard</h3>
            </div>


            <ul class="list-unstyled components">
                <li>
                    <a href="#homeSubmenu">Home</a>
                </li>

                <li>
                    <a href="event.php">Events</a>
                </li>
                <li>
                    <a href="alumni.php">Our Alumni</a>
                </li>

                <li class="active">
                    <a href="#">Achievements</a>
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

            <div class="container-fluid" id="achievements">
                 
            </div>

            
            <div class="container" id="achievementcontent">
                <h1 class="text-center">Add an Achievement</h1>
                <form id="achievementsform">

                    <datalist id="names">
                    </datalist>

                    <div class="form-group row">
                        <label for="alumni_name" class="col-md-2">College id</label>
                        <input type="text" list="names" class="form-control col-md-10" id="email"
                            name="email" placeholder="Alumni name">
                    </div>
                    <div class="form-group row">
                        <label for="description" class="col-md-2">Description</label>
                        <textarea name="description" id="description" cols="30" rows="10"
                            class="col-md-10 form-control">
                            </textarea>
                    </div>
                    <div class="form-group row">
                        <input type="file" name="upload" id="upload" accept="image/*" value="upload"
                            class="form-control offset-md-2 col-md-10">
                    </div>
                    <div class="text-center">
                        <button class="btn btn-success" disabled type="button"
                        onclick="setup('postachievement')">Add Achievement</button>
                    </div>
                </form>
                <div class="text-center" id="divpost">
                     <h4><span id="ackpost"></span></h4>  
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
    <script src="js/achievements.js"></script>
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