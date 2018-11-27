<?php
$user_id = 113601869;
$request_params = array(
'user_id' => $user_id,
'fields' => 'bdate',
'v' => '5.8',
'access_token' => '0d4e9c0bba882457716f8a05be540a13a19a3741f95a8684b022dcb7d1106a13b290329d1623a9f3aaa2d'
);
$get_params = http_build_query($request_params);
$result = json_decode(file_get_contents('https://api.vk.com/method/users.get?'. $get_params));
echo($result -> response[0] -> bdate);
?>
