<?php

/**
 * NBP API Demo Index
 */

header('Content-Type: text/html; charset=utf-8');

require_once __DIR__ . '/vendor/autoload.php';

use Demo\Nbp\NbpApiClient;

$api = new NbpApiClient();
try {
    $jsonResult = $api->getEuroExchangeRateJson();
} catch (\Exception $e) {
    $jsonResultError = $e->getMessage();
}
try {
    $xmlResult = $api->getEuroExchangeRateXml();
} catch (\Exception $e) {
    $xmlResultError = $e->getMessage();
}
?>

<?php if (!isset($jsonResultError)) : ?>
    Aktualny kurs <?php echo $jsonResult->getCurrency(); ?> na dzień 
        <?php echo $jsonResult->getEffectiveDate(); ?> pobrany w JSON: 
        <?php echo $jsonResult->getRate(); ?>zł
        <br />
<?php else : ?>
    Błąd pobierania aktualnego kursu w formacie JSON: <?php echo $jsonResultError; ?>
    <br />
<?php endif; ?>

<?php if (!isset($xmlResultError)) : ?>
    Aktualny kurs <?php echo $xmlResult->getCurrency(); ?> na dzień 
        <?php echo $xmlResult->getEffectiveDate(); ?> pobrany w XML: 
        <?php echo $xmlResult->getRate(); ?>zł
        <br />
<?php else : ?>
    Błąd pobierania aktualnego kursu w formacie JSON: <?php echo $xmlResultError; ?>
    <br />
<?php endif; ?>
