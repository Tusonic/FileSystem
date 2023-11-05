<?php
require_once 'config/loader.php';
$result = false;
$message = 1;
$authentication = new logowanie();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['login'];
    $password = $_POST['pass'];
    $result = $authentication->FetchVariables($username, $password);
    if ($result == false) {
        $message = 0;
    }
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

    <?php
        if (isset($_SESSION['user_id'])) {
            echo "<p>Zalogowano jako użytkownik o ID: " .($_SESSION['user_id']). "</p><br>";
            echo "<p>Twój katalog to: ".($_SESSION['user_id']). "</p>";
        }
    ?>

    <form method="POST">
        <label for="login">Login:</label>
        <input type="text" name="login" id="login" required>
        <br>
        <label for="password">Hasło:</label>
        <input type="password" name="pass" id="password" required>
        <br>
        <button type="submit">Zaloguj</button>
    </form>

    <?php if ($message == 0) {
        echo "<p> error </p>";
    } ?>

<a href="wyloguj.php">Wyloguj się</a>

</body>

</html>