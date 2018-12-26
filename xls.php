<?php
header('Content-Type: text/html; charset=ISO-8859-2');
$row = 1;
if (($handle = fopen("Prehled_k_17-12-2018.csv", "r")) !== FALSE) {
     while (($data= fgetcsv($handle, 1000, ",")) !== FALSE) {
          if($num < 2){
               continue;
          }
          if($data[1]=='OAM-28112/DP-2016'){
               echo 'нашелся';
          }
          
//           echo $data."<br />\n";
     }
fclose($handle);
}
?>
