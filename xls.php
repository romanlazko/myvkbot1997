<?php
$row = 1;
if (($handle = fopen("test2.csv", "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
        $num = count($data);
        
        $row++;
        for ($c=0; $c < $num; $c++) {
            
            $pos      = strripos($data[$c], 'OAM-32703/DP-2018');

            if ($pos === false) {
                echo "К сожалению, не найдена";
            } else {
                echo "Поздравляем!\n";
                break;
            }
            echo $data[$c] . "<br />\n";
        }
    }
    fclose($handle);
}
?>
