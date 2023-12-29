<?php
require_once("includes/config.php");
require_once("includes/classes/FormSanitizer.php");
require_once("includes/classes/Constantes.php");
require_once("includes/classes/Conta.php");

    $account = new Conta($con);

    if(isset($_POST["submitButton"])) {
        
        $firstName = FormSanitizer::sanitizeFormString($_POST["firstName"]);
        $lastName = FormSanitizer::sanitizeFormString($_POST["lastName"]);
        $username = FormSanitizer::sanitizeFormUsername($_POST["username"]);
        $email = FormSanitizer::sanitizeFormEmail($_POST["email"]);
        $email2 = FormSanitizer::sanitizeFormEmail($_POST["email2"]);
        $password = FormSanitizer::sanitizeFormPassword($_POST["password"]);
        $password2 = FormSanitizer::sanitizeFormPassword($_POST["password2"]);
        
        $success = $account->registro($firstName, $lastName, $username, $email, $email2, $password, $password2);

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
    <head>
        <title>Bem-vindo ao Angomovie</title>
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

                    <?php echo $account->getError(Constantes::$firstNameCharacters); ?>
                    <input type="text" name="firstName" placeholder="Primeiro nome" value="<?php getInputValue("firstName"); ?>" required>

                    <?php echo $account->getError(Constantes::$lastNameCharacters); ?>
                    <input type="text" name="lastName" placeholder="Sobrenome" value="<?php getInputValue("lastName"); ?>" required>
                    
                    <?php echo $account->getError(Constantes::$usernameCharacters); ?>
                    <?php echo $account->getError(Constantes::$usernameTaken); ?>
                    <input type="text" name="username" placeholder="Nome de usuário" value="<?php getInputValue("username"); ?>" required>

                    <?php echo $account->getError(Constantes::$emailsDontMatch); ?>
                    <?php echo $account->getError(Constantes::$emailInvalid); ?>
                    <?php echo $account->getError(Constantes::$emailTaken); ?>
                    <input type="email" name="email" placeholder="Email" value="<?php getInputValue("email"); ?>" required>

                    <input type="email" name="email2" placeholder="Confirmar e-mail" value="<?php getInputValue("email2"); ?>" required>
                    
                    <?php echo $account->getError(Constantes::$passwordsDontMatch); ?>
                    <?php echo $account->getError(Constantes::$passwordLength); ?>
                    <input type="password" name="password" placeholder="Senha" required>

                    <input type="password" name="password2" placeholder="Confirme sua senha" required>

                    <input type="submit" name="submitButton" value="ENVIAR">

                </form>

                <a href="entrar.php" class="signInMessage">já tem uma conta? Inscreva-se aqui!</a>

            </div>

        </div>

    </body>
</html>