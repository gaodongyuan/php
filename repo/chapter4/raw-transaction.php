<?php
require('../vendor/autoload.php');

use Web3\Web3;
use Web3\Utils;
use EthTool\Callback;
use EthTool\Credential;

$web3 = new Web3('http://localhost:8545');
$cb = new Callback;

$web3->eth->accounts($cb);
$accounts = $cb->result;

echo 'create wallet...' . PHP_EOL;
$wallet = Credential::newWallet('123','./keystore');
$credential = Credential::fromWallet('123',$wallet);
$walletAddress = $credential->getAddress();
echo 'wallet address: ' . $walletAddress . PHP_EOL;

$web3->eth->getBalance($walletAddress,$cb);
echo 'wallet balance: ' . $cb->result . PHP_EOL;

echo 'transfer from node account 0 to wallet...' . PHP_EOL;
$txreq = [
  'from' => $accounts[0],
  'to' => $walletAddress,
  'value' => '0x' . Utils::toWei('2','ether')->toHex()
];
$web3->eth->sendTransaction($txreq,$cb);
waitForReceipt($web3,$cb->result);

$web3->eth->getBalance($walletAddress,$cb);
echo 'wallet balance: ' . $cb->result . PHP_EOL;

echo 'transfer from wallet to node accouont 2...' . PHP_EOL;
$web3->eth->getTransactionCount($walletAddress,'latest',$cb); 
$nonce =  $cb->result;

$raw = [
    'nonce' => Utils::toHex($nonce,true),
    'gasPrice' => '0x' . Utils::toWei('20','gwei')->toHex(),
    'gasLimit' => '0x76c0',
    'to' => $accounts[2],
    'value' => Utils::toHex(100,true),
    'data' => '0x' . bin2hex('hello'),
    'chainId' => 10
];
$signed = $credential->signTransaction($raw);

$web3->eth->sendRawTransaction($signed,$cb);
waitForReceipt($web3,$cb->result);

$web3->eth->getBalance($walletAddress,$cb);
echo 'wallet balance: ' . $cb->result . PHP_EOL;

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