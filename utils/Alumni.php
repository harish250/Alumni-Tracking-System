<?php

use function PHPSTORM_META\type;

require_once('DBConnection.php');

class Alumni
{
    public function getJobPostings(string $id = 'all'):array
    {
        $conn = DBConnection::getConn();
        $sql = "select job_id,company, type, salary from ".DBConstants::$JOB_POSTING_TABLE;
    
        $condition = ($id == 'all')?'':" where id = ?";
        
        $sql .= $condition;
        $sql .= " order by date_posted desc"; //just to place the recent ones first

        $stmt = $conn->prepare($sql);
        
        if(strpos($sql, "where"))
            $stmt->bind_param("s", $id);

        $stmt->execute();
        $result = $stmt->get_result();

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
        (email= ? or alumni_id = ?) and password = ?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $username, $username, $password);
        $stmt->execute();
        $result = $stmt->get_result();
        
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
    public function getParticularPosting(string $job_id):array
    {
        $conn = DBConnection::getConn();
          
        $stmt = $conn->prepare("select a.username,a.email, j.* from ".DBConstants::$ALUMNI_TABLE." a, ".DBConstants::$JOB_POSTING_TABLE." j 
        where a.alumni_id = j.id and job_id = ?");

        $stmt->bind_param("i", $job_id);

        $stmt->execute();
        $result = $stmt->get_result();
        
        //If alumni has not posted the job then it must be an admin
        if($result->num_rows<=0)
        {
            
            $stmt = $conn->prepare("select 'COLLEGE' as 'username',a.email, j.* from ".DBConstants::$ADMIN_TABLE." a, ".DBConstants::$JOB_POSTING_TABLE." j 
            where job_id = ? and a.admin_id = j.id");

            $stmt->bind_param("i", $job_id);

            $stmt->execute();
            $result = $stmt->get_result();
        }

        $conn->close(); 
        
        if($result->num_rows > 0)
            return $result->fetch_all(MYSQLI_ASSOC);
        
        return [];
    }

    public function post(string $id, string $company, string $sal, string $type, string $desc):bool
    {
        $conn = DBConnection::getConn();

        $stmt = $conn->prepare("insert into ".DBConstants::$JOB_POSTING_TABLE."(id, company, salary, type, description) 
        values(?, ?, ?, ?, ?);");
        
        $stmt->bind_param("sssss", $id, $company, $sal, $type, $desc);

        $result = $stmt->execute();
        $conn->close();

        return $result;
    }

    public function delPost(string $job_id)
    {
        $conn = DBConnection::getConn();
        
        $sql = 'delete from '.DBConstants::$JOB_POSTING_TABLE." where job_id = ?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $job_id);
        
        $result = $stmt->execute();
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

    function createAccount(array $info):bool
    {
        $conn = DBConnection::getConn();

        $username = $info['fullname'];
        $email = $info["email"];
        $password=$info['password'];
        $company=$info["company"];
        $designation = $info["designation"];
        $address = $info["address"];
        $rollno=$info["rollno"];
        $branch=$info['branch'];
        $phno=$info["phno"];
        $yearofgrad=$info["yearofgraduation"];

        $sql = "insert into ".DBConstants::$ALUMNI_TABLE."(alumni_id,username,email,password,company,designation,address,branch,phno,yearofgraduation)  values( ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssssssss",
                                $rollno,
                                $username,
                                $email,
                                $password,
                                $company,
                                $designation,
                                $address,
                                $branch,
                                $phno,
                                $yearofgrad);
          
        $result = $stmt->execute();
        
        $conn->close();
        if($result)
        {
            return true;
        }
       return false;
    }
}
?>