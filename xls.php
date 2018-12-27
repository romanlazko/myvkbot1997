<?php

header('Content-Type: text/html; charset=ISO-8859-2');
$row = 1;
if (($handle = fopen("https://vk.com/doc198479020_486014179?hash=2d06958b8235974c68", "r")) !== FALSE) {
     while (($data= fgetcsv($handle, 1000, ",")) !== FALSE) {
        
          $text1 = substr($data[1], 2);
          $text = substr($text1, 0, -2);
          if($text==='OAM-20104/PP-201'){
               echo 'find1';
               break;
          }
          elseif(strripos($data[1], 'OAM-20104/PP-2018')){
               echo 'find2: '.$data[1];
               break;
          }
          else{
               continue;
          }
     }
fclose($handle);
}
?>
