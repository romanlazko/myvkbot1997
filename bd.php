<?php
function name($token,$user_id){ 
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
        $insertname = $dbconnect->query("INSERT INTO vkbot(user_id,disen,name,surname) VALUES('$user_id','1','1','1')");
        if($insertname){
            $reply = ", что бы проверить почту, отправь мне свое имя и фамилию по паспорту";
            sendMessage($token,$user_id,$reply);
        }
    }else{
        $insertname = $dbconnect->query("UPDATE `vkbot` SET `disen`='1' WHERE `user_id`='user_id'");
        if($insertname){
            $reply = ", что бы проверить почту, отправь мне свое имя и фамилию по паспорту";
            sendMessage($token,$user_id,$reply);
        }
    }
        
}
?>
