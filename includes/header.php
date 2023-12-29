<?php
require_once("includes/config.php");
require_once("includes/classes/ProvedorVisualizacao.php");
require_once("includes/classes/CategoriaConteineres.php");
require_once("includes/classes/Entidade.php");
require_once("includes/classes/ProvedordeEntidade.php");
require_once("includes/classes/MensagemdeErro.php");
require_once("includes/classes/ProvedordeTemporada.php");
require_once("includes/classes/Temporada.php");
require_once("includes/classes/Video.php");
require_once("includes/classes/ProvedordeVideo.php");
require_once("includes/classes/Utilizador.php");

if(!isset($_SESSION["userLoggedIn"])) {
    header("Location: registro.php");
}

$userLoggedIn = $_SESSION["userLoggedIn"];
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Bem-Vindo ao Angomovie</title>
        <link rel="stylesheet" type="text/css" href="ativos/estilo/estilo.css" />

        <script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
        <script src="https://kit.fontawesome.com/160a07d7d2.js" crossorigin="anonymous"></script>
        <script src="ativos/js/script.js"></script>
    </head>
    <body>
        <div class='wrapper'>

<?php
if(!isset($hideNav)) {
    include_once("includes/navBar.php");
}
?>