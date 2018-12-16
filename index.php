<?php
$servername="db4free.net: 3306";
$username="romanlazko";
$password="zdraste123";
$dbname="promocoder1";
$dbconnect = new mysqli($servername, $username, $password, $dbname);
function name($token,$user_id,$reply,$dbconnect){ 
    $result = $dbconnect->query("SELECT user_id FROM vkbot");    
    while($row = $result->fetch_assoc()){        
        if($row['user_id']==$user_id){
            $new_id = false;
            break;
        }
    }   
    if($new_id !== false){
        $insertname = $dbconnect->query("INSERT INTO vkbot(user_id,disen) VALUES('$user_id','1')");
    }
    else{
        $updatename = $dbconnect->query("UPDATE `vkbot` SET `disen`='1' WHERE `user_id`='$user_id'");
    }
}
function setdisen($user_id,$dbconnect){ 
    
    $result1 = $dbconnect->query("SELECT disen FROM vkbot WHERE user_id='$user_id'");    
    while($row = $result1->fetch_assoc()){        
        if($row['disen']=='1'){
            $updatename1 = $dbconnect->query("UPDATE `vkbot` SET `disen`='0' WHERE `user_id`='$user_id'");
            return true;
            break;
        }
        else{
            return false;
            break;
        }
    }   
}
$confirmationToken = '14997d31';
$token = '0d4e9c0bba882457716f8a05be540a13a19a3741f95a8684b022dcb7d1106a13b290329d1623a9f3aaa2d';
$secretKey = 'zdraste123romanlazko';
$data = json_decode(file_get_contents('php://input'),true);
$type = $data['type'];
$user_id = $data['object']['user_id'];
$text = $data['object']['body'];
$userInfo = json_decode(file_get_contents("https://api.vk.com/method/users.get?user_ids=".$user_id."&access_token=".$token."&v=5.8"),true);
$user_name = $userInfo['response'][0]['first_name'];
// sendMessage($token,$user_id,$type);
if($type == 'message_reply'){
    if($text =='send') {
        name($token,$user_id,$reply,$dbconnect);
    }
}
if($type == 'message_new'){
    if($text =='Начать') {
        $reply = "Привет, ".$user_name;
        $keyboard = [ 
            'one_time' => true, 
            'buttons' => keyboard("1",'Проверить почту','positive')
        ];
        sendKeyboard($token,$user_id,$reply,$keyboard);
    }elseif($text =='Проверить почту') {
            sendMessage($token,$user_id,'send');
    }else{
        if(setdisen($user_id,$dbconnect)===true){
            sendMessage($token,$user_id,'проверка');
        }else{
            $reply="Прости, я не понимаю ".$text. ")
            \nПопробуй еще раз!";
            $keyboard = [ 
                'one_time' => true, 
                'buttons' => keyboard("1",'Начать','positive')
            ];
            sendKeyboard($token,$user_id,$reply,$keyboard);
        }
    }
}
function sendKeyboard($token,$user_id,$reply,$keyboard){
    $request_params = array(
        'message' => $reply,
        'user_id' => $user_id,
        'access_token' => $token,
        'keyboard'=>json_encode($keyboard, JSON_UNESCAPED_UNICODE),
        'v' => '5.8'
    );
    file_get_contents('https://api.vk.com/method/messages.send?'. http_build_query($request_params));
    echo('ok'); 
}
function sendMessage($token,$user_id,$reply){
    $request_params = array(
        'message' => $reply,
        'user_id' => $user_id,
        'access_token' => $token,
        'v' => '5.8'
    );
    file_get_contents('https://api.vk.com/method/messages.send?'. http_build_query($request_params));
    echo('ok'); 
}
function keyboard($par,$name_btn,$color){
    $key = [[
        ['action' =>['type' => 'text', 
                     'payload' => '{"button": '.$par.'}',
                     'label' => $name_btn, 
                    ],
        'color' => $color]
        
    ]];
    return $key;
}
//     elseif($rest==':'){
//         $text = str_replace(' ','',$text);
//         $Name = substr($text, 0, strrpos($text, ','));
//         $N = substr($Name, strrpos($Name,":")+1);
//         $Lastname = substr($text, strrpos($text,",")+1);
//         $L = substr($Lastname, strrpos($Lastname,":")+1);
//         //https://www.mvcr.cz/clanek/verejna-vyhlaska-oznameni-o-moznosti-prevzit-pisemnost-zaleskiy-gleb.aspx
//         $url = "https://www.mvcr.cz/clanek/verejna-vyhlaska-oznameni-o-moznosti-prevzit-pisemnost-".$L."-".$N.".aspx";
//         //$url = "https://www.mvcr.cz/soubor/".$L."-".$N."-pdf.aspx";
//         $url1 ="https://www.mvcr.cz/clanek/verejne-vyhlasky-oamp-verejna-vyhlaska-oznameni-o-moznosti-prevzit-pisemnost-".$L."-".$N.".aspx";
//         $urlHeaders = @get_headers($url);
//         $urlHeaders1 = @get_headers($url1);
//         $keyboard = [ 
//             'one_time' => true, 
//             'buttons' => keyboard("1",'Начать','positive')
//         ];
        
//         if(strpos($urlHeaders[0], '200')) {
//             sendKeyboard($token,$user_id,$url,$keyboard);
//         } elseif(strpos($urlHeaders1[0], '200')) {
//              sendKeyboard($token,$user_id,$url1,$keyboard);
//         } else{
//             sendKeyboard($token,$user_id,'Нет ссылки',$keyboard);
//         }
        
//         //sendKeyboard($token,$user_id,$reply,$keyboard);
//     }
return false;
?>
