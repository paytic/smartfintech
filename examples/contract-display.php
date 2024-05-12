<?php

use Paytic\Smartfintech\Api\Authentication\AuthenticationRequest;
use Paytic\Smartfintech\Api\Client\ContractDisplayRequest;
use Paytic\Smartfintech\Models\Contract;
use Paytic\Smartfintech\SmartfintechClient;
use Paytic\Smartfintech\Tests\Fixtures\Models\Contracts\ContractsFactory;

require __DIR__ . '/_init.php';

$contract = ContractsFactory::createFull();
$request = ContractDisplayRequest::create([
    'platform' => '42km',
    'contract' => $contract,
]);
$contractJson = json_encode($contract->toArray());
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Contract</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
<div style="width: 1200px; margin: 0 auto">
    <h1>Contract Display</h1>
    <p>
        Displaying contract for: <br />
        <code>
            <?= $contractJson; ?>
        </code>
    </p>
    <?= $request->displayHtml(); ?>

    <form action="client-activation.php" method="post">
        <input type="hidden" name="contract" value="<?= $contractJson; ?>">
        <button type="submit" class="btn btn-primary">Activate contract</button>
    </form>
</div>
</body>
</html>