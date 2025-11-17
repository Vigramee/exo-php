<?php
function age_type($age){
if($age<3){
    echo "creche";
}else if($age<6){
    echo "maternell";
}else if($age<11){
    echo "primaire";
}else if($age<16){
    echo "college";
}else if($age<18){
    echo "lycée";
}

}
age_type($_POST["age"]);
?>