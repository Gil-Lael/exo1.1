<?php 
include 'config.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (strlen($_POST['nom']) < 3) {
        die("Le nom doit faire au moins 3 lettres");
    }

    if (!preg_match('/^[A-Z]{3}$/', $_POST['pays'])) {
        die("Le pays doit être 3 lettres majuscules");
    }

    if (!is_numeric($_POST['temps'])) {
        die("Le temps doit être un nombre");
    }

    $insert = $mysqlClient->prepare(
        "INSERT INTO football.`100` (nom, pays, course, temps) 
         VALUES (:nom, :pays, :course, :temps)"
    );

    $insert->execute([
        ":nom" => $_POST["nom"],
        ":pays" => $_POST["pays"],
        ":course" => $_POST["course"],
        ":temps" => $_POST["temps"]
    ]);
}


$search = $_GET['search'] ?? "";


$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 10;
$offset = ($page - 1) * $limit;


$sort = "nom";
if (isset($_GET['sort'])) {
    $sort = $_GET['sort'];
}
$order = "desc";
if (isset($_GET['order'])) {
    $order = $_GET['order'];
}


$query = $mysqlClient->prepare(
    "SELECT *,
    RANK() OVER (PARTITION BY course ORDER BY temps ASC) AS classement
    FROM football.`100`
    WHERE nom LIKE :search OR pays LIKE :search OR course LIKE :search
    ORDER BY $sort $order
    LIMIT :limit OFFSET :offset"
);

$query->bindValue(':search', "%$search%", PDO::PARAM_STR);
$query->bindValue(':limit', $limit, PDO::PARAM_INT);
$query->bindValue(':offset', $offset, PDO::PARAM_INT);
$query->execute();

$data = $query->fetchAll();

// Récupérer toutes les courses pour le formulaire
$courses = $mysqlClient->query("SELECT DISTINCT course FROM football.`100`")->fetchAll(PDO::FETCH_COLUMN);

// Total pour pagination
$totalRows = $mysqlClient->query("SELECT COUNT(*) FROM football.`100`")->fetchColumn();
$totalPages = ceil($totalRows / $limit);

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


<h2>Ajouter un résultat</h2>
<form method="POST">
    Nom : <input type="text" name="nom" required>
    Pays : <input type="text" name="pays" maxlength="3" required>
    Course :
    <select name="course">
        <?php foreach ($courses as $c): ?>
            <option value="<?= $c ?>"><?= $c ?></option>
        <?php endforeach; ?>
    </select>
    Temps : <input type="number" step="0.01" name="temps" required>
    <button type="submit">Ajouter</button>
</form>


<form method="GET">
    <input type="text" name="search" value="<?= $search ?>" placeholder="Rechercher">
    <button type="submit">OK</button>
</form>

<table>
    <thead>
        <tr>

            
            <th>Nom   <a  <?php if ($sort == "nom" && $order == "desc") {
                echo 'class="active"';} ?>  href="./sql.php?sort=nom" > ↓ </a>
                 <a  <?php if ($sort == "nom" && $order == "asc") {
                echo 'class="active"';} ?> href="./sql.php?sort=nom&order=asc"> ↑ </a></th>

            <th>Pays    <a <?php if ($sort == "pays" && $order == "desc") {
                echo 'class="active"';} ?> href="./sql.php?sort=pays"> ↓ </a> 
                <a <?php if ($sort == "pays" && $order == "asc") {
                echo 'class="active"';} ?> href="./sql.php?sort=pays&order=asc"> ↑ </a></th>

            <th>Course  <a <?php if ($sort == "course" && $order == "desc") {
                echo 'class="active"';} ?> href="./sql.php?sort=course"> ↓ </a> 
                <a <?php if ($sort == "course" && $order == "asc") {
                echo 'class="active"';} ?> href="./sql.php?sort=course&order=asc"> ↑ </a></th>
           
           <th>Temps   <a <?php if ($sort == "temps" && $order == "desc") {
                echo 'class="active"';} ?> href="./sql.php?sort=temps"> ↓ </a> 
                <a <?php if ($sort == "temps" && $order == "asc") {
                echo 'class="active"';} ?> href="./sql.php?sort=temps&order=asc"> ↑ </a></th>

            
            <th>Classement</th>

            
            <th>Modifier</th>

        </tr>
    </thead>

    <?php foreach ($data as $value) { ?>
        <td><?php echo $value["nom"]; ?> </td>
        <td><?php echo $value["pays"] ?></td>
        <td><?php echo $value["course"] ?></td>
        <td><?php echo $value["temps"] ?></td>

        
        <td><?php echo $value["classement"]; ?></td>
        <td><a href="edit.php?id=<?= $value["id"] ?>">Modifier</a></td>

    </tr>
    <?php } ?>
</table>

<div>
    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
        <a href="?page=<?= $i ?>&sort=<?= $sort ?>&order=<?= $order ?>"><?= $i ?></a>
    <?php endfor; ?>
</div>

<?php
$mysqlClient = null;
$dbh = null;
?>

</body>
</html>