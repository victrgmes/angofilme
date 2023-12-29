<?php
//detalhes de  faturamento
class BillingDetails {

    public static function insertDetails($con, $agreement, $token, $username) {
        $query = $con->prepare("INSERT INTO billingdetails (agreementId, nextBillingDate, token, username)
                                VALUES(:agreementId, :nextBillingDate, :token, :username)");
        $agreementDetails = $agreement->getAgreementDetails();

        $query->bindValue(":agreementId", $agreement->getId());
        $query->bindValue(":nextBillingDate", $agreementDetails->getNextBillingDate());
        $query->bindValue(":token", $token);
        $query->bindValue(":username", $username);

        return $query->execute();
    }

}
?>