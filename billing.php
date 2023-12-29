<?php
require_once("includes/paypalConfig.php");
require_once("billingPlan.php");

$id = $plan->getId();

use PayPal\Api\Agreement;
use PayPal\Api\Payer;
use PayPal\Api\Plan;
use PayPal\Api\ShippingAddress;


// Criar novo contrato
$agreement = new Agreement();
$agreement->setName('Subscrição da AngoMovie')
  ->setDescription('£ 10 taxa de instalação e, em seguida, pagamentos recorrentes de £ 10 para AngoMovie')
  ->setStartDate(gmdate("Y-m-d\TH:i:s\Z", strtotime("+1 mes", time())));

// Definir id do plano
$plan = new Plan();
$plan->setId($id);
$agreement->setPlan($plan);

// Adicionar tipo de pagador
$payer = new Payer();
$payer->setPaymentMethod('paypal');
$agreement->setPayer($payer);

try {
    // Criar contrato
    $agreement = $agreement->create($apiContext);
  
    // Extrair URL de aprovação para redirecionar o usuário
    $approvalUrl = $agreement->getApprovalLink();
    header("Location: $approvalUrl");
  } catch (PayPal\Exception\PayPalConnectionException $ex) {
    echo $ex->getCode();
    echo $ex->getData();
    die($ex);
  } catch (Exception $ex) {
    die($ex);
  }
?>