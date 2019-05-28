# 过滤器与事件

使用过滤器来检测以太坊区块链上感兴趣的事件。

在运行预置代码之前，请首先在1#终端启动节点仿真器：

```
~$ ganache-cli
```

## 监听新块的生成

在2#终端启动触发脚本：

```
~/repo/chapter6$ php block-filter-trigger.php
```

在3#终端启动监听脚本：

```
~/repo/chapter6$ php block-monitor.php
```

## 监听新交易的生成

在2#终端启动触发脚本：

```
~/repo/chapter6$ php block-filter-trigger.php
```

在3#终端启动监听脚本：

```
~/repo/chapter6$ php transaction-monitor.php
```

## 监听待定交易的生成

在2#终端启动触发脚本：

```
~/repo/chapter6$ php block-filter-trigger.php
```

在3#终端启动监听脚本：

```
~/repo/chapter6$ php pending-tx-monitor.php
```

## 监听合约事件产生的日志

首先编译、部署代币合约：

```
~/repo/chapter6$ ./build-contract.sh
~/repo/chapter6$ php deploy-contract.php
```

在2#终端启动触发脚本：

```
~/repo/chapter6$ php log-trigger.php
```

在3#终端启动监听脚本：

```
~/repo/chapter6$ php log-monitor.php
```
## 使用主题过滤日志

首先编译、部署代币合约：

```
~/repo/chapter6$ ./build-contract.sh
~/repo/chapter6$ php deploy-contract.php
```

在2#终端启动触发脚本：

```
~/repo/chapter6$ php log-trigger-topic.php
```

在3#终端启动监听脚本：

```
~/repo/chapter6$ php log-monitor-topic.php
```

## 监听合约事件并解码日志参数

首先编译、部署代币合约：

```
~/repo/chapter6$ ./build-contract.sh
~/repo/chapter6$ php deploy-contract.php
```

在2#终端启动触发脚本：

```
~/repo/chapter6$ php log-trigger.php
```

在3#终端启动监听脚本：

```
~/repo/chapter6$ php log-decoder.php
```



