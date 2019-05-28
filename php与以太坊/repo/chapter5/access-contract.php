<?php
require('../vendor/autoload.php');

use Web3\Web3;
use Web3\Contract;
use Web3\Utils;
use EthTool\Callback;

$web3 = new Web3('http://localhost:8545');
$cb = new Callback;

$web3->eth->accounts($cb);
$accounts = $cb->result;

$contract = loadContract($web3,'EzToken');

echo 'transfer to account 2# 100 coins...' . PHP_EOL;
$receipt = transfer($contract,$accounts[0],$accounts[1],100);

$balance = balanceOf($contract,$accounts[1]);
echo 'balance of account 2#: ' . $balance . PHP_EOL;

function loadContract($web3,$artifact){
  $dir = './contract/build/';
  $abi = file_get_contents($dir . $artifact . '.abi');
  $addr = file_get_contents($dir . $artifact . '.addr');
  
  $contract = new Contract($web3->provider,$abi);
  $contract->at($addr);
  return $contract;
}

function transfer($contract,$initiator,$to,$value){
  $cb = new Callback;
  $opts = [
    'from' => $initiator,
    'gas' => Utils::toHex(2000000,true)
  ];
  $contract->send('transfer',$to,$value,$opts,$cb);
  $txhash = $cb->result;
  return waitForReceipt($contract->eth,$txhash);
}
  
function balanceOf($contract,$account){
  echo $account . PHP_EOL;
  $cb = new Callback;
  $opts = [];
  $contract->call('balanceOf',$account,$opts,$cb);
  return $cb->result['balance']->toString();
}

function waitForReceipt($eth,$txhash,$timeout=60,$interval=1){
  echo 'waiting for tx receipt...' . PHP_EOL;
  $cb = new Callback;
  $t0 = time();
  while(true){
    $eth->getTransactionReceipt($txhash,$cb);       
    if($cb->result) break;
    $t1 = time();
    if(($t1 - $t0) > $timeout) break;
    sleep($interval);  
  }
  return $cb->result;
}

?>