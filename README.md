# nx-container

container for nx

## Installation

> composer require urn2/nx-container

## Usage

```php
use nx\Container;
$container =new Container();

$container['int']=123;
$container['string']='123';
$container['instance']=fn()=>new \Radis();//获取时构建 shared 只在获取时候构建一次 否则每次
$container['obj']=$this; 

//service方法 每次返回都不同
$container['some.service'] =$container->service(fn()=>new "Some Factory Function"(), shared:false);
//method方法 可多次执行
$container['some.method'] =$container->method(fn($s)=>echo $s);
$container['some.method']('123');
//set方法
$container['parameter'] =$container->set([
    //'type'=>'value',
    'value'=>123,
    'shared'=>true,
]);
$container['service'] =$container->set([
    //'type'=>'service',
    'class'=>$container->ref('key'),//'%key%',//应支持一次读取 或 转换成对象(函数)
    'args'=>[1,2,3],
    'shared'=>false, 
]);
$container['method'] =$container->set([
    //'type'=>'method',
    'method'=>fn($s)=>echo $s,
    'shared'=>true, 
]);

```
