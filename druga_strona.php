<?php 
require_once 'config/loader.php';
session_start();

if (isset($_SESSION['zalogowany']) && $_SESSION['zalogowany'] === true) {
    $login = $_SESSION['uzytkownik']; // Pobierz login zalogowanego użytkownika

    $pliki = (new plik())->pobierzPlikiUzytkownika($login);

    // Wyświetl pliki przypisane do użytkownika
    echo "Witaj, $login! Twoje pliki:<br>";
    foreach ($pliki as $plik) {
        $filename = $plik['filename'];
        $filepath = $plik['filepath'];
        echo "<a href='$filepath'>$filename</a><br>";
    }

    // Wylogowanie
    echo '<a href="wyloguj.php">Wyloguj się</a>';
} else {
    // Komunikat że nie jesteś zalogowany
    echo 'Nie jesteś zalogowany';
    exit();
}