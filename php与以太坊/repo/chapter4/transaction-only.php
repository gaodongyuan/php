<?php
require('../vendor/autoload.php');

use Web3\Web3;
use Web3\Utils;
use EthTool\Callback;

$web3 = new Web3('http://localhost:8545');
$cb = new Callback;

$web3->eth->accounts($cb); $accounts = $cb->result;

$req = [
  "from" => $accounts[3],
  "to" => $accounts[5],
  "value" => '0x' . Utils::toWei('1','ether')->toHex()
];
$web3->eth->sendTransaction($req,$cb);

echo 'tx hash:' . $cb->result . PHP_EOL;

$web3->eth->getBalance($accounts[3],$cb);
echo 'balance: ' . $cb->result . PHP_EOL;
?>