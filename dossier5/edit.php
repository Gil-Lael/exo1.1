<?php
include 'config.php';

$id = $_GET["id"] ?? null;
if (!$id) die("ID manquant.");

$query = $mysqlClient->prepare("SELECT * FROM football.`100` WHERE id = :id");
$query->execute([":id" => $id]);
$data = $query->fetch();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (strlen($_POST['nom']) < 3) die("Nom trop court.");
    if (!preg_match('/^[A-Z]{3}$/', $_POST['pays'])) die("Pays invalide.");
    if (!is_numeric($_POST['temps'])) die("Temps invalide.");

    $update = $mysqlClient->prepare(
        "UPDATE football.`100`
         SET nom = :nom, pays = :pays, course = :course, temps = :temps
         WHERE id = :id"
    );

    $update->execute([
        ":nom" => $_POST["nom"],
        ":pays" => $_POST["pays"],
        ":course" => $_POST["course"],
        ":temps" => $_POST["temps"],
        ":id" => $id
    ]);

    header("Location: sql.php");
    exit;
}
?>

<form method="POST">
    Nom : <input type="text" name="nom" value="<?= $data['nom'] ?>">
    Pays : <input type="text" name="pays" maxlength="3" value="<?= $data['pays'] ?>">
    Course : <input type="text" name="course" value="<?= $data['course'] ?>">
    Temps : <input type="number" step="0.01" name="temps" value="<?= $data['temps'] ?>">
    <button type="submit">Modifier</button>
</form>
