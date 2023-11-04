<?php
class plik extends database
{
    public function pobierzPlikiUzytkownika($login)
    {
        $pdo = $this->startPDO();

        try {
            $query = "SELECT filename FROM files WHERE userID = (SELECT id FROM user WHERE login = :login)";
            $statement = $pdo->prepare($query);
            $statement->bindParam(':login', $login, PDO::PARAM_STR);
            $statement->execute();

            $pliki = array();
            while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
                array_push($pliki, $row['filename']);
            }

            $this->closePDO();
            return $pliki;
        } catch (PDOException $e) {
            $this->closePDO();
            die("Błąd podczas pobierania plików: " . $e->getMessage());
        }
    }

    public function wgrajPlik()
    {
        $pdo = $this->startPDO();

        if (isset($_SESSION['zalogowany']) && $_SESSION['zalogowany'] === true) {
    $login = $_SESSION['uzytkownik']; // Pobierz login zalogowanego użytkownika

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $plik = new plik();
       // $katalog = $plik->pobierzSciezkeKataloguDlaUzytkownika($login); // Pobierz ścieżkę katalogu z bazy danych
       $katalog = ".". $_SESSION['filePatch'];

        // Sprawdź, czy plik został przesłany bez błędów
        if ($_FILES['plik']['error'] === UPLOAD_ERR_OK) {
            $nazwa_pliku = $_FILES['plik']['name']; // Pobierz oryginalną nazwę pliku

            // Zamień spacje na podłogi "_" w nazwie pliku
            $nazwa_pliku = str_replace(' ', '_', $nazwa_pliku);

            // Wygeneruj 4 losowe znaki
            $losowe_znaki = substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 4);

            // Dodaj losowe znaki na końcu nazwy pliku
            $nazwa_pliku = pathinfo($nazwa_pliku, PATHINFO_FILENAME) . $losowe_znaki . '.' . pathinfo($nazwa_pliku, PATHINFO_EXTENSION);

            // Przenieś plik do docelowego katalogu z nową nazwą
            if (move_uploaded_file($_FILES['plik']['tmp_name'], $katalog . $nazwa_pliku)) {

               // $id_user = $_SESSION['id_user'];
                $query = "INSERT INTO files (id, filename, userID) VALUES (NULL, '$nazwa_pliku', '".$_SESSION['id_user']."')";
                $statement = $pdo->prepare($query);
                $statement->execute();
                $this->closePDO();

                echo "Plik został przesłany i zapisany jako: $nazwa_pliku";
            } else {
                echo "Wystąpił błąd podczas zapisywania pliku.";
            }
        } else {
            echo "Wystąpił błąd podczas przesyłania pliku.";
        }
    }

    echo "<p>Witaj, $login! Jesteś zalogowany i możesz wgrać plik.</p>";

    // Link do wylogowania
    echo '<p><a href="wyloguj.php">Wyloguj się</a></p>';
} else {
    echo 'Nie jesteś zalogowany.';
}
      
        

    }



}



