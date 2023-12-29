<?php
require_once("includes/header.php");

if(!isset($_GET["id"])) {
    MensagemdeErro::programa("Nenhum ID passado para a página");
}
$entityId = $_GET["id"];
$entity = new Entidade($con, $entityId);

$preview = new ProvedorVisualizacao($con, $userLoggedIn);
echo $preview->createPreviewVideo($entity);

$seasonProvider = new ProvedordeTemporada($con, $userLoggedIn);
echo $seasonProvider->create($entity);

$categoryContainers = new CategoriaConteineres($con, $userLoggedIn);
echo $categoryContainers->showCategory($entity->getCategoryId(), "Você também pode gostar");
?>