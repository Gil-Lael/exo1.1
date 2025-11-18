<?php
$eleves = 
[
    ['nom' => 'Alice', 'notes' => [15, 14, 16]],
    ['nom' => 'Durand', 'notes' => [12, 10, 11]],
    ['nom' => 'Martin', 'notes' => [18, 17, 16]]
];
foreach($eleves as $eleve){
    $moyenne = array_sum($eleve['notes']) / count($eleve['notes']);
    echo "La moyenne de " . $eleve['nom'] . " est de " . $moyenne . "<br>";
}
?>