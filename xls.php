<?php
// $cutvisa = substr($visanum[1], 2);
//                 $cutvisa1 = substr($cutvisa, 0, -2);
//                 if($cutvisa1==='OAM-20104/PP-2018'){
//                      sendMessage($token,$user_id,$visanum[1]);
//                      break;
//                 }
//                 elseif(strripos($visanum[1], 'OAM-20104/PP-2018')){
//                      sendMessage($token,$user_id,$visanum[1]);
//                      break;
//                 }
//                 else{
//                      continue;
//                 }
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
header('Content-Type: text/html; charset=ISO-8859-2');
$row = 1;

if (($handle = fopen("https://vk.com/doc113601869_486322806", "r")) !== FALSE) {
     while (($data= fgetcsv($handle, 1000, ",")) !== FALSE) {
        
          $text1 = substr($data[1], 2);
          $text = substr($text1, 0, -2);
          if($text==='OAM-20104/PP-2018'){
               echo 'find1';
               break;
          }
          elseif(strripos($data[1], 'OAM-20104/PP-201')){
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
