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
        $_SESSION['type'] = 0; // Here 0 means Alumni, 1 means Admin
        if(count($arr) > 0)
        {
            $_SESSION['username'] = $arr['username'];
            $_SESSION['id'] = $arr['id'];
            $ret_value = $arr['username']."@alumni";
        }
        else
        {
            $arr = (new Admin())->validate($username, $pass);
            if(count($arr) > 0)
            {
                $_SESSION['username'] = $arr['username'];
                $_SESSION['id'] = $arr['id'];
                $ret_value = $arr['username']."@admin";
                $_SESSION['type'] = 1;
            }
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
    case 'signup':
        echo (new Alumni())->createAccount($_REQUEST);
        break;  

    // chat.php
    case 'logchat':
        if(isset($_SESSION['id'])){
            $text = $_POST['text'];
            date_default_timezone_set("Asia/Kolkata");
            //$date=date_create(date(),timezone_open("Asia/Kolkata"));
            // $text_message = "<div class='msgln'><span class='chat-time'>".date_format($date,"g:i a")."</span> <b class='user-name'>".$_SESSION['username']."</b> ".stripslashes(htmlspecialchars($text))."<br></div>";
            $text_message = "<div class='mb-3 _".$_SESSION['id']." msg'>
            <div class='profile-photo'>
                <span class='fas fa-user-circle fa-2x'></span>
            </div>
            <div class='chat-content'>
                
                <div class='mb-0 chat-head'>
                        <p class='mb-0 username'>".$_SESSION['username']."</p>
                        <p class='mb-0 time'>".date("g:i a")."</p>
                </div>
                <hr class='m-1'>
                <div class='chat-body'>
                    <p class='message'>".stripslashes(htmlspecialchars($text))."</p>
                </div>
            </div>
        </div>";
            file_put_contents("log.html", $text_message, FILE_APPEND | LOCK_EX);
            
        }
}


?>
