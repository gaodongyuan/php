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


function newTopicFilter($contract){
  $cb = new Callback;    
  $topics = [];
  
  $contract->eth->newFilter($topics,$cb); 
  return $cb->result;
}

function monitorLoop($contract,$fid){
  $cb = new Callback;

  //$topic = $contract->ethabi->encodeEventSignature($contract->events['Transfer']);
  $topic = $contract->ethabi->encodeEventSignature($contract->events['Approval']);
  echo $topic . PHP_EOL;
  
  while(true){
    $contract->eth->getFilterChanges($fid,$cb);
    $logs = $cb->result;
    
    if(count($logs) >0){    
      foreach($logs as $log) 
        if($log->topics[0] == $topic)
          var_dump($log);   
        else
          echo 'skip log ' . PHP_EOL;
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