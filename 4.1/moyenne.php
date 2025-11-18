<?php
$eleves = [
["nom" => "Alice", "notes" => [15, 14, 16]],
["nom" => "Bob", "notes" => [12, 10, 11]],
["nom" => "Claire", "notes" => [18, 17, 16]]
];

foreach($eleves as $liste){
    $moyenne=0;
    for($i=0; $i<=3; $i++){
        $moyenne+=$liste["notes"][$i];
    }
    $moyenne =$moyenne/3;
    echo ($liste["nom"] . " avec une moyenne de " . $moyenne  );
}
?>