<?php
// $user_id = 113601869;
// $request_params = array(
// 'user_id' => $user_id,
// 'v' => '5.52',
// 'access_token' => '0d4e9c0bba882457716f8a05be540a13a19a3741f95a8684b022dcb7d1106a13b290329d1623a9f3aaa2d'
// );

$token = '0d4e9c0bba882457716f8a05be540a13a19a3741f95a8684b022dcb7d1106a13b290329d1623a9f3aaa2d';
$pool_data = json_decode(file_get_contents("https://api.vk.com/method/messages.getLongPollServer?access_token=" . $token."&v=5.8"));
$pool = [
    "key" => $pool_data->response->key,
    "server" => $pool_data->response->server,
    "ts" => $pool_data->response->ts
];
//while($item[0] !='4'){
$request = json_decode(file_get_contents("https://" . $pool['server'] . "?act=a_check&key=" . $pool['key'] . "&ts=" . $pool['ts'] . "&wait=25&mode=2&version=2"));
// $item = $request->updates;
// if ($item[0] == "4") {
//         echo $item[5];
//     break;
//     }
// }
foreach ($request->updates as $item) {
//     switch ($item[0]) {
//     case 61:
//         echo "Пишет";
//     case 4:
//         echo "Написал:" . $item[5];
        
// // }
    if ($item[0] == "61") {
        //array_push($log, "Юзверь с ID:" . $item[1] . " набирает текст");
        echo 'Write';
    }
    if ($item[0] == "4") {
        echo $item[5];
    }
}
?>
