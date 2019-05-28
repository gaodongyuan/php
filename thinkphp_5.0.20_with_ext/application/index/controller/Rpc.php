<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/7/29
 * Time: 10:15
 */

namespace app\index\controller;
use web3\web3;

class Rpc
{
      public function index(){

          $web3 = new Web3('http://localhost:8545');
          $web3->clientVersion(function($err,$result){
              if($err) throw $err;
              echo $result . PHP_EOL;
          });

      }



}