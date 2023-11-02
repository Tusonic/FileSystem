<?php
require_once 'config/loader.php';

$logowanie = new logowanie();
$logowanie->test();

// Sprawdź, czy formularz logowania został przesłany
 if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = $_POST['login'];
    $pass = $_POST['pass'];
    $komunikat = $logowanie->logowanieUzytkownika($login, $pass);
}

?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Logowanie</title>
</head>
<body>
    <h1>Logowanie</h1>
    <form method="POST">
        <label for="login">Login:</label>
        <input type="text" name="login" id="login" required>
        <br>
        <label for="password">Hasło:</label>
        <input type="password" name="pass" id="password" required>
        <br>
        <button type="submit">Zaloguj</button>
    </form>

    <?php if (!empty($komunikat)) {
        echo "<p>$komunikat</p>";
    } ?>
  
</body>
</html>