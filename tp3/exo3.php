<?php
$fichier = fopen("exo3.txt", "a+");
if ($fichier) {
    fwrite($fichier, "\nAlice Dupont\n John Doe\n Jean Martin\n");
    fclose($fichier);
    echo "Données écrites avec succès dans le fichier.";
} else {
    echo "Erreur lors de l'ouverture du fichier.";
}

?>