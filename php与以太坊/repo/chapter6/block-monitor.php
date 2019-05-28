<?php
require('../vendor/autoload.php');

use Web3\Web3;
use EthTool\Callback;

$web3 = new Web3('http://localhost:8545');
$cb = new Callback;

$web3->eth->newBlockFilter($cb); 
$fid = $cb->result;

echo 'wait for new block...' . PHP_EOL;
while(true){
  $web3->eth->getFilterChanges($fid,$cb);
  
  if(count($cb->result) > 0) 
  	print_r($cb->result);  
  
  sleep(2);
}

?>