<?php
if (!isset($_REQUEST)) { 
return; 
}
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
        $insertname = $dbconnect->query("INSERT INTO vkbot(user_id,disen) VALUES('$user_id','1')");
    }
    else{
        $updatename = $dbconnect->query("UPDATE `vkbot` SET `disen`='1' WHERE `user_id`='$user_id'");
    }
    $dbconnect->close();
}
function setdisen($user_id){ 
    $servername="db4free.net: 3306";
    $username="romanlazko";
    $password="zdraste123";
    $dbname="promocoder1";
    $dbconnect = new mysqli($servername, $username, $password, $dbname);
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
    $dbconnect->close();
    
}
function update_file($file_url){ 
    $servername="db4free.net: 3306";
    $username="romanlazko";
    $password="zdraste123";
    $dbname="promocoder1";
    $dbconnect = new mysqli($servername, $username, $password, $dbname);
    $update_file = $dbconnect->query("UPDATE `filevisa` SET `file_url`='$file_url' WHERE 1");
    $dbconnect->close();
    
}
function select_file(){ 
    $servername="db4free.net: 3306";
    $username="romanlazko";
    $password="zdraste123";
    $dbname="promocoder1";
    $dbconnect = new mysqli($servername, $username, $password, $dbname);
    $select_file = $dbconnect->query("SELECT file_url FROM `filevisa` WHERE newid= '1'");
    while($row = $select_file->fetch_assoc()){        
        return $row['file_url'];
        break;
    } 
    $dbconnect->close();
    
}
$confirmationToken = '14997d31';
$token = '70ed1287bd3708989487a43bdab2b33909b25028eb1318564ff268be9c92fd2a83413ea7e369d6c8159e7';
$secretKey = 'zdraste123romanlazko';
$data = json_decode(file_get_contents('php://input'),true);
$type = $data['type'];
$user_id = $data['object']['user_id'];
$text = $data['object']['body'];
$file = $data['object']['attachments'][0]['type'];
$file_format = $data['object']['attachments'][0]['doc']['ext'];
$file_url = $data['object']['attachments'][0]['doc']['url'];
$userInfo = json_decode(file_get_contents("https://api.vk.com/method/users.get?user_ids=".$user_id."&access_token=".$token."&v=5.8"),true);
$user_name = $userInfo['response'][0]['first_name'];
// sendMessage($token,$user_id,$type);
if($type == 'message_reply'){
    if($text ==$user_name.', отправь мне свои Фимилию и Имя что бы проверить почту.
        Сначала Фамилия и через пробел Имя.') {
        name($token,$user_id,$reply);
    }
//     header("HTTP/1.1 200 OK");
//     echo('ok'); 
}
if($type == 'confirmation'){
    echo $confirmationToken;
}
if($type == 'message_new'){
    if($file == 'doc' ){
        if($file_format == 'csv'){
            update_file(stristr($file_url, '?', true));
            sendMessage($token,$user_id,'ok');
        }else{
            sendMessage($token,$user_id,'Файл должен быть в формате CSV');
        }
    }
    if($text =='Начать') {
        $reply = "Привет, ".$user_name;
        $keyboard = [ 
            'one_time' => true, 
            'buttons' => keyboard("1",'Проверить почту','positive')
        ];
        sendKeyboard($token,$user_id,$reply,$keyboard);
    }elseif($text =='Проверить почту') {
        $reply = $user_name.', отправь мне свои Фимилию и Имя что бы проверить почту.
        Сначала Фамилия и через пробел Имя.';
            sendMessage($token,$user_id,$reply);
    }elseif($text =='Проверить визу'){
        sendMessage($token,$user_id,select_file());
    }
    else{
//         if(setdisen($user_id)===true){
//             $text = str_replace(' ','-',$text);
//             $url = "https://www.mvcr.cz/clanek/verejna-vyhlaska-oznameni-o-moznosti-prevzit-pisemnost-".$text.".aspx";
            
//             $url1 ="https://www.mvcr.cz/clanek/verejne-vyhlasky-oamp-verejna-vyhlaska-oznameni-o-moznosti-prevzit-pisemnost-".$text.".aspx";
//             $urlHeaders = @get_headers($url);
//             $urlHeaders1 = @get_headers($url1);
//             $keyboard = [ 
//                 'one_time' => true, 
//                 'buttons' => keyboard("1",'Начать','positive')
//             ];

//             if(strpos($urlHeaders[0], '200')) {
//                 sendKeyboard($token,$user_id,$url,$keyboard);
//             } elseif(strpos($urlHeaders1[0], '200')) {
//                  sendKeyboard($token,$user_id,$url1,$keyboard);
//             } else{
//                 sendKeyboard($token,$user_id,'Нет ссылки',$keyboard);
//             }
//             //sendMessage($token,$user_id,'проверка');
//         }else{
//             $reply="Прости, я не понимаю ".$text. ")
//             \nПопробуй еще раз!";
//             $keyboard = [ 
//                 'one_time' => true, 
//                 'buttons' => keyboard("1",'Начать','positive')
//             ];
//             sendKeyboard($token,$user_id,$reply,$keyboard);
//         }
    }
}
function sendKeyboard($token,$user_id,$reply,$keyboard){
    $request_params = array(
        'message' => $reply,
        'user_id' => $user_id,
        'access_token' => $token,
        'read_state' => 1,
        'keyboard'=>json_encode($keyboard, JSON_UNESCAPED_UNICODE),
        'v' => '5.8'
    );
    file_get_contents('https://api.vk.com/method/messages.send?'. http_build_query($request_params));
    header("HTTP/1.1 200 OK");
    echo('ok'); 
}
function sendMessage($token,$user_id,$reply){
    $request_params = array(
        'message' => $reply,
        'user_id' => $user_id,
        'read_state' => 1,
        'access_token' => $token,
        'v' => '5.8'
    );
    file_get_contents('https://api.vk.com/method/messages.send?'. http_build_query($request_params));
    header("HTTP/1.1 200 OK");
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


?>
