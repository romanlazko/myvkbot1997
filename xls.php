<?php
$row = 1;
if (($handle = fopen("test2.csv", "r")) !== FALSE) {
     
    while (($data= fgetcsv($handle, 1000, ",")) !== FALSE) {
        $num = count($data);
        
        $row++;
         if($num < 2){
              continue;
         }
        //for ($c=0; $c < 5; ) {
            echo $data[1]."<br />\n";
//             $pos      = strripos($data[$c], 'bAM-15898/DP-2018');

//             if ($pos === false) {
//                 continue;
//             } else {
//                 echo "Поздравляем!\n";
//                 break 2;
//             }
        //}
    }
    fclose($handle);
}
?>
