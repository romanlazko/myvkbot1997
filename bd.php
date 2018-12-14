<?php
function name($token,$user_id,$reply){ 
    $servername="db4free.net: 3306";
    $username="romanlazko";
    $password="zdraste123";    
    $dbname="promocoder1";
    $dbconnect = new mysqli($servername, $username, $password, $dbname);
    $result = $dbconnect->query("SELECT user_id FROM vkbot");    
    while($row = $result->fetch_assoc()){        
        if($row['user_id']==$user_id){
            $new_id = false;
            break;
        }
        
    }   
    if($new_id !== false){
        $insertname = "INSERT INTO vkbot(user_id,disen,name,surname) VALUES('$user_id','1','1','1')";
        if($dbconnect->query($insertname)===TRUE){
            sendMessage($token,$user_id,$reply);
        }
    }else{
        $updatename = "UPDATE `vkbot` SET `disen`='2' WHERE `user_id`='$user_id'";
        if($dbconnect->query($updatename)===TRUE){
            sendMessage($token,$user_id,$reply);
        }
    }
        
}
?>
