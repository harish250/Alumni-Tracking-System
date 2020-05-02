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

            $insert_stmt = $conn->prepare("insert into ".DBConstants::$EVENT_TABLE."(title,description,start_date,end_date,image_url) values('$title','$desc','$sdatetime','$edatetime',?)");

            $del_stmt = $conn->prepare("delete from ".DBConstants::$EVENT_TABLE." where image_url = ?");

            $imgfolder = "img/";
            $dest = uniqid($imgfolder);
            $dest .= ".".explode('/',$file['type'])[1];     // file['type']  eg:image/png

            $insert_stmt->bind_param('s',$dest);

            $ack = $insert_stmt->execute();
            echo "insert: ",$ack;
            if($ack)
            {
                $src=$file['tmp_name'];
                $ack = move_uploaded_file($src, $dest);
                echo "move: ",$ack;

                if(!$ack)
                {
                    $del_stmt->bind_param('s',$dest);
                    $del_stmt->execute();
                    return false;
                }

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