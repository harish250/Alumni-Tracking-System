<?php
require_once('DBConnection.php');

    class Admin
    {
        function validate($username, $pass):array
        {
            $conn = DBConnection::getConn();
            
            $sql = "select username, admin_id 'id' from ".DBConstants::$ADMIN_TABLE." where (username = ? or 
            admin_id = ?) and password = ?";
            
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sss", $username, $username, $pass);
            $stmt->execute();

            $result = $stmt->get_result();
            $conn->close();
            
            if($result->num_rows)
                return $result->fetch_assoc();
            
            return [];
            
        }

        function searchAlumni(string $val):array
        {
            $conn = DBConnection::getConn();
            $expr = "%$val%";

            $sql = "select a.alumni_id, a.username, a.company, EXTRACT( YEAR FROM DATE_SUB(a.yearofgraduation,INTERVAL 4 YEAR)) 'batch_year', a.designation from ".DBConstants::$ALUMNI_TABLE." a 
            where username like ? or company like ? or branch like ? or designation like ? or 
            EXTRACT( YEAR FROM DATE_SUB(a.yearofgraduation,INTERVAL 4 YEAR)) like ?;";
            
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('sssss', $expr, $expr, $expr, $expr, $expr);
            $stmt->execute();

            $result = $stmt->get_result();
            
            $conn->close();
            if($result->num_rows)
            {
                return $result->fetch_all(MYSQLI_ASSOC);
            }

            return [];
        }
        function getParticularAlumni(string $id):array
        {
            $conn = DBConnection::getConn();
            
            $filter_ids = "select a.alumni_id, a.username, a.company, a.address, 
            EXTRACT( YEAR FROM DATE_SUB(a.yearofgraduation,INTERVAL 4 YEAR)) 'batch_year',
            a.branch, a.designation from ".DBConstants::$ALUMNI_TABLE." a 
            where a.alumni_id= ? ";

            $left_part_gal_post = "select t1.id 't1' ,t2.alumni_id 't2',t1.n_posting, t2.n_imgs from 
            (select id, count(*) 'n_posting' from ".DBConstants::$JOB_POSTING_TABLE." group by id) t1 LEFT JOIN
            (select alumni_id, count(*) 'n_imgs' from ".DBConstants::$GALLERY_TABLE." group by alumni_id) t2 on t1.id = t2.alumni_id";
            
            $right_part_gal_post = "select t1.id 't1' ,t2.alumni_id 't2',t1.n_posting, t2.n_imgs from 
            (select id, count(*) 'n_posting' from ".DBConstants::$JOB_POSTING_TABLE." group by id) t1 RIGHT JOIN
            (select alumni_id, count(*) 'n_imgs' from ".DBConstants::$GALLERY_TABLE." group by alumni_id) t2 on t1.id = t2.alumni_id";

            $gal_post = "($left_part_gal_post UNION $right_part_gal_post) T4";

            $sql = "select T0.*, T4.n_posting, T4.n_imgs from 
            ($filter_ids) T0 
            LEFT JOIN 
            $gal_post on 
            T0.alumni_id = T4.t1 or T0.alumni_id = T4.t2";

            $stmt = $conn->prepare($sql);
            $stmt->bind_param('s', $id);
            $stmt->execute();

            $result = $stmt->get_result();
            
            $conn->close();
            if($result->num_rows)
            {
                return $result->fetch_all(MYSQLI_ASSOC);
            }

            return [];
        }

        function getContactInfo(string $id):array
        {
            $conn = DBConnection::getConn();
            
            $sql = "select phno,email from ".DBConstants::$ALUMNI_TABLE." where alumni_id = ?;";
          
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('s', $id);
            $stmt->execute();
            $result = $stmt->get_result();
            $conn->close();
            
            if($result->num_rows)
                return $result->fetch_assoc();
            // return $result->fetch_all(MYSQLI_ASSOC);
            
            return [];
        }

        function uploadEvent(string $title, string $sdatetime, string $edatetime, string $desc, $file):bool
        {
            $conn = DBConnection::getConn();

            $imgfolder = "../Admin/img/";
            $dest = uniqid($imgfolder);
            $dest .= ".".explode('/',$file['type'])[1];     // file['type']  eg:image/png
            
            $src=$file['tmp_name'];
            $ack = move_uploaded_file($src, $dest);
   
            if($ack)
            {
                $sql = "insert into ".DBConstants::$EVENT_TABLE."(title,description,start_date,end_date,image_url)
                        values(?, ?, ?, ?, ?)";
                
                $stmt = $conn->prepare($sql);
                $stmt->bind_param('sssss', $title, $desc, $sdatetime, $edatetime, $dest);
                $stmt->execute();

                $conn->close();
                return true;
            }
            return false;   
        }

        function getEvents():array
        {
            $conn = DBConnection::getConn();

            $sql = "select * from ".DBConstants::$EVENT_TABLE." where end_date > now()";
            $result = $conn->query($sql);
            $conn->close();
            if($result->num_rows)
            {
                return  $result->fetch_all(MYSQLI_ASSOC);
            }
            return [];

        }

        function deleteEvent(int $event_id):bool
        {
            $conn = DBConnection::getConn();
            
            // delete the post and its related image
            
            $sql = "select image_url from ".DBConstants::$EVENT_TABLE." where event_id = ?";
            
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('s', $event_id);
            $stmt->execute();
            $result = $stmt->get_result();

            if($result->num_rows)
            {
                $img_url = $result->fetch_assoc()['image_url'];
                $ack = unlink($img_url);
                if($ack)
                {
                    $sql = "delete from ".DBConstants::$EVENT_TABLE." where event_id = ?";
                    
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param('s', $event_id);
                    $stmt->execute();

                    $conn->close();
                    return true;
                }
            }
            
            $conn->close();
            return false;
        }
                 
        function getAlumniNames():array
        {
            $conn = DBConnection::getConn();
            $sql = "select username, email from ".DBConstants::$ALUMNI_TABLE." order by username,email";
            $result = $conn->query($sql);
            $conn->close();
            if($result->num_rows > 0)
                return $result->fetch_all(MYSQLI_ASSOC);
            
            return [];
        }

        function postAchievement(string $email, string $desc, $file):bool
        {
            $conn = DBConnection::getConn();
            $sql = "select alumni_id from ".DBConstants::$ALUMNI_TABLE." where email = ?";
            
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('s', $email);
            $stmt->execute();

            $result = $stmt->get_result();
            $alumni_id = $result->fetch_assoc()['alumni_id'];

            $imgfolder = '../Alumni/img/';
            $dest = uniqid($imgfolder); //without the extension of the image
            
            $dest .= ".".explode("/",$file['type'])[1];
            
            // moving the file
            $src=$file['tmp_name'];
            $ack = move_uploaded_file($src, $dest);
            
            if($ack)
            {
                $sql = "insert into ".DBConstants::$CAREER_TABLE."(alumni_id, description, alumni_photo_url) 
                values('$alumni_id', ?, ?)";

                $stmt = $conn->prepare($sql);
                $stmt->bind_param('ss', $desc, $dest);
                $stmt->execute();
                
                $conn->close();

                return true;
            }
            
            return false;
        }

        function deleteAchievement(string $url):bool
        {
            /*
                url is a relative path to the file , ppl say that unlink may have prb with relative path
                as of now it seems to work, but if it doesn't in future, then just try applying the
                sol as suggested in the following link
                https://stackoverflow.com/questions/5006569/php-does-unlink-function-works-with-a-path
            */
            
            $conn = DBConnection::getConn();
            $ack = unlink($url);
            if($ack)
            {
                $sql = "delete from ".DBConstants::$CAREER_TABLE." where alumni_photo_url = ?;";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param('s', $url);
                $stmt->execute();
                
                $conn->close();
                return true;
            }
            return false;
        }

        function getJobPostings(string $val):array
        {
            $conn = DBConnection::getConn();

            $expr = '%'.str_replace("_","%",$val).'%';

            $sql="select job_id, company, type , salary from ".DBConstants::$JOB_POSTING_TABLE." where company like ? or 
            type like ? or description like ?";

            $stmt = $conn->prepare($sql);
            $stmt->bind_param('sss', $expr, $expr, $expr);
            $stmt->execute();

            $result = $stmt->get_result();
            $conn->close();
            if($result->num_rows > 0)
                return $result->fetch_all(MYSQLI_ASSOC);
            
            return [];
        }

        function getStats():array
        {
            $conn = DBConnection::getConn();

            $sql="select ac.n_ach, al.n_alumni, jp.n_posting, e.n_event from (select count(*) 'n_ach' from ".DBConstants::$CAREER_TABLE.") ac,
             (select count(*) 'n_alumni' from ".DBConstants::$ALUMNI_TABLE.") al, 
             (select count(*) 'n_posting' from ".DBConstants::$JOB_POSTING_TABLE.") jp, 
             (select count(*) 'n_event' from ".DBConstants::$EVENT_TABLE.") e";

             $result=$conn->query($sql);
             $conn->close();
             if($result->num_rows)
             {

                 return $result->fetch_assoc();

             }
             return [];

        }
    }

    /*
        select T0.*, T4.n_posting, T4.n_imgs from 

(select a.* from ALUMNI a 
where a.alumni_id in (select alumni_id from ALUMNI where (company like '%hyderabad%' ) or (username like '%hyderabad%') or (address like '%hyderabad%'))) t0

LEFT JOIN 

(select t1.alumni_id 't1' ,t2.alumni_id 't2',t1.n_posting, t2.n_imgs from 
(select alumni_id, count(*) 'n_posting' from JOB_POSTING group by alumni_id) t1 LEFT JOIN
(select alumni_id, count(*) "n_imgs" from GALLERY group by alumni_id) t2 on t1.alumni_id = t2.alumni_id 
UNION
select t1.alumni_id 't1' ,t2.alumni_id 't2',t1.n_posting, t2.n_imgs from 
(select alumni_id, count(*) 'n_posting' from JOB_POSTING group by alumni_id) t1 RIGHT JOIN
(select alumni_id, count(*) "n_imgs" from GALLERY group by alumni_id) t2 on t1.alumni_id = t2.alumni_id) T4

ON

T0.alumni_id = T4.t1 or t0.alumni_id = T4.t2;


    */
?>