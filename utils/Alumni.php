<?php
require_once('DBConnection.php');

class Alumni
{
    public function getJobPostings(string $id = 'all'):array
    {
        $conn = DBConnection::getConn();
        $sql = "select job_id,company, type, salary from ".DBConstants::$JOB_POSTING_TABLE;
    
        $condition = ($id == 'all')?'':" where alumni_id = '$id'";
        
        $sql .= $condition;
        $sql .= " order by date_posted desc"; //just to place the recent ones first
        $result = $conn->query($sql);

        $conn->close();
        
        if($result->num_rows > 0)
        {
            return $result->fetch_all(MYSQLI_ASSOC);
        }
        
        return [];
    }
    
    public function validate(string $username, string $password):array
    {
        $conn = DBConnection::getConn();
        
        $sql = "select alumni_id 'id', username from ".DBConstants::$ALUMNI_TABLE." where 
        (email= '$username' or alumni_id = '$username') and password = '$password'";

        $result = $conn->query($sql);
        $conn->close();
        
        if($result->num_rows > 0)
            return $result->fetch_assoc();
        
        return [];
    }

    public function getAchievements():array
    {
        $conn = DBConnection::getConn();

        $sql = "select a.username 'alumni_name', c.description 'desc', c.alumni_photo_url 'url' 
        from ".DBConstants::$CAREER_TABLE.' c, '.DBConstants::$ALUMNI_TABLE.' a where a.alumni_id = c.alumni_id;';

        $result = $conn->query($sql);
        $conn->close();
        
        if($result->num_rows > 0)
            return $result->fetch_all(MYSQLI_ASSOC);
        
        return [];
    }
    public function getParticularPosting(string $jobid):array
    {
        $conn = DBConnection::getConn();
        $sql="select a.email, j.* from ".DBConstants::$ALUMNI_TABLE." a, ".DBConstants::$JOB_POSTING_TABLE." j 
        where job_id='$jobid' and a.alumni_id = j.alumni_id";
        $result=$conn->query($sql);
    
        $conn->close(); 

        if($result->num_rows>0)
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function post(string $jobid, string $company, string $sal, string $type, string $desc):bool
    {
        $conn = DBConnection::getConn();

        $sql = "insert into ".DBConstants::$JOB_POSTING_TABLE."(alumni_id, company, salary, type, description) 
        values('$jobid', '$company', $sal, '$type', '$desc')";

        $result = $conn->query($sql);
        $conn->close();

        return $result;
    }

    public function delPost(string $job_id)
    {
        $conn = DBConnection::getConn();
        
        $sql = 'delete from '.DBConstants::$JOB_POSTING_TABLE." where job_id = '$job_id'";
        
        $result = $conn->query($sql);
        $conn->close();

        return $result;
    }
    public function uploadFile(string $id, array $files):array
    {
        
        $conn = DBConnection::getConn();
        
        $insert_stmt = $conn->prepare("insert into ".DBConstants::$GALLERY_TABLE."(alumni_id, image_url) values('$id', ?)");
        $del_stmt = $conn->prepare("delete * from ".DBConstants::$GALLERY_TABLE." where 
                    alumni_id = '$id' and image_url = ?");
        
        $successful = [];
        $failed = [];
        
        $imgFolder='img/'; //target folder
        
        foreach($files as $file)
        {
            $dest = uniqid($imgFolder);  //inorder to get-rid of conflicts due to same img name
            $type = explode("/",$file['type'])[1]; //fetching the ext of the img
            $dest .= ".$type"; //making the full dest img's path
            
            $insert_stmt->bind_param('s',$dest);
            $ack = $insert_stmt->execute();
            
            if($ack) //if inserted successfully
            {
                $src =$file['tmp_name'];
                $ack = move_uploaded_file($src, $dest);
                
                if(!$ack) //if it fails to move the file then we are supposed to remove its entry from the table
                {
                    $del_stmt->bind_param('s',$dest);
                    $del_stmt->execute();
                    array_push($failed, $file['name']);
                }
                else
                {
                    array_push($successful, $file['name']);
                }
            }
            else
            {
                array_push($failed, $file['name']);
            }
        }

        $info['successful'] = $successful;
        $info['failed'] = $failed;
         
        return $info;
    }

    public function getGallery()
    {
        $conn = DBConnection::getConn();
        $sql = "select a.username, g.image_url 'url', g.date_uploaded from ".DBConstants::$ALUMNI_TABLE." a, "
        .DBConstants::$GALLERY_TABLE." g where a.alumni_id = g.alumni_id";

        $result = $conn->query($sql);

        $conn->close();
        if($result->num_rows > 0)
            return $result->fetch_all(MYSQLI_ASSOC);
        
        return [];
    }
}
?>
