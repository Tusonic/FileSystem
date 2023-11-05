<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wgrywanie Pliku</title>
</head>
<body>
    <?php
    session_start();

    if (isset($_SESSION['zalogowany']) && $_SESSION['zalogowany'] === true) {
        $login = $_SESSION['uzytkownik']; // Pobierz login zalogowanego użytkownika
        ?>

        <h1>Wgrywanie Pliku</h1>
        <form method="POST" enctype="multipart/form-data" action="przetwarzanie_pliku.php">
            <label>Wybierz plik:</label>
            <input type="file" name="plik" required>
            <input type="submit" value="Prześlij plik">
        </form>

        <p>Witaj, <?php echo $login; ?>! Jesteś zalogowany i możesz wgrać plik.</p>

        <p><a href="wyloguj.php">Wyloguj się</a></p>

        <?php
    } else {
        echo 'Nie jesteś zalogowany.';
    }
    ?>
</body>
</html>