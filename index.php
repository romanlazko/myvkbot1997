<?php
$servername="78.108.80.117";
    $username="u178949_vkbot";
    $password="123456";
    $dbname="b178949_vkbot";
    $dbconnect = new mysqli($servername, $username, $password, $dbname);
if (!isset($_REQUEST)) { 
return; 
}
function name($user_id,$first_name,$last_name,$disen){ 
    
    global $dbconnect;
    $result = $dbconnect->query("SELECT user_id FROM 8marta");    
    while($row = $result->fetch_assoc()){        
        if($row['user_id']==$user_id){
            $new_id = false;
            break;
        }
    }   
    if($new_id !== false){
        $insertname = $dbconnect->query("INSERT INTO 8marta(user_id,disen,last_name,first_name,visanum,visacontrol) VALUES('$user_id','$disen','$last_name','$first_name','1','1')");
    }
    else{
        $updatename = $dbconnect->query("UPDATE `8marta` SET `disen`='$disen' WHERE `user_id`='$user_id'");
    }
}
function namestrach($user_id,$text,$param){ 
    global $dbconnect;
    $result = $dbconnect->query("SELECT user_id FROM strach");    
    while($row = $result->fetch_assoc()){        
        if($row['user_id']==$user_id){
            $new_id = false;
            break;
        }
    }   
    if($new_id !== false){
        $insertname = $dbconnect->query("INSERT INTO strach(user_id,first_last,pas,tel,adres,birth,srok,beginstrach) VALUES('$user_id',' ',' ',' ',' ',' ',' ',' ')");
    }
    else{
        if($text!=='0'){
        $updatename = $dbconnect->query("UPDATE `strach` SET `$param`='$text' WHERE `user_id`='$user_id'");}
    }
}
function selectstrach($user_id){ 
    global $dbconnect;
    $result = $dbconnect->query("SELECT first_last,pas,tel,adres,birth,srok,beginstrach FROM strach WHERE user_id='$user_id'");    
    while($row = $result->fetch_assoc()){        
        return $row;
    }
}
function setdisen($user_id){ 
    global $dbconnect;
    $result1 = $dbconnect->query("SELECT disen FROM 8marta WHERE user_id='$user_id'");    
    while($row = $result1->fetch_assoc()){
        if($row['disen']!==0){
            $updatename1 = $dbconnect->query("UPDATE `8marta` SET `disen`='0' WHERE `user_id`='$user_id'");
            return $row['disen'];
        }        
        
    }   
}
function update_file($file_url,$token,$user_id,$newid){ 
    global $dbconnect;
    $update_file = $dbconnect->query("UPDATE `filevisa` SET `file_url`='$file_url' WHERE `newid` = '$newid'");
    sendMessage($token,$user_id,'ok');   
}
function select_file($newid){ 
    global $dbconnect;
    $select_file = $dbconnect->query("SELECT file_url FROM `filevisa` WHERE newid= '$newid'");
    while($row = $select_file->fetch_assoc()){        
        return $row['file_url'];
        break;
    } 
}
function visasave($text,$user_id){
    global $dbconnect;
    $result = $dbconnect->query("SELECT user_id FROM 8marta");    
    while($row = $result->fetch_assoc()){        
        if($row['user_id']==$user_id){
            $new_id = false;
            break;
        }
    }   
    if($new_id !== false){
        $insertname = $dbconnect->query("INSERT INTO 8marta(visanum,visacontrol) VALUES('$text','0')");
    }
    else{
        $updatename = $dbconnect->query("UPDATE `8marta` SET `visanum`='$text' WHERE `user_id`='$user_id'");
    }
}
function visacontrol($user_id,$visacontrol){
    global $dbconnect;
    $updatevisa = $dbconnect->query("UPDATE `8marta` SET `visacontrol`='$visacontrol' WHERE `user_id`='$user_id'");
    
}

