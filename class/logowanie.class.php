<?php

class logowanie extends database
{
    public function test()
    {
        echo 'Logowanie MD5 true/false </br>';
    }

    public function czyUzytkownikIstnieje($login, $pass)
    {
        // Pobierz połączenie PDO z klasy bazowej
        $pdo = $this->startPDO();

        try {
            // Utwórz zapytanie SQL, które sprawdzi, czy użytkownik o podanym loginie i zahaszowanym haśle istnieje
            $query = "SELECT COUNT(*) AS ilosc FROM user WHERE login = :login AND pass = :pass"; 

            // Haszujemy hasło MD5
            $hashedPassword = md5($pass);

            // Przygotuj i wykonaj zapytanie z parametrami
            $statement = $pdo->prepare($query);
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

    public function logowanieUzytkownika($login, $pass) 
    {
        $istnieje = $this->czyUzytkownikIstnieje($login, $pass);
        
        if ($istnieje) {
            session_start();
            $_SESSION['zalogowany'] = true; // Ustaw sesję, że użytkownik jest zalogowany
            $_SESSION['uzytkownik'] = $login; // Przechowaj login zalogowanego użytkownika
            header("Location: druga_strona.php"); // Przekieruj na drugą stronę
            exit();
        } else {
            $komunikat = 'Niepoprawne dane logowania.';
            return $komunikat;
        
        }
        
    }
}