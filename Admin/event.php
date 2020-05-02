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

<body onload="setup('loadevents')">

    <div class="wrapper">
        <nav id="sidebar">
            <div class="sidebar-header">
                <h3>Admin Dashboard</h3>
            </div>


            <ul class="list-unstyled components">
                <li>
                    <a href="#homeSubmenu">Home</a>

                </li>

                <li class="active">
                    <a href="#">Post an event</a>
                </li>
                <li>
                    <a href="#pageSubmenu">Our Alumni</a>
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


         <div class="container" id="eventcontent">
         <div class="row">
         <!-- <div class="media mt-4 col" data-aos="fade-right" data-aos-duration="2000">
             <a class="d-flex align-self-center" href="#">
                   <img src="#" alt="" class="img-fluid ml-5">
             </a>
             <div class="media-body m-5">
                 <h5 id="eventtitle">Kmit Evening</h5>
                 <p class="d-none d-sm-block" id="eventdesc"></p>
                 <h5 id="eventtime">Timmings 6:30pm to 9:30pm</h5>
                 <h5 id="">Date 25/03/2020</h5>
             </div>
             
         </div> -->
            </div>
         </div>

            <div class="container p-3" id="postevent">
                 
                 <h2 class="text-center mb-3">Post an Event</h2>
                <form id="postForm" class="p-2">
                    <div class="form-group row">
                        <label for="title" class="col-md-2">Title</label>
                        <input type="text" name="title" id="title" placeholder="title" class="col-md-10 form-control">
                    </div>
                    <div class="form-group row">
                        <label for="startdate" class="col-md-2">Start Date</label>
                        <input type="text" name="startdate" id="startdate" placeholder="yyyy-mm-dd" class="col-md-4 form-control mr-2">
                        <input type="text" name="starttime" id="starttime" placeholder="hh:mm" class="col-md-2 form-control mr-2">
                        <select name="ampm" id="startampm" class="form-control col-md-1 mr-2">
                            <option value="am">am</option>
                            <option value="pm">pm</option>
                        </select>
                        <small class="offset-md-2 col-4 text-muted">Eg. 2020-2-10</small>
                    </div>
                    <div class="form-group row">
                    <label for="enddate" class="col-md-2">End Date</label>
                    <input type="text" name="enddate" id="enddate" placeholder="yyyy-mm-dd" class="form-control col-md-4 mr-2">
                    <input type="text" name="endtime" id="endtime" placeholder="hh:mm" class="col-md-2 form-control mr-2">
                    <select name="ampm" id="endampm" class="form-control col-md-1 mr-2">
                            <option value="am">am</option>
                            <option value="pm">pm</option>
                        </select>
                    </div>
                    <div class="form-group row">
                        <label for="description" class="col-md-2">Description</label>
                        <textarea name="description" id="description" cols="30" rows="10" placeholder="Description" class="col-md-10 form-control"></textarea>
                    </div>
                   
                    <div class="form-group row">
                        <input type="file" name="upload" id="upload" accept="image/*" value="upload" class="form-control offset-md-2 col-md-10">
                    </div>
                    <div class="form-group text-center">
                    <input type="button" value="Post" name="postbutton" class="btn btn-lg btn-primary" id="postbutton" onclick="setup('postevent')">
                   
                    </div>
                </form>
                <div class="text-center">

                    <small id="promptmsg"></small>
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
    <script src="js/events.js"></script>
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