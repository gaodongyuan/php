<?php
require('../vendor/autoload.php');

use Web3\Web3;
use EthTool\Callback;

$web3 = new Web3('http://localhost:8545');
$cb = new Callback;

$web3->eth->accounts($cb); $accounts = $cb->result;

$web3->eth->getBalance($accounts[0],'latest',$cb);
echo 'balance in latest block: ' . $cb->result . PHP_EOL;

$web3->eth->getBalance($accounts[0],'earliest',$cb);
echo 'balance in earliest block: ' . $cb->result . PHP_EOL;

?>