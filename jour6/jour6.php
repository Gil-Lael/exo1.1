<?php 
session_start();

include 'confi.php';

if(isset($_GET['logout'])){
    session_unset();
}
 if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        
        $_SESSION['username'] = $_POST['username'];
    }

    if (!isset($_SESSION['username'])) {
        echo '<form method="POST">';
        echo 'Username : <input type="text" name="username">';
        echo '<input type="submit" value="Valider">';
        echo '</form>';
    }
 else {
     echo '<a href="jour6.php?logout=true">Déconnexion</a>';
   
    echo 'Bonjour ' . $_SESSION['username'];
} 
 

?>