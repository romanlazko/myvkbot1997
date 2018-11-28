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
$userId = $data['object']['from_id'];
$text = $data['object']['text'];
$userInfo = json_decode(file_get_contents("https://api.vk.com/method/users.get?user_ids=".$userId."&access_token=".$token."&v=5.8"),true);
$user_name = $userInfo['response'][0]['first_name'];

switch ($type) {

    case 'message_new':
        $keyboard = [ 
        'one_time' => false, 
        'buttons' => [
            [
              ['action' => ['type' => 'text', 'payload' => '{"button": "1"}', 'label' => 'Red',], 'color' => 'negative',],
            ], 
        ];  
 
            
        
        $request_params = array(
            'message' => 'привет,'.$user_name."Твое сообщение: ".$text,
            'user_id' => $userId,
            'access_token' => $token,
            'keyboard'=>json_encode($keyboard),
            'v' => '5.8'
        );
        file_get_contents('https://api.vk.com/method/messages.send?'. http_build_query($request_params));
        echo('ok'); // Возвращаем "ok" серверу Callback API
        break;
}

?>
