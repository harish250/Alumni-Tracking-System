<?php
require_once('DBConnection.php');

    class Admin
    {
        function searchAlumni(string $val):array
        {
            $conn = DBConnection::getConn();
            $sql = "select a.alumni_id, a.username, a.company, EXTRACT( YEAR FROM DATE_SUB(a.yearofgraduation,INTERVAL 4 YEAR)) 'batch_year', a.designation from ".DBConstants::$ALUMNI_TABLE." a 
            where username like '%$val%' or company like '%$val%' or branch like '%$val%' or designation like '%$val%' or 
            EXTRACT( YEAR FROM DATE_SUB(a.yearofgraduation,INTERVAL 4 YEAR)) like '%$val%';
            ";
            $result = $conn->query($sql);
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
            where a.alumni_id= '$id' ";

            $left_part_gal_post = "select t1.alumni_id 't1' ,t2.alumni_id 't2',t1.n_posting, t2.n_imgs from 
            (select alumni_id, count(*) 'n_posting' from ".DBConstants::$JOB_POSTING_TABLE." group by alumni_id) t1 LEFT JOIN
            (select alumni_id, count(*) 'n_imgs' from ".DBConstants::$GALLERY_TABLE." group by alumni_id) t2 on t1.alumni_id = t2.alumni_id
            ";
            
            $right_part_gal_post = "select t1.alumni_id 't1' ,t2.alumni_id 't2',t1.n_posting, t2.n_imgs from 
            (select alumni_id, count(*) 'n_posting' from ".DBConstants::$JOB_POSTING_TABLE." group by alumni_id) t1 RIGHT JOIN
            (select alumni_id, count(*) 'n_imgs' from ".DBConstants::$GALLERY_TABLE." group by alumni_id) t2 on t1.alumni_id = t2.alumni_id";

            $gal_post = "($left_part_gal_post UNION $right_part_gal_post) T4";

            $sql = "select T0.*, T4.n_posting, T4.n_imgs from 
            ($filter_ids) T0 
            LEFT JOIN 
            $gal_post on 
            T0.alumni_id = T4.t1 or T0.alumni_id = T4.t2";

            $result = $conn->query($sql);
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
            
            $sql = "select phno,email from ".DBConstants::$ALUMNI_TABLE." where alumni_id = '$id';";

            $result = $conn->query($sql);

            $conn->close();

            if($result->num_rows)
                return $result->fetch_all(MYSQLI_ASSOC);
            
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
                        values('$title','$desc','$sdatetime','$edatetime','$dest')";    
                $conn->query($sql);
                return true;
            }
            return false;   
        }

        function getEvents():array
        {
            $conn = DBConnection::getConn();

            $sql = "select * from ".DBConstants::$EVENT_TABLE." where end_date > now()";
            $result = $conn->query($sql);
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
            
            $sql = "select image_url from ".DBConstants::$EVENT_TABLE." where event_id = $event_id";
            
            $result = $conn->query($sql);
            if($result->num_rows)
            {
                $img_url = $result->fetch_assoc()['image_url'];
                $ack = unlink($img_url);
                if($ack)
                {
                    $sql = "delete from ".DBConstants::$EVENT_TABLE." where event_id = $event_id";
                    $conn->query($sql);
                    return true;
                }
            }
            return false;
        }
                 
        function getAlumniNames():array
        {
            $conn = DBConnection::getConn();
            $sql = "select username, email from ".DBConstants::$ALUMNI_TABLE." order by username,email";
            $result = $conn->query($sql);

            if($result->num_rows > 0)
                return $result->fetch_all(MYSQLI_ASSOC);
            
            return [];
        }

        function postAchievement(string $email, string $desc, $file):bool
        {
            $conn = DBConnection::getConn();
            $sql = "select alumni_id from ".DBConstants::$ALUMNI_TABLE." where email='$email'";
            
            $result = $conn->query($sql);
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
                values('$alumni_id', '$desc','$dest')";
                $conn->query($sql);
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
                $sql = "delete from ".DBConstants::$CAREER_TABLE." where alumni_photo_url = '$url';";
                $conn->query($sql);
                return true;
            }
            return false;
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