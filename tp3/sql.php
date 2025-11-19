
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
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="index.css">
</head>
<body>
<table>
    <thead>
        <tr>

            <th>Nom   <a  <?php if ($sort == "nom") {
                echo 'class="active"';} ?>  href="./sql.php?sort=nom" > ↓ </a>
                 <a  <?php if ($sort == "nom" && $order == "asc") {
                echo 'class="active"';} ?> href="./sql.php?sort=nom&order=asc"> ↑ </a></th>
            <th>Pays    <a <?php if ($sort == "pays") {
                echo 'class="active"';} ?> href="./sql.php?sort=pays"> ↓ </a> <a <?php if ($sort == "pays" && $order == "asc") {
                echo 'class="active"';} ?> href="./sql.php?sort=pays&order=asc"> ↑ </a></th>
            <th>Course  <a <?php if ($sort == "course") {
                echo 'class="active"';} ?> href="./sql.php?sort=course"> ↓ </a> <a <?php if ($sort == "course" && $order == "asc") {
                echo 'class="active"';} ?> href="./sql.php?sort=course&order=asc"> ↑ </a></th>
           
           <th>Temps   <a <?php if ($sort == "temps") {
                echo 'class="active"';} ?> href="./sql.php?sort=temps"> ↓ </a> <a <?php if ($sort == "temps" && $order == "asc") {
                echo 'class="active"';} ?> href="./sql.php?sort=temps&order=asc"> ↑ </a></th> 
            
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

;

// Fermeture de la connexion
$mysqlClient = null;
$dbh = null;
?>


</body>
</html>