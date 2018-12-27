<?php
header('Content-Type: text/html; charset=ISO-8859-2');
$row = 1;
if (($handle = fopen("Prehled_k_17-12-2018.xls", "r")) !== FALSE) {
     while (($data= fgetcsv($handle, 1000, ",")) !== FALSE) {
        echo $data[1];
//           $text1 = substr($data[1], 2);
//           $text = substr($text1, 0, -2);
//           if($text==='28112-5/DP-2016'){
//                echo 'find1';
//                break;
//           }
//           elseif(strripos($data[1], '28112/DP-2016')){
//                echo 'find2: '.$data[1];
//                break;
//           }
//           else{
//                continue;
//           }
     }
fclose($handle);
}
?>
