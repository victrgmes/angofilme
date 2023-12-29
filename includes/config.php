<?php
ob_start(); // Ativa o buffer de saída
session_start();

date_default_timezone_set("Africa/Luanda");

// database c0nexa0
try {
    $con = new PDO("mysql:dbname=movie;host=localhost", "root", "");
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
}
catch (PDOException $e) {
    exit("Falha na conexão: " . $e->getMessage());
}
?>