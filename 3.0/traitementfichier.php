<?php
$fichier = fopen("personne.txt", "r");
$contact = ["Alice Dupont", "John Doe", "Jean Martin"];
$token= 0;

while(!feof($fichier)){
    $temp = trim(fgets($fichier));
    foreach($contact as $element){
        if($element== $temp){
        $token++;
    }
    }
    if( $token == 0){
        array_push($contact,$temp);
    }
    $token = 0;
}
print_r($contact);
?>