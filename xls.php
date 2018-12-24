<?php
$row = 1;
if (($handle = fopen("test2.csv", "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
        $num = count($data);
        
        $row++;
        for ($c=0; $c < $num; $c++) {
            
            $pos      = strripos($data[$c], 'AM-15898/DP-2018');

            if ($pos === false) {
                continue;
            } else {
                echo "Поздравляем!\n";
                break 2;
            }
        }
    }
    fclose($handle);
}
?>
