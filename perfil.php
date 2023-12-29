<?php
require_once("includes/header.php");
require_once("includes/paypalConfig.php");
require_once("includes/classes/Conta.php");
require_once("includes/classes/FormSanitizer.php");
require_once("includes/classes/Constantes.php");
require_once("includes/classes/BillingDetails.php");

$user = new Utilizador($con, $userLoggedIn);

$detailsMessage = "";
$passwordMessage = "";
$subscriptionMessage = "";

if(isset($_POST["saveDetailsButton"])) {
    $account = new Conta($con);

    $firstName = FormSanitizer::sanitizeFormString($_POST["firstName"]);
    $lastName = FormSanitizer::sanitizeFormString($_POST["lastName"]);
    $email = FormSanitizer::sanitizeFormEmail($_POST["email"]);

    if($account->updateDetails($firstName, $lastName, $email, $userLoggedIn)) {
        $detailsMessage = "<div class='alertSuccess'>
        Detalhes atualizados com sucesso!
                            </div>";
    }
    else {
        $errorMessage = $account->getFirstError();

        $detailsMessage = "<div class='alertError'>
                                $errorMessage
                            </div>";
    }
}

if(isset($_POST["savePasswordButton"])) {
    $account = new Conta($con);

    $oldPassword = FormSanitizer::sanitizeFormPassword($_POST["oldPassword"]); 
    $newPassword = FormSanitizer::sanitizeFormPassword($_POST["newPassword"]);
    $newPassword2 = FormSanitizer::sanitizeFormPassword($_POST["newPassword2"]);

    if($account->updatePassword($oldPassword, $newPassword, $newPassword2, $userLoggedIn)) {
        $passwordMessage = "<div class='alertSuccess'>
        Senha atualizada com êxito!
                            </div>";
    }
    else {
        $errorMessage = $account->getFirstError();

        $passwordMessage = "<div class='alertError'>
                                $errorMessage
                            </div>";
    }
}

if (isset($_GET['success']) && $_GET['success'] == 'true') {
    $token = $_GET['token'];
    $agreement = new \PayPal\Api\Agreement();

    $subscriptionMessage = "<div class='alertError'>
                                Algo deu errado!
                        </div>";
  
    try {
      //   Executar contrato
      $agreement->execute($token, $apiContext);

        $result = BillingDetails::insertDetails($con, $agreement, $token, $userLoggedIn);
        $result = $result && $user->setIsSubscribed(1);

        if($result) {
            $subscriptionMessage = "<div class='alertSuccess'>
             Vocês estão todos inscritos!
                        </div>";
        }


    } catch (PayPal\Exception\PayPalConnectionException $ex) {
      echo $ex->getCode();
      echo $ex->getData();
      die($ex);
    } catch (Exception $ex) {
      die($ex);
    }
  } 
  else if (isset($_GET['success']) && $_GET['success'] == 'false') {
    $subscriptionMessage = "<div class='alertError'>
                            Usuário cancelado ou algo deu errado!
                        </div>";
  }

?>

<div class="settingsContainer column">

    <div class="formSection">

        <form method="POST">

            <h2>Detalhes do usuário</h2>
            
            <?php

            $firstName = isset($_POST["firstName"]) ? $_POST["firstName"] : $user->getFirstName();
            $lastName = isset($_POST["lastName"]) ? $_POST["lastName"] : $user->getLastName();
            $email = isset($_POST["email"]) ? $_POST["email"] : $user->getEmail();
            ?>

            <input type="text" name="firstName" placeholder="Primeiro nome" value="<?php echo $firstName; ?>">
            <input type="text" name="lastName" placeholder="Sobrenome" value="<?php echo $lastName; ?>">
            <input type="email" name="email" placeholder="Email" value="<?php echo $email; ?>">

            <div class="message">
                <?php echo $detailsMessage; ?>
            </div>
            
            <input type="submit" name="saveDetailsButton" value="Salvar">


        </form>

    </div>

    <div class="formSection">

        <form method="POST">

            <h2>Atualizar senha</h2>

            <input type="password" name="oldPassword" placeholder="Senha antiga">
            <input type="password" name="newPassword" placeholder="Nova senha">
            <input type="password" name="newPassword2" placeholder="Confirmar nova senha">

            <div class="message">
                <?php echo $passwordMessage; ?>
            </div>

            <input type="submit" name="savePasswordButton" value="Salvar">


        </form>

    </div>

    <div class="formSection">
        <h2>Subscrição</h2>

        <div class="message">
            <?php echo $subscriptionMessage; ?>
        </div>

        <?php

        if($user->getIsSubscribed()) {
            echo "<h3>Você está inscrito! Vá para PayPal para cancelar.</h3>";
        }
        else {
            echo "<a href='billing.php'>Subscrever Angomovie</a>";
        }
        ?>
    </div>

</div>