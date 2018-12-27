<?php

header('Content-Type: text/html; charset=ISO-8859-2');
$row = 1;
if (($handle = fopen("https://vk.com/doc198479020_486012686?hash=f23217a8ce1249e853&dl=591a8841aeba4034e2", "r")) !== FALSE) {
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
