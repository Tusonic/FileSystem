<?php

class logowanie extends database
{
    private $pdo;
    public function test()
    {
        echo 'Logowanie MD5 true/false </br>';
    }

    private function czyUzytkownikIstnieje($login, $pass)
    {
        // Pobierz połączenie PDO z klasy bazowej
        

        try {
            // Utwórz zapytanie SQL, które sprawdzi, czy użytkownik o podanym loginie i zahaszowanym haśle istnieje
            $query = "SELECT COUNT(*) AS ilosc FROM user WHERE login = :login AND pass = :pass"; 

            // Haszujemy hasło MD5
            $hashedPassword = md5($pass);

            // Przygotuj i wykonaj zapytanie z parametrami
            $statement = $this -> pdo->prepare($query);
            $statement->bindParam(':login', $login, PDO::PARAM_STR);
            $statement->bindParam(':pass', $hashedPassword, PDO::PARAM_STR); 
            $statement->execute();

            // Pobierz wynik zapytania
            $wynik = $statement->fetch(PDO::FETCH_ASSOC);
       

            // Jeśli istnieje użytkownik o podanym loginie i zahaszowanym haśle, zwróć true
            if ($wynik['ilosc'] > 0) {
                $this->closePDO();
                return true;
            }

            $this->closePDO();
            return false;
        } catch (PDOException $e) {
            $this->closePDO();
            die("Błąd podczas wykonywania zapytania: " . $e->getMessage());
        }
    }

    private function dwlFilePatch($login) {
        // Pobierz połączenie PDO z klasy bazowej
        try {
            // Utwórz zapytanie SQL, które sprawdzi, czy użytkownik o podanym loginie i zahaszowanym haśle istnieje
            $query = "SELECT * FROM user WHERE login = :login"; 

            // Przygotuj i wykonaj zapytanie z parametrami
            $statement = $this -> pdo->prepare($query);
            $statement->bindParam(':login', $login, PDO::PARAM_STR);
            $statement->execute();

            // Pobierz wynik zapytania
            $wynik = $statement->fetch(PDO::FETCH_ASSOC);

            $this->closePDO();

            return $wynik['id_filepath'];
        } catch (PDOException $e) {
            $this->closePDO();
            die("Błąd podczas wykonywania zapytania: " . $e->getMessage());
        }
    }

    public function logowanieUzytkownika($login, $pass) 
    {
       
        $this -> pdo = $this->startPDO();
        $istnieje = $this->czyUzytkownikIstnieje($login, $pass);
        
        if ($istnieje) {
            session_start();
            $_SESSION['zalogowany'] = true; // Ustaw sesję, że użytkownik jest zalogowany
            $_SESSION['uzytkownik'] = $login; // Przechowaj login zalogowanego użytkownika
            $_SESSION['filePatch'] = $this -> dwlFilePatch($login);

            try { 
            $query = "SELECT * FROM user WHERE login = :login"; 
            $statement = $this -> pdo->prepare($query);
            $statement->bindParam(':login', $login, PDO::PARAM_STR);
            $statement->execute();
            $wynik = $statement->fetch(PDO::FETCH_ASSOC);
            $_SESSION['id_user'] = $wynik['id'];
            $this->closePDO();
        } catch (PDOException $e) {
            $this->closePDO();
            die("Błąd podczas wykonywania zapytania: " . $e->getMessage());
        }

            header("Location: druga_strona.php"); // Przekieruj na drugą stronę
            exit();
        } else {
            $komunikat = 'Niepoprawne dane logowania.';
            return $komunikat;
        
        }
        
    }
}