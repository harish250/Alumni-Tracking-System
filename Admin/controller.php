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
}

?>