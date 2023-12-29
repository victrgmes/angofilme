<?php
require_once("includes/header.php");

$preview = new ProvedorVisualizacao($con, $userLoggedIn);
echo $preview->createTVShowPreviewVideo();

$containers = new CategoriaConteineres($con, $userLoggedIn);
echo $containers->showTVShowCategories();
?>