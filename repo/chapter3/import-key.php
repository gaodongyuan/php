<?php
require('../vendor/autoload.php');

use Elliptic\EC;
use kornrunner\Keccak;

$ec = new EC('secp256k1');
$keyPair = $ec->keyFromPrivate('0x133be114715e5fe528a1b8adf36792160601a2d63ab59d1fd454275b31328791');

$privateKey = $keyPair->getPrivate()->toString(16,2);
$publicKey = $keyPair->getPublic()->encode('hex');
$address = '0x' . substr(\kornrunner\Keccak::hash(substr(hex2bin($pubKey), 1), 256), 24);

echo 'Private Key' . PHP_EOL;
echo $privateKey . PHP_EOL;
echo 'Public Key' . PHP_EOL;
echo $publicKey . PHP_EOL;
echo 'address' .PHP_EOL;
echo  $address . PHP_EOL;
?>