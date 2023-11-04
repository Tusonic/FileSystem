<?php 
require_once 'config/loader.php';
session_start();


if (isset($_SESSION['zalogowany']) && $_SESSION['zalogowany'] === true) {
    $login = $_SESSION['uzytkownik']; // Pobierz login zalogowanego użytkownika
    $pliki = (new plik())->pobierzPlikiUzytkownika($login);
    
    // do debugowania, sprawdza sciezke
    echo 'Główna ścieżka user:';
    echo ($_SESSION['filePatch']). "<br>";
    echo "<br>";

    echo '<br>uzytkownik->';
    echo $_SESSION['uzytkownik'];
    echo '<br><br>';

    echo '<br>user_id->';
    echo $_SESSION['id_user'];
    echo '<br><br>';

    
   
    // Wyświetl pliki przypisane do użytkownika
    echo "Witaj, $login! Twoje pliki:<br>";

    foreach ($pliki as $plik) {
        $filename = $plik;
        $filepath = $_SESSION['filePatch'];
        echo "<a href='$filepath" . "$plik'>$filename</a><br>";
    }
  
    echo '</br><a href="wgranie_pliku.php">Wgranie Pliku</a></br>';
    // Wylogowanie
    echo '<a href="wyloguj.php">Wyloguj się</a>';
} else {
    // Komunikat że nie jesteś zalogowany
    echo 'Nie jesteś zalogowany';
    exit();
}