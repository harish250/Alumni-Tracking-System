<?php
session_start();
require_once('../utils/Alumni.php');
require_once('../utils/Admin.php');
$action = $_REQUEST['action'];

switch($action)
{

    // gallery.php

    case 'upload':
        $id = $_SESSION['id'];
        echo json_encode((new Alumni())->uploadFile($id, $_FILES));
        break;
    
    case 'getgallery':
        echo json_encode((new Alumni())->getGallery());
        break;
        
    // posting.php
    case 'post':
        $company = $_REQUEST['company'];
        $sal = $_REQUEST['salary'];
        $type = $_REQUEST['type'];
        $desc = $_REQUEST['description'];
        $id = $_SESSION['id'];

        echo (new Alumni())->post($id,$company, $sal, $type, $desc);
        break;
        
    case 'showdescription':
        $jobid=$_REQUEST['jobid'];
        echo json_encode((new Alumni())->getParticularPosting($jobid));
        break;
    
    case 'customview':
        $id = $_REQUEST['id'];
        echo json_encode((new Alumni())->getJobPostings($id));
        break;
    
    case 'delpost':
        $job_id = $_REQUEST['job_id'];
        echo (new Alumni())->delPost($job_id);
        break;            
    
        // index.php
    case 'login':
        $username = $_REQUEST['username'];
        $pass = $_REQUEST['password'];
        $ret_value = "0";
        $arr = (new Alumni())->validate($username, $pass);
        if(count($arr) > 0)
        {
            $_SESSION['username'] = $arr['username'];
            $_SESSION['id'] = $arr['id'];
            $ret_value = $arr['username']."@alumni";
        }
        else
        {
            $arr = (new Admin())->validate($username, $pass);
            $_SESSION['username'] = $arr['username'];
            $_SESSION['id'] = $arr['id'];
            $ret_value = $arr['username']."@admin";
        }
        
        echo $ret_value;
        break;

    case 'achievements':
        $achs = (new Alumni())->getAchievements();
        echo json_encode($achs);
        break;
    
    //events.php
    case 'loadevents':
        echo json_encode((new Admin())->getEvents());
        break;
}


?>