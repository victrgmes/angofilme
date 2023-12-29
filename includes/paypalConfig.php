<?php
require_once("PayPal-PHP-SDK/autoload.php");

$apiContext = new \PayPal\Rest\ApiContext(
    new \PayPal\Auth\OAuthTokenCredential(
        'AZBTla9YYszmTBSKAmqYCSIQQO2l8wxShTYR56CYY-Fngv2tNmhHYzn3AYzio2ATZ2VHwCA3EKTNcIjN',     // ClientID
        'EFxOdh3iDOlZyPC9H79M52yLNXD9iXnp54Yhx0huJO8KWSNPQrVYy-wBtyvlEqJ9Y754faIKiPnnFJIe'      // ClientSecret
    )
);
?>