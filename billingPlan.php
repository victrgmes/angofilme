<?php
require_once("includes/paypalConfig.php");
use PayPal\Api\ChargeModel; 
use PayPal\Api\Currency;
use PayPal\Api\MerchantPreferences;
use PayPal\Api\PaymentDefinition;
use PayPal\Api\Plan;
use PayPal\Api\Patch;
use PayPal\Api\PatchRequest;
use PayPal\Common\PayPalModel;

// Criar um novo plano de faturamento
$plan = new Plan ();
$plan->setName('Assinatura mensal do AngoMovie')
  ->setDescription('Obtém todos os recursos do nosso site.')
  ->setType('INFINITE'); 

// Definir definições de plano de faturamento
$paymentDefinition = new PaymentDefinition();
$paymentDefinition->setName('Pagamentos Regulares')
  ->setType('REGULAR')
  ->setFrequency('Month')
  ->setFrequencyInterval('1')
  ->setAmount(new Currency(array('value' => 10, 'currency' => 'GBP')));



$currentUrl = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$returnUrl = str_replace("billing.php", "perfil.php", $currentUrl);

// Definir preferências do comerciante
$merchantPreferences = new MerchantPreferences();
$merchantPreferences->setReturnUrl($returnUrl . "?success=true")
  ->setCancelUrl($returnUrl . "?success=false")
  ->setAutoBillAmount('yes')
  ->setInitialFailAmountAction('CONTINUE')
  ->setMaxFailAttempts('0')
  ->setSetupFee(new Currency(array('value' => 10, 'currency' => 'GBP')));

$plan->setPaymentDefinitions(array($paymentDefinition));
$plan->setMerchantPreferences($merchantPreferences);

//criar plano
try {
    $createdPlan = $plan->create($apiContext);
  
    try {
      $patch = new Patch();
      $value = new PayPalModel('{"state":"ACTIVE"}');
      $patch->setOp('replace')
        ->setPath('/')
        ->setValue($value);
      $patchRequest = new PatchRequest();
      $patchRequest->addPatch($patch);
      $createdPlan->update($patchRequest, $apiContext);
      $plan = Plan::get($createdPlan->getId(), $apiContext);
  
      // ID do plano de saída
      echo $plan->getId();
    } catch (PayPal\Exception\PayPalConnectionException $ex) {
      echo $ex->getCode();
      echo $ex->getData();
      die($ex);
    } catch (Exception $ex) {
      die($ex);
    }
  } catch (PayPal\Exception\PayPalConnectionException $ex) {
    echo $ex->getCode();
    echo $ex->getData();
    die($ex);
  } catch (Exception $ex) {
    die($ex);
  }
?>