<?php
$fichier = fopen("exo3.1.txt", "a+");
if ($fichier) {
    fwrite($fichier, "\nAlice Dupont\nJohn Doe\nJean Martin\n");
    fclose($fichier);
    echo "Données écrites avec succès dans le fichier.";
} else {
    echo "Erreur lors de l'ouverture du fichier.";
}

?>