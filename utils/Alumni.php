<?php
require_once('DBConnection.php');

class Alumni
{
    public function getJobPostings(string $id = 'all'):array
    {
        $conn = DBConnection::getConn();
        $sql = "select company, type, salary, description, date_posted from ".DBConstants::$JOB_POSTING_TABLE;
    
        $condition = ($id == 'all')?'':" where alumni_id = '$id'";
        
        $sql .= $condition;
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
        (username= '$username' or alumni_id = '$username') and password = '$password'";

        $result = $conn->query($sql);
        $conn->close();
        
        if($result->num_rows > 0)
            return $result->fetch_assoc();
        
        return [];
    }

    public function getAchievements():array
    {
        $conn = DBConnection::getConn();

        $sql = "select a.username 'alumni_name', c.achievement_desc 'desc', c.alumni_photo_url 'url' 
        from ".DBConstants::$CAREER_TABLE.' c, '.DBConstants::$ALUMNI_TABLE.' a where a.alumni_id = c.alumni_id;';

        $result = $conn->query($sql);
        $conn->close();
        
        if($result->num_rows > 0)
            return $result->fetch_all(MYSQLI_ASSOC);
        
        return [];
    }
}
?>
