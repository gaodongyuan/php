<?php
require('../vendor/autoload.php');

use Web3\Web3;
use EthTool\Callback;

$web3 = new Web3('http://localhost:8545');
$cb = new Callback;

$web3->eth->accounts($cb); 
$accounts = $cb->result;

while(true) {
  $txreq = [
    'from' => $accounts[0],
    'to' => $accounts[1],
    'value' => 1000
  ];

  $web3->eth->sendTransaction($txreq,$cb);   

  echo 'tx hash => ' . $cb->result . PHP_EOL;
  
  sleep(3);
}

?>