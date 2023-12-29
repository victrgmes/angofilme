<?php
require_once("includes/header.php");

if(!isset($_GET["id"])) {
    MensagemdeErro::programa("Nenhuma ID passada para a página");
}

$preview = new ProvedorVisualizacao($con, $userLoggedIn);
echo $preview->createCategoryPreviewVideo($_GET["id"]);

$containers = new CategoriaConteineres($con, $userLoggedIn);
echo $containers->showCategory($_GET["id"]);
?>