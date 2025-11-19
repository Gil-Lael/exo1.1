
<?php
// Connexion à la base de données MySQL avec PDO
try {
    $mysqlClient = new 	PDO( 'mysql:host=localhost;dbname=football;charset=utf8', 'root', 'L@elwifi2025');
}   catch (PDOException $e){
        die($e->getMessage());
}

// Requête SQL pour récupérer toutes les données de la table `100`
$query = $mysqlClient ->prepare( "SELECT * FROM football.`100`;");
$query -> execute();

$data = $query -> fetchAll();
?>

<table>
    <thead>
        <tr>

            <th>Nom</th>
            <th>Pays</th>
            <th>Course</th>
            <th>Temps</th>

        </tr>
    </thead>
    <?php foreach ($data as $value) { ?>
        <td><?php echo $value["nom"]; ?> </td>
        <td><?php echo $value["pays"] ?></td>
        <td><?php echo $value["course"] ?></td>
        <td><?php echo $value["temps"] ?></td>
    </tr>
    <?php } ?>
</table>
<?php

var_dump($data);

// Fermeture de la connexion
$mysqlClient = null;
$dbh = null;
?>

