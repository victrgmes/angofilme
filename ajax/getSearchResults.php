<?php
require_once("../includes/config.php");
require_once("../includes/classes/ProvedordeResultadosdePesquisa.php");
require_once("../includes/classes/ProvedordeEntidade.php");
require_once("../includes/classes/Entidade.php");
require_once("../includes/classes/ProvedorVisualizacao.php");

if(isset($_POST["term"]) && isset($_POST["username"])) {
    
    $srp = new ProvedordeResultadosdePesquisa($con, $_POST["username"]);
    echo $srp->getResults($_POST["term"]);

}
else {
    echo " ... Nenhum termo ou nome de usuário passado para o arquivo";
}
?>