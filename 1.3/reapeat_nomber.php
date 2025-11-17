<?php
function reapeat($nombre){
    for($i=0; $i<=$nombre; $i++){
            for($z=0; $z<=$i; $z++){
                echo $i;
       }
       echo "<br>";
    }
}

reapeat($_POST["nombres"]);

?>