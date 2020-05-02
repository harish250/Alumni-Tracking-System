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
        
        $sdatetime = $_REQUEST['sdate']." ".(($_REQUEST['samorpm'] == 'am')?$_REQUEST['stime']:(int)$_REQUEST['stime']+12);

        $edatetime = $_REQUEST['edate']." ".(($_REQUEST['eamorpm'] == 'am')?$_REQUEST['etime']:(int)$_REQUEST['etime']+12);

        $desc = $_REQUEST['description'];

        // var_dump($_FILES);
        $img = $_FILES['img'];
        // echo false;
        echo (new Admin())->uploadEvent($title, $sdatetime, $edatetime, $desc, $img);
        break;
    
    case 'getevents':
        echo json_encode((new Admin())->getEvents());
        break;

}

?>