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
            $dbconnect->close();
        }
    }else{
        $updatename = "UPDATE `vkbot` SET `disen`='1' WHERE `user_id`='$user_id'";
        if($dbconnect->query($updatename)===TRUE){
            sendMessage($token,$user_id,$reply);
            $dbconnect->close();
        }
    }
    
        
}
function setdisen($user_id){ 
    $servername="db4free.net: 3306";
    $username="romanlazko";
    $password="zdraste123";    
    $dbname="promocoder1";
    $dbconnect = new mysqli($servername, $username, $password, $dbname);
    $result = $dbconnect->query("SELECT disen FROM vkbot WHERE user_id='$user_id'");    
    while($row = $result->fetch_assoc()){        
        if($row['disen']==1){
            $updatename = $dbconnect->query("UPDATE `vkbot` SET `disen`='0' WHERE `user_id`='$user_id'");
            return true;
            break;
        }
        
    }   
    $dbconnect->close();
}
?>
