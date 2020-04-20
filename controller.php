<?php
   include 'connect.php';

   if($connect->connect_error)
   {
       echo "<h1>Connection Error</h1>";
       
    }
    else
    {
        $action  = $_REQUEST["action"];

        switch($action)
        {
           case 'login':
            validate($connect);
           break;
           case 'achievements':
            loadAchievements($connect);
           break;
           default:
           echo "Nothing";
        }
    }
 



function validate($connect)
{
    // need to change the email id to username in table alumni
       $username = $_REQUEST["username"];
       $password = $_REQUEST["password"];
       $query="select * from alumni where emailId='$username' and password = '$password'";
       $result = $connect->query($query);
       if( $result->num_rows>0)
       { 
        if ($row = $result -> fetch_row()) {
              echo json_encode($row);   
        }    
       }
       else
       {
           echo "nouser";
       }
   
}
// validate($connect);

function loadAchievements($connect)
{
  
    $query = "select * from career_highlighting";
    $result = $connect->query($query);
    $row = $result->fetch_all(MYSQLI_ASSOC);
    echo json_encode($row);
}




?>