<?php
require('../vendor/autoload.php');

use Elliptic\EC;
use kornrunner\Keccak;
use EthTool\KeyStore;

$ec = new EC('secp256k1');
$keyPair = $ec->genKeyPair();

$privateKey = $keyPair->getPrivate()->toString(16,2);
$wfn = KeyStore::save($privateKey,'123','./keystore');
echo 'private key: ' . $privateKey . PHP_EOL;
echo 'wallet file: ' . $wfn . PHP_EOL;

$recovered = KeyStore::load('123',$wfn);
echo 'recovered key: ' . $recovered . PHP_EOL;
?>