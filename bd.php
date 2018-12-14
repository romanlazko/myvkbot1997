<?php
$orderInsert = "INSERT INTO order_id(user_id,id,order_text,order_time) VALUES('$user_id','$id','$pos_id','$order_time')";            
        if($dbconnect->query($orderInsert) === TRUE){
            $reply_restoran = "Стол: ".$table."\nЗаказ: ".$pos_id."\nКоличество: ".$pos_name; 
            inlineKeyboard($restoran,$chat_id,$reply_restoran,confirm($table,$pos_name,$pos_id));
        }
?>
