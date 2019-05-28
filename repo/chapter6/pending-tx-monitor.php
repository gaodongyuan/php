<?php
require('../vendor/autoload.php');

use Web3\Web3;
use EthTool\Callback;

$web3 = new Web3('http://localhost:8545');
$cb = new Callback;

$web3->eth->newPendingTransactionFilter($cb); 
$fid = $cb->result;

while(true){
  $web3->eth->getFilterChanges($fid,$cb);
  $txs = $cb->result;
  
  if(count($txs)>0){
    
    foreach($txs as $hash) {
      $web3->eth->getTransactionByHash($hash,$cb);       
      var_dump($cb->result);
    }
    
  }
  sleep(2);
}

?>