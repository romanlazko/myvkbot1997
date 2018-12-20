<?php
$token = "7afee784da63ce8f1f5359132ec25a4cb1e6e6d2729cb5b4e7aae83cc627056051962f4449489cbff9750";
$LongPoll = curl("https://api.vk.com/method/messages.getLongPollServer?access_token=".$token);  
$server = $LongPoll["response"]["server"];
$key = $LongPoll["response"]["key"];
$LongPoll = curl("http://".$server."?act=a_check&key=".$key."&ts=".$LongPoll["response"]["ts"]."&wait=1&mode=2");
while ( true )  {
	$LongPoll = curl("http://".$server."?act=a_check&key=".$key."&ts=".$LongPoll["ts"]."&wait=25&mode=2");
	if( preg_match("/^напомни (.*) в (.*)/ui" , $LongPoll["updates"][0][6] , $matches ) ){ 
		if (preg_match("/^([0-1][0-9]|[2][0-3]):([0-5][0-9])$/", $matches[2] )){ 
			send("Запомнил! :)",$LongPoll["updates"][0][3]);
			$reminders[$n] = array( "text" => $matches[1] , "time" => $matches[2] , "uid" => $LongPoll["updates"][0][3]); 
			$n++;
		}
		else {
			send( "Неверный формат времени" , $LongPoll["updates"][0][3] );
		}
	}
	for ($i=0; $i < count($reminders) ; $i++) { 
		if ($reminders[$i]["time"] == date('H:i') || $reminders[$i]["time"] == date('H:i+1')) { 
			send ("Напоминаю ".$reminders[$i]["text"] , $reminders[$i]["uid"]);
		}
	}
}
function send( $message , $uid ) {
	global $token ;
	curl("https://api.vk.com/method/messages.send?access_token=".$token."&message=".urlencode($message)."&uid=".$uid);
}
function curl( $url ) {
	$ch = curl_init( $url );
	curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
	curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, false );
	curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
	$response = curl_exec( $ch );
	curl_close( $ch );
	return json_decode($response , true);
}
?>
