<?php

class logowanie extends database
{
    public function CheckIfUserExists($username, $password)
    {
        $pdo = $this->startPDO();
        try {
            $query = "SELECT COUNT(*) AS quantity FROM user WHERE login = :login AND pass = :pass"; 
            $hashedPassword = md5($password);
            $statement = $pdo->prepare($query);
            $statement->bindParam(':login', $username, PDO::PARAM_STR);
            $statement->bindParam(':pass', $hashedPassword, PDO::PARAM_STR); 
            $statement->execute();
            $result = $statement->fetch(PDO::FETCH_ASSOC);

            if ($result['quantity'] > 0) {
                return true; // Użytkownik istnieje
            } else {
                return false; // Użytkownik nie istnieje
            }
        } catch (PDOException $e) {
            die("Błąd podczas wykonywania zapytania: " . $e->getMessage());
        }
    }

    public function FetchVariables($username, $password)
    {
        $pdo = $this->startPDO();
        
        if (!$this->CheckIfUserExists($username, $password)) {
            $this->closePDO(); 
            return 0; 
        }
    
        try { 
            $query = "SELECT * FROM user WHERE login = :login"; 
            $statement = $pdo->prepare($query);
            $statement->bindParam(':login', $username, PDO::PARAM_STR);
            $statement->execute();
            $result = $statement->fetch(PDO::FETCH_ASSOC);
    
            if ($result) {
                $_SESSION['id'] = $result['id'];
                $_SESSION['filepath'] = $result['filepath'];
                $_SESSION['login'] = $result['login'];
                $_SESSION['access'] = true;

                // Tutaj dodaj pozostałe zmienne sesji, jeśli to potrzebne
				
            } else {
                return 0; // Użytkownik istnieje w bazie, ale nie udało się pobrać danych
            }
        } catch (PDOException $e) {
            $this->closePDO(); //zamykanie bazy
            return -1; // Wystąpił wyjątek podczas wykonywania zapytania
            // die("Błąd podczas wykonywania zapytania: " . $e->getMessage());
        } finally {
            // PDO zamykam we wszystkich opcjach 
        }

        $this->closePDO();
        return 1; // Pobieranie danych zakończone sukcesem
    }

}