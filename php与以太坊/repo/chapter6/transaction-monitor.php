<?php
require('../vendor/autoload.php');

use Web3\Web3;
use EthTool\Callback;

$web3 = new Web3('http://localhost:8545');
$cb = new Callback();

$web3->eth->newBlockFilter($cb); 
$fid = $cb->result;

while(true){  
  $web3->eth->getFilterChanges($fid,$cb);
  $blocks = $cb->result;
  
  if(count($blocks) > 0 ) {
    foreach($blocks as $hash){
      $web3->eth->getBlockByHash($hash,true,$cb);       
      $block = $cb->result;
      
      foreach($block->transactions as $tx) 
      	var_dump($tx);      
    }
  }
  
  sleep(2);
}

?>