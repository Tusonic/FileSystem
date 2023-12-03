<?php
class password extends database
{
    
    public function ChangePassword($userId, $oldPassword, $newPassword) {
        $pdo = $this->startPDO();

        try {
            // Sprawdzenie, czy stare hasło jest poprawne
            $query = "SELECT pass FROM user WHERE id = :userId";
            $statement = $pdo->prepare($query);
            $statement->bindParam(':userId', $userId, PDO::PARAM_INT);
            $statement->execute();
            $result = $statement->fetch(PDO::FETCH_ASSOC);

            $oldPasswordMd5 = md5($oldPassword);
            if (!$result || $oldPasswordMd5 !== $result['pass']) {
                return "Hasła są różne";
            }

            // Aktualizacja hasła
            $secureNewPassword = md5($newPassword); // używamy MD5 do hashowania nowego hasła
            $query = "UPDATE user SET pass = :newPassword WHERE id = :userId";
            $statement = $pdo->prepare($query);
            $statement->bindParam(':newPassword', $secureNewPassword, PDO::PARAM_STR);
            $statement->bindParam(':userId', $userId, PDO::PARAM_INT);
            $statement->execute();

            return "Hasło zostało zmienione poprawnie";
        } catch (PDOException $e) {
            die("Błąd podczas zmiany hasła: " . $e->getMessage());
        }
    }
}