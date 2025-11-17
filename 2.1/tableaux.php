<?php
$nombre = [1, 2, 3, 5 ,6];

function calcmoy($nombre){ 
    $total=0;
    foreach($nombre as $chiffre){
        $total = $total + $chiffre;
    }
    return $total/count($nombre);
}

echo calcmoy($nombre);
?>