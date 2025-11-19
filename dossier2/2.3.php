<?php
function my_str_contains($nom, $sous_nom) {
   
    if ($sous_nom === '') {
        return true;
    }

    $nom_length = strlen($nom);
    $sous_nom_length = strlen($sous_nom);

    
    if ($sous_nom_length > $nom_length) {
        return false;
    }

    
    for ($i = 0; $i <= $nom_length - $sous_nom_length; $i++) {
        $found = true;
        
        for ($j = 0; $j < $sous_nom_length; $j++) {
            if (!isset($nom[$i + $j]) || $nom[$i + $j] !== $sous_nom[$j]) {
                $found = false;
                break;
            }
        }
        if ($found) {
            return true;
        }
    }

    return false;
}


?>