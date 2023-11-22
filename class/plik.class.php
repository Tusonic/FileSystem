<?php
class plik extends database
{
    
    public function update_status($reportID, $newStatus)
    {
        $pdo = $this->startPDO();

        try {
            $query = "UPDATE report SET status = :newStatus WHERE id = :reportID";
            $statement = $pdo->prepare($query);
            $statement->bindParam(':newStatus', $newStatus, PDO::PARAM_STR);
            $statement->bindParam(':reportID', $reportID, PDO::PARAM_INT);
            $statement->execute();

            $this->closePDO();
            return "Status sprawozdania został zaktualizowany.";
        } catch (PDOException $e) {
            $this->closePDO();
            die("Błąd podczas aktualizacji statusu sprawozdania: " . $e->getMessage());
        }
    }

}