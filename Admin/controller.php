<?php
session_start();

require_once('../utils/Admin.php');

$action = $_REQUEST['action'];

switch($action)
{
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