<?php
function agechiel($age)
{
    if($age <= 3)
        {
        return "creche";
        } 
        elseif($age > 3 && $age < 6){
        return "maternelle";
        } 
        elseif($age > 6 && $age <11){
        return "primaire";
        } 
        elseif($age > 11 && $age < 16){
        return "college";
        } elseif($age > 16 && $age < 18){
            return "lycee";
        }
        else{
        return "autre";
        }
    }
    echo agechiel(14);
?>