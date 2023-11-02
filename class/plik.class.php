<?php
class plik extends database
{
    public function pobierzPlikiUzytkownika($login)
    {
        $pdo = $this->startPDO();

        try {
            $query = "SELECT filename, filepath FROM files WHERE user_id = (SELECT id FROM user WHERE login = :login)";
            $statement = $pdo->prepare($query);
            $statement->bindParam(':login', $login, PDO::PARAM_STR);
            $statement->execute();

            $pliki = array();
            while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
                $pliki[] = array(
                    'filename' => $row['filename'],
                    'filepath' => $row['filepath']
                );
            }

            $this->closePDO();
            return $pliki;
        } catch (PDOException $e) {
            $this->closePDO();
            die("Błąd podczas pobierania plików: " . $e->getMessage());
        }
    }
}
?>