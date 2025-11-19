
<?php
include 'config.php';

$sort = "nom";
if (isset($_GET['sort'])) {
    $sort = $_GET['sort'];
}
$order = "desc";
if (isset($_GET['order'])) {
    $order = $_GET['order'];
}

// Requête SQL pour récupérer toutes les données de la table `100`
$query = $mysqlClient ->prepare( "SELECT * FROM football.`100` ORDER BY ".$sort." ".$order);
$query -> execute();

$data = $query -> fetchAll();
?>

<table>
    <thead>
        <tr>

            <th>Nom <a href="./sql.php?sort=nom">↓</a> <a href="./sql.php?sort=nom&order=asc">↑</a></th>
            <th>Pays <a href="./sql.php?sort=pays">↓</a> <a href="./sql.php?sort=pays&order=asc">↑</a></th>
            <th>Course <a href="./sql.php?sort=course">↓</a> <a href="./sql.php?sort=course&order=asc">↑</a></th>
            <th>Temps <a href="./sql.php?sort=temps">↓</a> <a href="./sql.php?sort=temps&order=asc">↑</a></th>

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

