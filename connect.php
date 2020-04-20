<?php
    $servername="localhost";
    $username="admin";
    $password="admin123";
    $dbname = "alumnibase";
   global $connect;
   $connect = new mysqli($servername,$username,$password,$dbname);
?>
