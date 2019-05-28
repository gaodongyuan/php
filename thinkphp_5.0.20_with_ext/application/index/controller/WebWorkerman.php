<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/5
 * Time: 16:07
 */

namespace app\index\controller;
use Workerman\Worker;

use Redis;
require_once  'D:\phpStudy\PHPTutorial\WWW\thinkphp_5.0.20_with_ext\application\index\Workerman-master\Autoloader.php';



// 创建一个Worker监听2345端口，使用http协议通讯
$ws_worker = new Worker("websocket://0.0.0.0:2000");

// 启动4个进程对外提供服务
$ws_worker->count = 4;

// 接收到浏览器发送的数据时回复hello world给浏览器
$ws_worker->onMessage = function($connection, $data)
{
     $redis=new Redis();
    $redis->connect('127.0.0.1','6379');
   // $redis->set('key4','789456');
    $key4= $redis->lPop('workerman1');
        if($key4){
            // 向浏览器发送hello world
            $connection->send($key4);

        }

};
// 运行worker
Worker::runAll();

