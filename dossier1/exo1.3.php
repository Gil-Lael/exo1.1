<?php
function motif($n) {
    $resultat = "";
    for ($i = 1; $i <= $n; $i++) {
        $resultat .= str_repeat($i, $i) . "\n";
    }
    return $resultat;
}

echo motif(5);
?>
