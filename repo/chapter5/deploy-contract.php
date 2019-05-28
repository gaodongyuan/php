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

$receipt = deployContract($web3,$accounts[0],'EzToken');
echo 'contract deployed at: ' . $receipt->contractAddress . PHP_EOL;

function deployContract($web3,$account,$artifact){  
  $dir = './contract/build/';
  $abi = file_get_contents($dir . $artifact . '.abi');
  $bytecode = '0x' . file_get_contents($dir . $artifact . '.bin');

  $contract = new Contract($web3->provider,$abi);
  $contract->bytecode($bytecode);

  $cb = new Callback;
  $opts = [
    'from' => $account,
    'gas' => Utils::toHex(2000000,true)
  ];
  $contract->new(1000000,'HAPPY TOKEN',0,'HAPY',$opts,$cb);
  $txhash = $cb->result;
  
  $receipt =  waitForReceipt($web3,$txhash); 
  if($receipt->contractAddress){
    file_put_contents($dir . $artifact . '.addr',$receipt->contractAddress);     
  }
  return $receipt;
}

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