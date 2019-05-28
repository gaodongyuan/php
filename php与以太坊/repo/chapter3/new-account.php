<?php
require('../vendor/autoload.php');

use Elliptic\EC;
use kornrunner\Keccak;

$ec = new EC('secp256k1');
$keyPair = $ec->genKeyPair();

$privateKey = $keyPair->getPrivate()->toString(16,2);
$publicKey = $keyPair->getPublic()->encode('hex');
$address = '0x' . substr(Keccak::hash(substr(hex2bin($publicKey),1),256),24);

echo 'Private Key' . PHP_EOL;
echo $privateKey . PHP_EOL;
echo 'Public Key' . PHP_EOL;
echo $publicKey . PHP_EOL;
echo 'address' .PHP_EOL;
echo  $address . PHP_EOL;

?>