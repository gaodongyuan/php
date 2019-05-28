<?php
require('../vendor/autoload.php');

use EthTool\Credential;

$wfn = Credential::newWallet('123','./keystore');
$credential = Credential::fromWallet('123',$wfn);

echo 'private: ' . $credential->getPrivateKey() . PHP_EOL;
echo 'public: ' . $credential->getPublicKey(). PHP_EOL;
echo 'address: ' . $credential->getAddress() . PHP_EOL;
?>