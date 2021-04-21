<?php
session_start();

require_once('../utils/Admin.php');
require_once('../utils/Alumni.php');

$action = $_REQUEST['action'];

switch($action)
{
    // alumni.php
    case 'search':
        $val = $_REQUEST['val'];
        echo json_encode((new Admin())->searchAlumni($val));
        break;
    
    case 'particularalumni':
        $id = $_REQUEST['id'];   
        echo json_encode((new Admin())->getParticularAlumni($id));
        break;
    
    case 'contactinfo':
        $id = $_REQUEST['id'];   
        echo json_encode((new Admin())->getContactInfo($id));
        break;

    // event.php
    case 'uploadevent':
        $title = $_REQUEST['title'];

        $stime = timeConv_12_to_24($_REQUEST['stime'], $_REQUEST['samorpm']);
        $etime = timeConv_12_to_24($_REQUEST['etime'], $_REQUEST['eamorpm']);
        
        $sdatetime = $_REQUEST['sdate']." ".$stime;
        $edatetime = $_REQUEST['edate']." ".$etime;
        
        $desc = $_REQUEST['description'];

        $img = $_FILES['img'];
        echo (new Admin())->uploadEvent($title, $sdatetime, $edatetime, $desc, $img);
        break;
    
    case 'getevents':
        echo json_encode((new Admin())->getEvents());
        break;
    
    case 'deleteevent':
        $event_id = $_REQUEST['event_id'];
        echo json_encode((new Admin())->deleteEvent($event_id));
        break;
        
    // achievements.php
    case "postachievement":
        $email = $_REQUEST['email'];
        $desc = $_REQUEST['description'];
        $file = $_FILES['upload'];
        echo (new Admin())->postAchievement($email,$desc,$file);
        break;
        
    case 'names':
        echo json_encode((new Admin())->getAlumniNames());
        break;
        
    case 'getachievements':
        echo json_encode((new Alumni())->getAchievements());
        break;
        
    case 'deleteachievement':
        $url = $_REQUEST['url'];
        echo (new Admin())->deleteAchievement($url);
        break;
    
    // posting.php
    case 'getpostings':
        $val = $_REQUEST['val'];
        echo json_encode((new Admin())->getJobPostings($val));
        break;

    case 'delpost':
        $job_id = $_REQUEST['job_id'];
        echo (new Alumni())->delPost($job_id);
        break;
        
    case 'post':
        $company = $_REQUEST['company'];
        $sal = $_REQUEST['salary'];
        $type = $_REQUEST['type'];
        $desc = $_REQUEST['description'];
        $id = $_SESSION['id'];
        echo (new Alumni())->post($id,$company, $sal, $type, $desc);
        break;

    case 'showdescription':
        $job_id = $_REQUEST['job_id'];
        echo json_encode((new Alumni())->getParticularPosting($job_id));
        break;

    // index.php loading stats
    case 'getstats':
        echo json_encode((new Admin())->getStats());
        break;
}

function timeConv_12_to_24(string $time,string $ampm)
{
    $hr = explode(":",$time)[0];
    $min = explode(":",$time)[1];
    $hr_24_fmt = 0;
    if($ampm == 'am') //no adding except for 12am which is to be returned as 00
    {
        $hr_24_fmt = ($hr == '12')?(int)$hr - 12: $hr;
    }
    else //pm ,then add 12 to hr except for 12 pm which is to be returned as 12
    {
        $hr_24_fmt = ($hr == '12')?$hr: (int)$hr + 12;
    }
    return "$hr_24_fmt:$min";
}

?>