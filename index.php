<?php
//if (!isset($_REQUEST)) {return;}
// Строка, которую должен вернуть сервер (См. Callback API->Настройки сервера)
$confirmationToken = '14997d31';
// Ключ доступа сообщества (длинная строчка которую получили нажав "создать ключ")
$token = '0d4e9c0bba882457716f8a05be540a13a19a3741f95a8684b022dcb7d1106a13b290329d1623a9f3aaa2d';
// Секретный ключ. (Задаем в Callback API->Настройки сервера)
$secretKey = 'zdraste123romanlazko';

$data = json_decode(file_get_contents('php://input'),true);
$type = $data['type'];
$user_id = $data['object']['user_id'];
$text = $data['object']['body'];
$userInfo = json_decode(file_get_contents("https://api.vk.com/method/users.get?user_ids=".$user_id."&access_token=".$token."&v=5.8"),true);
$user_name = $userInfo['response'][0]['first_name'];
$keyboard = [ 
    'one_time' => true, 
    'buttons' => [[
        ['action' =>['type' => 'text', 
                     'payload' => '{"button": "1"}',
                     'label' => 'Проверить почту', 
                    ],
        'color' => 'negative',],

        
    ],],
]; 
$Name = substr($text, 0, strrpos($text, ','));
$str = substr($Name, 0, strrpos($text, ':'));
$N = substr($Name, strrpos($Name,":")+1);
$Lastname = substr($text, strrpos($text,",")+1);
$L = substr($Lastname, strrpos($Lastname,":")+1);

if($type == 'message_new'){
    if($text =='Начать') {
        $reply = "Привет, ".$user_name;
        sendKeyboard($token,$user_id,$reply,$keyboard);
    }elseif($text =='Проверить почту') {
        $reply = $user_name. ", что бы проверить почту, отправь мне свое имя и фамилию по паспорту в формате\n
        'N: ИМЯ, L: ФАМИЛИЯ'\n
        Важно!\n
        Данные должны быть написанны:
        Латиницей,
        Большими буквами,
        Не забудь спользовать идентификаторы 'N:' и 'L:'
        ";
        sendMessage($token,$user_id,$reply);
    } 
    elseif($str=='N'){
        
        $reply = "Имя ".$N."\nФамилия ".$L;
        sendKeyboard($token,$user_id,$reply,$keyboard);
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
?>
