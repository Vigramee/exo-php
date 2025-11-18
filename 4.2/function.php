<?php
function strcontain($string, $chaine){
    $very = 0;
    for($i=0;$i<=strlen($chaine);$i++){
        if ($chaine[$i]==$string[$very]){
            $very++;
        }
        if($very ==strlen($string) ){
            return "Yes";
        }
    }
    return "No";
}
 
echo strcontain("ABC", "ABCEFGHI")
?>