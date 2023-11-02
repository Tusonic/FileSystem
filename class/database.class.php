<?php

class database
{
    private $serwer = 'localhost'; // Adres serwera bazy danych
    private $uzytkownik = 'tusonic'; // Nazwa użytkownika
    private $haslo = 'tusonic'; // Hasło użytkownika
    private $baza = 'tusonic'; // Nazwa bazy danych
    private $pdo;

    public function __construct()
    {
        try {
            $dsn = "mysql:host={$this->serwer};dbname={$this->baza};charset=utf8"; 

            $opcje = [
                PDO::ATTR_EMULATE_PREPARES   => false,
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ];

            $this->pdo = new PDO($dsn, $this->uzytkownik, $this->haslo, $opcje); 
        } catch (PDOException $e) {
            die("Błąd połączenia z bazą danych: " . $e->getMessage());
        }
    }

    public function startPDO()
    {
        return $this->pdo;
    }

    public function closePDO()
    {
        $this->pdo = null;
    }
}