<?php
require('../vendor/autoload.php');

use Web3\Web3;
use Web3\Contract;
use Web3\Utils;
use EthTool\Callback;

$web3 = new Web3('http://localhost:8545');
$cb = new Callback;

$fid = newTopicFilter($web3);
echo 'filter id: ' . $fid . PHP_EOL;

monitorLoop($web3,$fid);


function newTopicFilter($web3){
  $cb = new Callback;
  $topics = [];
  $web3->eth->newFilter($topics,$cb); 
  return $cb->result;
}

function monitorLoop($web3,$fid){
  $cb = new Callback;
  
  while(true){
    $web3->eth->getFilterChanges($fid,$cb);
    $logs = $cb->result;
    
    if(count($logs) >0){    
      foreach($logs as $log) 
        var_dump($log);              
    }

    sleep(2);
  }
}

?>