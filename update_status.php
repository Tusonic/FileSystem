<?php
require_once 'config/loader.php';
session_start();
$login = $_SESSION['login'];
// zabezpieczenie
if (!isset($_SESSION['user_id']) || (!isset($_SESSION['access']))) {
      header("Location: login.php");
      exit(); 
} else { }

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['report_id'], $_POST['new_status'])) {
    $reportID = $_POST['report_id'];
    $newStatus = $_POST['new_status'];

    $plikObj = new plik();
    $result = $plikObj->update_status($reportID, $newStatus);

    // Przekierowanie z powrotem do strony z raportami po zaktualizowaniu statusu
    header("Location: change_status.php");
    exit();
}