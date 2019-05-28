<?php
require('../vendor/autoload.php');

use Web3\Web3;
use Web3\Contract;
use Web3\Utils;
use EthTool\Callback;

$web3 = new Web3('http://localhost:8545');
$cb = new Callback;

$contract = loadContract($web3,'EzToken');

$fid = newTopicFilter($contract);
echo 'filter id: ' . $fid . PHP_EOL;

monitorLoop($contract,$fid);


function newTopicFilter($web3){
  $cb = new Callback;
  $topics = [];
  $web3->eth->newFilter($topics,$cb); 
  return $cb->result;
}

function monitorLoop($contract,$fid){
  $cb = new Callback;
  
  while(true){
    $contract->eth->getFilterChanges($fid,$cb);
    $logs = $cb->result;
    
    if(count($logs) >0){    
      foreach($logs as $log) 
        //var_dump($log);              
      
        $from = $contract->ethabi->decodeParameter('address',$log->topics[1]);
        $to = $contract->ethabi->decodeParameter('address',$log->topics[2]);
        $value = $contract->ethabi->decodeParameter('uint256',$log->data);
		
        echo 'from: ' . $from . PHP_EOL;
        echo 'to: ' . $to . PHP_EOL;
        echo 'value: ' . $value . PHP_EOL;
    }

    sleep(2);
  }
}

function loadContract($web3,$artifact){
  $dir = './contract/build/';
  $abi = file_get_contents($dir . $artifact . '.abi');
  
  $contract = new Contract($web3->provider,$abi);
  return $contract;
}


?>