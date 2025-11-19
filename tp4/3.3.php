<?php
$fichier = fopen("mult.txt", "r");
while(!feof($fichier)){
    $ligne = fgets($fichier);
    $tableau[] = explode(" ", trim($ligne));
}
fclose($fichier);
foreach($tableau as $mon => $ligne){
    foreach($ligne as $index => $valeur){
        if ($mon >= 1 && $index >= 1) {
            if ($valeur != $tableau[0][$mon] * $tableau[$index][0]) {
                echo  "Les erreurs sont " . $tableau[0][$mon] . " x ". $tableau[$index][0]; echo "</br>";
            }
        }
    }
    
}
?> 