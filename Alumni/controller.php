<?php
session_start();
require_once('../utils/Alumni.php');

$action = $_REQUEST['action'];

switch($action)
{
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