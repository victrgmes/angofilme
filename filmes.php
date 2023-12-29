<?php
require_once("includes/header.php");

$preview = new ProvedorVisualizacao($con, $userLoggedIn);
echo $preview->createMoviesPreviewVideo();

$containers = new CategoriaConteineres($con, $userLoggedIn);
echo $containers->showMovieCategories();
?>