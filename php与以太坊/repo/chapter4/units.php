<?php
require('../vendor/autoload.php');

use Web3\Utils;

echo '20 gwei  = ' . Utils::toWei('20','gwei') . ' wei' . PHP_EOL;

list($q,$r) = Utils::fromWei('5200','kwei');
echo '5200 wei = ' . $q . ' kwei ' . $r . ' wei' . PHP_EOL;
?>