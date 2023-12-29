<?php
require_once("includes/config.php");
require_once("includes/classes/FormSanitizer.php");
require_once("includes/classes/Constantes.php");
require_once("includes/classes/Conta.php");

$account = new Conta($con);

    if(isset($_POST["submitButton"])) {
        
        $username = FormSanitizer::sanitizeFormUsername($_POST["username"]);
        $password = FormSanitizer::sanitizeFormPassword($_POST["password"]);
        
        $success = $account->entrar($username, $password);

        if($success) {
            $_SESSION["userLoggedIn"] = $username;
            header("Location: index.php");
        }
    }

function getInputValue($name) {
    if(isset($_POST[$name])) {
        echo $_POST[$name];
    }
}  
?>
<!DOCTYPE html>
<html>
<meta charset="UTF-8">
    <head>
        <title>Bem-Vindo ao Angomovie</title>
        <link rel="stylesheet" type="text/css" href="ativos/estilo/estilo.css" />
    </head>
    <body>

        <div class="signInContainer">
            

            <div class="column">

                <div class="header">
                    <img src="ativos/images/lg.png" title="Logo" alt="Site logo" />
                    <h3>Entrar</h3>
                    <span>para continuar o Angomovie</span>
                </div>

                <form method="POST">
                    <?php echo $account->getError(Constantes::$loginFailed); ?>
                    <input type="text" name="username" placeholder="Nome de usuário" value="<?php getInputValue("username"); ?>" required>

                    <input type="password" name="password" placeholder="Senha" required>

                    <input type="submit" name="submitButton" value="ENVIAR">

                </form>

                <a href="registro.php" class="signInMessage">Precisa de uma conta? Assine aqui!</a>

            </div>
            

        </div>
       

    </body>
</html>