<?php
require('../vendor/autoload.php');

use Web3\Web3;
use Web3\Contract;
use Web3\Utils;
use EthTool\Callback;

$web3 = new Web3('http://localhost:8545');
$cb = new Callback();

$web3->eth->accounts($cb); 
$accounts = $cb->result;

$contract = loadContract($web3,'EzToken');

$pi = 0;
while(true){
  if(($pi++ % 2) == 0) {
    transfer($contract,$accounts[0],$accounts[2],1);

    $balance = balanceOf($contract,$accounts[2]);
    echo 'balance of account 3#: ' . $balance . PHP_EOL;
  }else{
    approve($contract,$accounts[0],$accounts[9],1);
    
    $allowance = allowance($contract,$accounts[0],$accounts[9]);
    echo 'account 1# => 10#: ' . $allowance . PHP_EOL;
  }
  
  sleep(3);
}

function balanceOf($contract,$account){
  $cb = new Callback;
  $opts = [];
  $contract->call('balanceOf',$account,$opts,$cb);
  return $cb->result['balance']->toString();
}

function transfer($contract,$initiator,$to,$value){
  $cb = new Callback;
  $opts = [
    'from' => $initiator,
    'gas' => Utils::toHex(200000,true)
  ];
  $contract->send('transfer',$to,$value,$opts,$cb);
  $txhash = $cb->result;
  return waitForReceipt($contract->eth,$txhash);
}

function allowance($contract,$owner,$spender){
  $cb = new Callback;
  $opts = [];
  $contract->call('allowance',$owner,$spender,$opts,$cb);
  return $cb->result['remaining']->toString();
}

function approve($contract,$owner,$spender,$value){
  $cb = new Callback;
  $opts = [
    'from' => $owner,
    'gas' => Utils::toHex(200000,true)
  ];
  $contract->send('approve',$spender,$value,$opts,$cb);
  $txhash = $cb->result;
  return waitForReceipt($contract->eth,$txhash);  
}

function waitForReceipt($eth,$txhash,$timeout=60,$interval=1){
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

function loadContract($web3,$artifact){
  $dir = './contract/build/';
  $abi = file_get_contents($dir . $artifact . '.abi');
  $addr = file_get_contents($dir . $artifact . '.addr');
  
  $contract = new Contract($web3->provider,$abi);
  $contract->at($addr);
  return $contract;
}

?>