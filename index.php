<?php
if (!isset($_REQUEST)) {return;}
// Строка, которую должен вернуть сервер (См. Callback API->Настройки сервера)
$confirmationToken = '14997d31';
// Ключ доступа сообщества (длинная строчка которую получили нажав "создать ключ")
$token = '0d4e9c0bba882457716f8a05be540a13a19a3741f95a8684b022dcb7d1106a13b290329d1623a9f3aaa2d';
// Секретный ключ. (Задаем в Callback API->Настройки сервера)
$secretKey = 'zdraste123romanlazko';

$data = json_decode(file_get_contents('php://input'));
// проверяем secretKey
if (strcmp($data->secret, $secretKey) !== 0 && strcmp($data->type, 'confirmation') !== 0) {return;}
//$type = $data['type'];
// Проверяем, что находится в поле "type"
switch ($data->type) {
// Запрос для подтверждения адреса сервера (посылает ВК)
    case 'confirmation':
        echo $confirmationToken; // отправляем строку для подтверждения адреса
        break;
    // Если это уведомление о новом сообщении...
    case 'message_new':
        // получаем id автора сообщения
        $userId = $data->object->user_id;
        // через users.get получаем данные об авторе
        //$userInfo = json_decode(file_get_contents("https://api.vk.com/method/users.get?user_ids={$userId}&v=5.0"));
        // Вытаскиваем имя отправителя
        //$user_name = $data['object']['first_name'];
        // Через messages.send используя токен сообщества отправляем ответ
        $request_params = array(
            'message' => 'привет',
            'user_id' => $userId,
            'access_token' => $token,
            'v' => '5.0'
        );
        $get_params = http_build_query($request_params);
        file_get_contents('https://api.vk.com/method/messages.send?'. $get_params);
        echo $data;
        echo('ok'); // Возвращаем "ok" серверу Callback API
        break;
}

?>
