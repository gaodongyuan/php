# 理解状态与交易

以太坊是一个巨大的分布式状态机，交易则是驱动这个状态机的力量。

在运行预置代码之前，请首先在1#终端启动节点仿真器：

```
~$ ganache-cli
```

## 查看账户余额

在终端运行php脚本：

```
~/repo/chapter4$ php balance.php
```

## 进行单位换算

在终端运行php脚本：

```
~/repo/chapter4$ php units.php
```

## 执行普通交易

在终端运行php脚本：

```
~/repo/chapter4$ php transaction-only.php
```

## 执行普通交易并等待回执

在终端运行php脚本：

```
~/repo/chapter4$ php transaction-receipt.php
```

## 执行裸交易

在终端运行php脚本：

```
~/repo/chapter4$ php raw-transaction.php
```