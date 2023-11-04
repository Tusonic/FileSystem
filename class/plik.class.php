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

    public function wgrajPlik($login, $nazwaPliku, $tmpPliku)
    {
        $pdo = $this->startPDO();

        try {
            $query = "SELECT id_filepath FROM user WHERE login = :login";
            $statement = $pdo->prepare($query);
            $statement->bindParam(':login', $login, PDO::PARAM_STR);
            $statement->execute();

            $row = $statement->fetch(PDO::FETCH_ASSOC);

            if (!$row) {
                $this->closePDO();
                return "Nie znaleziono użytkownika o loginie $login.";
            }

            $idFilePath = $row['id_filepath'];
            
            $query = "SELECT filepath FROM files WHERE id = :idFilePath";
            $statement = $pdo->prepare($query);
            $statement->bindParam(':idFilePath', $idFilePath, PDO::PARAM_INT);
            $statement->execute();
            
            $row = $statement->fetch(PDO::FETCH_ASSOC);

            if (!$row) {
                $this->closePDO();
                return "Nie znaleziono ścieżki do katalogu użytkownika o loginie $login.";
            }

            $katalog = $row['filepath'];
            
            // Generuj unikalną nazwę dla pliku
            $rozszerzenie = pathinfo($nazwaPliku, PATHINFO_EXTENSION);
            $nazwaPliku = uniqid('plik_') . '.' . $rozszerzenie;

            // Przenieś plik do docelowego katalogu
            if (move_uploaded_file($tmpPliku, $katalog . $nazwaPliku)) {
                $this->closePDO();
                return "Plik został przesłany i zapisany jako: $nazwaPliku";
            } else {
                $this->closePDO();
                return "Wystąpił błąd podczas zapisywania pliku.";
            }
        } catch (PDOException $e) {
            $this->closePDO();
            die("Błąd podczas wgrywania pliku: " . $e->getMessage());
        }
    }
}
?>