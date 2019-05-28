# 智能合约的开发与交互

学习ERC20代币智能合约的设计并使用solidity开发语言实现，然后使用php
进行部署与交互。

在运行预置代码之前，请首先在1#终端启动节点仿真器：

```
~$ ganache-cli
```

## 编译合约

执行以下命令：

```
~/repo/chapter5$ ./build-contract.sh
```

## 部署合约

执行php脚本：

```
~/repo/chapter5$ php deploy-contract.php
```

## 访问合约

执行php脚本：

```
~/repo/chapter5$ php access-contract.php
```
