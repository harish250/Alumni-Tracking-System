<?php
session_start();
require_once('../utils/Alumni.php');

$action = $_REQUEST['action'];

switch($action)
{
    case 'showdescription':
                        $jobid=$_REQUEST['jobid'];
                        echo json_encode((new Alumni())->getDescription($jobid));
                        break;
    case 'customview':$id = $_REQUEST['id'];
                        echo json_encode((new Alumni())->getJobPostings($id));
                        break;
    case 'login':
                    $username = $_REQUEST['username'];
                    $pass = $_REQUEST['pass'];
                    
                    $arr = (new Alumni())->validate($username, $pass);
                    
                    if(count($arr) > 0)
                    {
                        $_SESSION['username'] = $arr['username'];
                        $_SESSION['id'] = $arr['id'];
                        echo $arr['username'];
                    }
                    echo false;
                    break;
    case 'achievements':
    $achs = (new Alumni())->getAchievements();
    echo json_encode($achs);
}


?>