$confirmationToken = '14997d31';
$token = '70ed1287bd3708989487a43bdab2b33909b25028eb1318564ff268be9c92fd2a83413ea7e369d6c8159e7';//'70ed1287bd3708989487a43bdab2b33909b25028eb1318564ff268be9c92fd2a83413ea7e369d6c8159e7';
$secretKey = 'zdraste123romanlazko';
$data = json_decode(file_get_contents('php://input'),true);
$type = $data['type'];
$user_id = $data['object']['user_id'];
$text = $data['object']['body'];
$button = $data['object']['payload'];
$userInfo = json_decode(file_get_contents("https://api.vk.com/method/users.get?user_ids=".$user_id."&access_token=".$token."&v=5.78"),true);
$first_name = $userInfo['response'][0]['first_name'];
$last_name = $userInfo['response'][0]['last_name'];
$setdisen = setdisen($user_id);
if($type == 'confirmation'){
    echo $confirmationToken;
}

if($type == 'message_new'){
    if(isset($data['object']['fwd_messages'])){
        $reply = 'Я не понимаю пересланные сообщения, пожалуйста, напишите сообщение заново.';
        sendMessage($token,$user_id,$reply);
    }
    elseif($text == "Начать"  or $text=="Але"  or $text== "Хелло"  or $text=="Назад"  or $text== "начать") {
        
        $reply ="Привет, ".$first_name."!\n
Я бот, который поможет Вам проверить, готова ли Ваша виза. 

Чтобы продолжить, нажмите на 'Проверить визу', и следуйте подсказкам.";
        $keyboard = [ 
            'one_time' => true, 
            'buttons' => [[keyboard('1',  "Проверить визу" ,'positive')],[keyboard('15',"Страхование",'positive')],[keyboard('3',"Настройки"  ,'positive')]]
        ];
        sendKeyboard($token,$user_id,$reply,$keyboard);
    }elseif($text == "Проверить визу" ){
        
        name($user_id,$first_name,$last_name,2);
        $reply = $first_name.', отправьте мне номер своего заявления чтобы проверить готова ли Ваша виза.

Пример: 
Если номер Вашего заявления OAM-22043-1/PP-2018, Вам достаточно написать 22043/PP-2018. Результат будет выглядеть так: OAM-22043/PP-2018.

Важно! 

Все символы должны быть написаны латиницей!

Если мне удастся найти номер, то это означает, что Ваша виза была одобрена.';
        sendMessage($token,$user_id,$reply);
       
    }elseif($text =='dobrydenmisterbrown'){
        
        name($user_id,$first_name,$last_name,3);
        sendMessage($token,$user_id,'Wait file');

    }elseif($text =="Страхование"){
        $reply = "Что бы Вы хотели узнать о страховании?";
        $keyboard = [ 
            'one_time' => true, 
            'buttons' => [[keyboard('4',"Заказать страховку" ,'positive')],[keyboard('5', "Возврат средств" ,'positive')],[keyboard('6', "Назад" ,'positive')]]
        ];
        sendKeyboard($token,$user_id,$reply,$keyboard);
    
    }elseif($text =="Подтвердить заказ" ){
        $reply = "Каким образом Вы бы хотели оплатить страховку? 
Мы предлагаем Вам бесплатную доставку на дом.";
        $keyboard = [ 
            'one_time' => true, 
            'buttons' => [[keyboard('7',"Курьеру наличными" ,'positive')],[keyboard('8',"Курьеру картой" ,'positive')],[keyboard('16', "Назад" ,'positive')]]
        ];
        sendKeyboard($token,$user_id,$reply,$keyboard);

    
    }elseif($text =="Исправить"){
        $color = 'positive';
        $reply = "Нажимая на кнопки, пишите свои данные.";
        $keyboard = [ 
                'one_time' => false, 
                'buttons' => [[keyboard('22',"Имя и Фамилия: ".selectstrach($user_id)['first_last'], $color)],[keyboard('23',"Дата рождения: ".selectstrach($user_id)['birth']  ,$color)]
                             ,[keyboard('24',"Номер паспорта: ".selectstrach($user_id)['pas'] ,$color)],[keyboard('25',"Номер телефона: ".selectstrach($user_id)['tel'] ,$color)]
                             ,[keyboard('26', "Адрес проживания: ".selectstrach($user_id)['adres'] ,$color)],[keyboard('27', "Дата начала: ".selectstrach($user_id)['beginstrach'] ,$color)]
                             ,[keyboard('17', "Продолжить" ,'positive')],[keyboard('16', "Назад" ,'negative')]
                             ]
            ];
        sendKeyboard($token,$user_id,$reply,$keyboard);
    
    


    }elseif($text =="Продолжить"){
        if(selectstrach($user_id)['first_last']===' '){
            $reply = "Напишите имя";
            sendMessage($token,$user_id,$reply);
            name($user_id,$first_name,$last_name,4);
        }elseif(selectstrach($user_id)['birth']===' '){
            $reply = "Напишите дату своего рождения";
            sendMessage($token,$user_id,$reply);
            name($user_id,$first_name,$last_name,5);
        }elseif(selectstrach($user_id)['pas']===' '){
            $reply = "Напишите номер своего паспорта";
            sendMessage($token,$user_id,$reply);
            name($user_id,$first_name,$last_name,6);
        }elseif(selectstrach($user_id)['tel']===' '){
            $reply = "Напишите номер своего телефона";
            sendMessage($token,$user_id,$reply);
            name($user_id,$first_name,$last_name,7);
        }elseif(selectstrach($user_id)['adres']===' '){
            $reply = "Напишите свой адрес";
            sendMessage($token,$user_id,$reply);
            name($user_id,$first_name,$last_name,8);
        }elseif(selectstrach($user_id)['beginstrach']===' '){
            $reply = "Напишите дату начала страхования";
            sendMessage($token,$user_id,$reply);
            name($user_id,$first_name,$last_name,9);
        }else{
            $reply = "Пожалуйста внимательно проверьте свои данные. \n
Имя и Фамилия: ".selectstrach($user_id)['first_last'].
"\nДата рождения: ".selectstrach($user_id)['birth'].
"\nНомер паспорта: ".selectstrach($user_id)['pas'].
"\nНомер телефона: ".selectstrach($user_id)['tel'].
"\nАдрес проживания: ".selectstrach($user_id)['adres'].
"\nДата начала страхования: ".selectstrach($user_id)['beginstrach'].
"\nСрок страхового договора: ".selectstrach($user_id)['srok'].
"\n
Заказ: 
Страховой договор от MAXIMA - комплексное(полное) покрытие.
\n
Стоимость за  ".selectstrach($user_id)['srok']." чешских крон.";
            $keyboard = [ 
               'one_time' => true, 
               'buttons' => [[keyboard('9', "Правильно" ,'positive')],[keyboard('17', "Исправить" ,'positive')]]
            ];
            sendKeyboard($token,$user_id,$reply,$keyboard);
            
        }
    }elseif($button =='{"button":22}' ){
        $reply = "Пожалуйста напишите мне свое имя и фамилию.

Данные должны быть заполнены латиницей!";
        name($user_id,$first_name,$last_name,4);
        sendMessage($token,$user_id,$reply);

    
    }elseif($button =='{"button":23}' ){
        $reply = "Пожалуйста напишите мне свою дату рождения.";
        name($user_id,$first_name,$last_name,5);
        sendMessage($token,$user_id,$reply);

    
    }elseif($button =='{"button":24}'){
        $reply =  "Пожалуйста напишите мне свой номер паспорта.";
        name($user_id,$first_name,$last_name,6);
        sendMessage($token,$user_id,$reply);

    
    }elseif($button =='{"button":25}'){
        $reply = "Пожалуйста напишите мне свой номер телефона.";
        name($user_id,$first_name,$last_name,7);
        sendMessage($token,$user_id,$reply);

    
    }elseif($button =='{"button":26}'){
        $reply = "Пожалуйста напишите мне свой адрес проживания.";
        name($user_id,$first_name,$last_name,8);
        sendMessage($token,$user_id,$reply);

    
    }elseif($button =='{"button":27}'){
        $reply = "Пожалуйста напишите мне дату начала страхования";
        name($user_id,$first_name,$last_name,9);
        sendMessage($token,$user_id,$reply);

    
    }elseif($button =='{"button":30}'){
            $color = 'positive';
            $reply = "Нажимая на кнопки, пишите свои данные.";
            $keyboard = [ 
                'one_time' => false, 
                'buttons' => [[keyboard('22',"Имя и Фамилия: ".selectstrach($user_id)['first_last'], $color)],[keyboard('23',"Дата рождения: ".selectstrach($user_id)['birth']  ,$color)]
                             ,[keyboard('24',"Номер паспорта: ".selectstrach($user_id)['pas'] ,$color)],[keyboard('25',"Номер телефона: ".selectstrach($user_id)['tel'] ,$color)]
                             ,[keyboard('26', "Адрес проживания: ".selectstrach($user_id)['adres'] ,$color)],[keyboard('27', "Дата начала: ".selectstrach($user_id)['beginstrach'] ,$color)]
                             ,[keyboard('17', "Продолжить" ,'positive')],[keyboard('16', "Назад" ,'negative')]
                             ]
            ];
            sendKeyboard($token,$user_id,$reply,$keyboard);
            namestrach($user_id,$text,'srok');

    }elseif($text =="Заказать страховку" ){
        $reply = "ВЫБЕРЕТЕ ПОДХОДЯЩИЙ ВАМ ВИД СТРАХОВАНИЯ.";
        $keyboard = [ 
            'one_time' => true, 
            'buttons' => [[keyboard('1', "КОМПЛЕКСНОЕ СТРАХОВАНИЕ - ДО 30 ЛЕТ" ,'positive')],[keyboard('10', "КОМПЛЕКСНОЕ СТРАХОВАНИЕ - ОТ 30 ЛЕТ" ,'positive')],
                         [keyboard('10', "НЕОТЛОЖНАЯ МЕД ПОМОЩЬ" ,'positive')],[keyboard('10', "Назад" ,'negative')]]
        ];
        sendKeyboard($token,$user_id,$reply,$keyboard);

    
    }elseif($text =="КОМПЛЕКСНОЕ СТРАХОВАНИЕ - ДО 30 ЛЕТ" ){
        
        $reply = "КОМПЛЕКСНОЕ МЕДИЦИНСКОЕ СТРАХОВАНИЕ";
        
        $keyboard = [ 
            'one_time' => true, 
            'buttons' => [[keyboard('30', "3 мес ".cenik(3) ,'positive'),keyboard('30', "4 мес ".cenik(4) ,'positive')],[keyboard('30', "5 мес ".cenik(5) ,'positive')
,keyboard('30', "6 мес ".cenik(6) ,'positive')],[keyboard('30', "7 мес ".cenik(7) ,'positive'),keyboard('30', "8 мес ".cenik(8) ,'positive')],[keyboard('30', "9 мес ".cenik(9) ,'positive')
,keyboard('30', "10 мес ".cenik(10) ,'positive')],[keyboard('30', "11 мес ".cenik(11) ,'positive'),keyboard('30', "12 мес ".cenik(12) ,'positive')],[keyboard('10', "Назад" ,'negative')]]
        ];
        sendKeyboard($token,$user_id,$reply,$keyboard);

    }elseif($text =="Да, я хочу получать уведомления"){
        
        $reply = "Один раз в неделю я буду проверять наличие номера заявки на совпадение в базе МВД ЧР. 

Если мне удастся обнаружить номер заявки, я уведомлю Вас об этом. 

Так же, периодически я буду оповещать Вас о новых продуктах, акциях, изменениях цен на страховые продукты и важные для иностранцев новости.

Если Вы не хотите получать уведомления, напишите мне 'Больше не получать уведомления'";
        $keyboard = [ 
            'one_time' => true, 
            'buttons' => [[keyboard('1', "Проверить визу" ,'positive')],[keyboard('10', "Больше не получать уведомления" ,'negative')]]
        ];
        sendKeyboard($token,$user_id,$reply,$keyboard);
        visacontrol($user_id,'centr');
    }elseif($text =="Больше не получать уведомления" or $text =="больше не получать уведомления"){
        $reply = "Вы больше не будете получать уведомления о одобрении вашей визы и важные новости сообщества.";
        $keyboard = [ 
            'one_time' => true, 
            'buttons' => [[keyboard('1', "Проверить визу" ,'positive')]]
        ];
        sendKeyboard($token,$user_id,$reply,$keyboard);
        visacontrol($user_id,0);
    }elseif($text =="Хорошо, буду ждать уведомление"){
        $reply = "Пока мы в вместе с Вами ждем, Вы можете задать вопрос нашим менеджерам, которые ответят Вам в ближайшее время!";
        $keyboard = [ 
            'one_time' => true, 
            'buttons' => [[keyboard('1', "Проверить визу" ,'positive')]]
        ];
        sendKeyboard($token,$user_id,$reply,$keyboard);
    }elseif($text =="Нет, я не хочу получать уведомления"){
        $reply = "Хорошо, Вы в любое время можете включить уведомления.";
        $keyboard = [ 
            'one_time' => true, 
            'buttons' => [[keyboard('1', "Проверить визу" ,'positive')]]
        ];
        sendKeyboard($token,$user_id,$reply,$keyboard);
    }
    
    else{
        $color = 'positive';
        
        
        if($setdisen==='4'){
            $reply =  "Имя сохранено";
            $keyboard = [ 
                'one_time' => false, 
                'buttons' => [[keyboard('22',"Имя и Фамилия: ".$text ,$color)],[keyboard('23', "Дата рождения: ".selectstrach($user_id)['birth'] ,$color)]
                             ,[keyboard('24', "Номер паспорта: ".selectstrach($user_id)['pas'] ,$color)],[keyboard('25', "Номер телефона: ".selectstrach($user_id)['tel'] ,$color)]
                             ,[keyboard('26', "Адрес проживания: ".selectstrach($user_id)['adres'] ,$color)],[keyboard('27', "Дата начала: ".selectstrach($user_id)['beginstrach'] ,$color)]
                             ,[keyboard('17', "Продолжить" ,'positive')],[keyboard('16', "Назад" ,'negative')]
                             ]
            ];
            sendKeyboard($token,$user_id,$reply,$keyboard);
            namestrach($user_id,$text,'first_last');
        }elseif($setdisen==='5'){
            $reply = "Дата сохранена";
            $keyboard = [ 
                'one_time' => false, 
                'buttons' => [[keyboard('22',"Имя и Фамилия: ".selectstrach($user_id)['first_last'] ,$color)],[keyboard('23', "Дата рождения: ".$text ,$color)]
                             ,[keyboard('24', "Номер паспорта: ".selectstrach($user_id)['pas'] ,$color)],[keyboard('25', "Номер телефона: ".selectstrach($user_id)['tel'] ,$color)]
                             ,[keyboard('26', "Адрес проживания: ".selectstrach($user_id)['adres'] ,$color)],[keyboard('27', "Дата начала: ".selectstrach($user_id)['beginstrach'] ,$color)]
                             ,[keyboard('17', "Продолжить" ,'positive')],[keyboard('16', "Назад" ,'negative')]
                             ]
            ];
            sendKeyboard($token,$user_id,$reply,$keyboard);
            namestrach($user_id,$text,'birth');
        }elseif($setdisen==='6'){
            $reply = "Паспорт сохранен";
            $keyboard = [ 
                'one_time' => false, 
                'buttons' => [[keyboard('22',"Имя и Фамилия: ".selectstrach($user_id)['first_last'] ,$color)],[keyboard('23', "Дата рождения: ".selectstrach($user_id)['birth'] ,$color)]
                             ,[keyboard('24', "Номер паспорта: ".$text ,$color)],[keyboard('25', "Номер телефона: ".selectstrach($user_id)['tel'] ,$color)]
                             ,[keyboard('26', "Адрес проживания: ".selectstrach($user_id)['adres'] ,$color)],[keyboard('27', "Дата начала: ".selectstrach($user_id)['beginstrach'] ,$color)]
                             ,[keyboard('17', "Продолжить" ,'positive')],[keyboard('16', "Назад" ,'negative')]
                             ]
            ];
            sendKeyboard($token,$user_id,$reply,$keyboard);
            namestrach($user_id,$text,'pas');
        }elseif($setdisen==='7'){
            $reply = "Телефон сохранен";
            $keyboard = [ 
                'one_time' => false, 
                'buttons' => [[keyboard('22',"Имя и Фамилия: ".selectstrach($user_id)['first_last'] ,$color)],[keyboard('23', "Дата рождения: ".selectstrach($user_id)['birth'] ,$color)]
                             ,[keyboard('24', "Номер паспорта: ".selectstrach($user_id)['pas'] ,$color)],[keyboard('25', "Номер телефона: ".$text ,$color)]
                             ,[keyboard('26', "Адрес проживания: ".selectstrach($user_id)['adres'] ,$color)],[keyboard('27', "Дата начала: ".selectstrach($user_id)['beginstrach'] ,$color)]
                             ,[keyboard('17', "Продолжить" ,'positive')],[keyboard('16', "Назад" ,'negative')]
                             ]
            ];
            sendKeyboard($token,$user_id,$reply,$keyboard);
            namestrach($user_id,$text,'tel');
        }elseif($setdisen==='8'){
            $reply = "Адрес сохранен";
            $keyboard = [ 
                'one_time' => false, 
                'buttons' => [[keyboard('22',"Имя и Фамилия: ".selectstrach($user_id)['first_last'] ,$color)],[keyboard('23', "Дата рождения: ".selectstrach($user_id)['birth'] ,$color)]
                             ,[keyboard('24', "Номер паспорта: ".selectstrach($user_id)['pas'] ,$color)],[keyboard('25', "Номер телефона: ".selectstrach($user_id)['tel'] ,$color)]
                             ,[keyboard('26', "Адрес проживания: ".$text ,$color)],[keyboard('27', "Дата начала: ".selectstrach($user_id)['beginstrach'] ,$color)]
                             ,[keyboard('17', "Продолжить" ,'positive')],[keyboard('16', "Назад" ,'negative')]
                             ]
            ];
            sendKeyboard($token,$user_id,$reply,$keyboard);
            namestrach($user_id,$text,'adres');
        }elseif($setdisen==='9'){
            $reply = "Дата сохранена";
            $keyboard = [ 
                'one_time' => false, 
                'buttons' => [[keyboard('22',"Имя и Фамилия: ".selectstrach($user_id)['first_last'] ,$color)],[keyboard('23', "Дата рождения: ".selectstrach($user_id)['birth'] ,$color)]
                             ,[keyboard('24', "Номер паспорта: ".selectstrach($user_id)['pas'] ,$color)],[keyboard('25', "Номер телефона: ".selectstrach($user_id)['tel'] ,$color)]
                             ,[keyboard('26', "Адрес проживания: ".selectstrach($user_id)['adres'] ,$color)],[keyboard('27', "Дата начала: ".$text ,$color)]
                             ,[keyboard('17', "Продолжить" ,'positive')],[keyboard('16', "Назад" ,'negative')]
                             ]
            ];
            sendKeyboard($token,$user_id,$reply,$keyboard);
            namestrach($user_id,$text,'beginstrach');
        }elseif($setdisen==='2'){
            
            visasave($text,$user_id);
            for($i=1;$i<4;$i++){
                $visa_url=select_file($i);
                $handle = fopen($visa_url, "r");
            
                while (($visanum = fgetcsv($handle, 1000, ",")) !== FALSE) {
                     $cutvisa = substr($visanum[1], 2);
                     $cutvisa1 = substr($cutvisa, 0, -2);
                     if($cutvisa1===$text){
                          $status = $cutvisa1."\n".$status;
                          continue;
                     }
                     elseif(strripos($visanum[1], $text)){
                          $status = iconv( 'ISO-8859-2','utf-8' ,$visanum[1])."\n".$status;
                          continue;
                     }
                     else{
                          $status = $status.""; 
                     }
                }
                fclose($handle);
            }
                if($status!=""){
                    $keyboard = [ 
                        'one_time' => true, 
                        'buttons' => [[keyboard('1',"Проверить визу" ,'positive')]]
                    ];
                    $reply = 'Поздравляю! 
Найдено совпадение: 
'.$status.'

Рекомендую Вам позвонить по номеру департамента Министерства внутренних дел, для записи на фотографирование. 

Список контактов Вы можете найти тут:
https://www.mvcr.cz/clanek/sluzby-pro-verejnost-informace-pro-cizince-kontakty.aspx';
                }
                else{
                    $reply = 'Виза не обнаружена.

Хотите получить уведомление о готовности визы: '.$text.', а так же, получать уведомления от нашего сообщества?

Используйте кнопки для ответов.';
                    $keyboard = [ 
                        'one_time' => true, 
                        'buttons' => [[keyboard('11',"Да, я хочу получать уведомления" ,'positive')],[keyboard('12',"Нет, я не хочу получать уведомления" ,'negative')]]
                    ];
                }
                
                sendKeyboard($token,$user_id,$reply,$keyboard);
            
        }elseif($setdisen==='3'){
            $file = $data['object']['attachments'];
            if(isset($file[0]) and isset($file[1]) and isset($file[2])){
                
                for($i=0;$i<4;$i++){
                    $file_format = $data['object']['attachments'][$i]['doc']['ext'];
                    $file_url = $data['object']['attachments'][$i]['doc']['url'];
                    if($file[$i]['type'] == 'doc' ){
                         if($file_format == 'csv'){
                              update_file(stristr($file_url, '&', true),$token,$user_id,$i+1);
                         }else{
                              sendMessage($token,$user_id,'Файл должен быть в формате CSV');
                         }
                    }
                }
            }
        }
        else{
            header("HTTP/1.1 200 OK");
            echo ('ok'); 
        }
    }
}
function sendKeyboard($token,$user_id,$reply,$keyboard){
    //$reply = iconv( 'cp1251','utf-8' , $reply);
    $request_params = array(
        'message' => $reply,
        'user_id' => $user_id,
        'access_token' => $token,
        'keyboard'=>json_encode($keyboard, JSON_UNESCAPED_UNICODE),
        'v' => '5.78'
    );
    file_get_contents('https://api.vk.com/method/messages.send?'. http_build_query($request_params));
    header("HTTP/1.1 200 OK");
    echo ('ok'); 
}
function sendMessage($token,$user_id,$reply){
    //$reply = iconv( 'cp1251','utf-8' , $reply);
    $request_params = array(
        'message' => $reply,
        'user_id' => $user_id,
        'access_token' => $token,
        'v' => '5.78',
    );
    file_get_contents('https://api.vk.com/method/messages.send?'. http_build_query($request_params));
    header("HTTP/1.1 200 OK");
    echo ('ok'); 
}
function keyboard($par,$name_btn,$color){
    //$name_btn = iconv( 'cp1251','utf-8' , $name_btn);
    $key = 
        ['action' =>['type' => 'text', 
                     'payload' => '{"button": '.$par.'}',
                     'label' => $name_btn, 
                    ],
        'color' => $color]
    ;
    return $key;
    
}
function cenik($param){
    $cenik = $param*833;
    return $cenik;
}
$dbconnect->close();
?>
						
