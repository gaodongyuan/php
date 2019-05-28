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

$receipt = waitForReceipt($web3,$cb->result);
var_dump($receipt);

function waitForReceipt($web3,$txhash,$timeout=60,$interval=1){
  $cb = new Callback;
  $t0 = time();
  while(true){
    $web3->eth->getTransactionReceipt($txhash,$cb);       
    if($cb->result) break;
    $t1 = time();
    if(($t1 - $t0) > $timeout) break;
    sleep($interval);  
  }
  return $cb->result;
}
?>