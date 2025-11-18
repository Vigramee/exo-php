<?php
$contacte = fopen("tables.txt", "r");
$status = 1;
while(!feof($contacte)){
    if($status == 1){
        $status++;
        print_r(fgets($contacte));
    }else{
        $ligne = explode(" ", fgets($contacte));
        for ($i = 0; $i<=count($ligne)-1 ; $i++){
            if($i != 0 && $ligne[0]*$i !=$ligne[$i]){
                print_r($ligne[0]*$i. " err");
            }else{
                print_r($ligne[$i]." ");
            }}
        echo "<br>";
    }
};
?>