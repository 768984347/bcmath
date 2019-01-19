# bcmath

php 精度数学

//加载依赖

composer require pxb/bcmath

//加载类

use Noob\Lib\BC;

//声明单例

BC::instance();  //默认2位小数

BC::instance(4);  //4位小数 改变结果小数位

###异常 exception:

ExtensionNotFound // bcmath依赖没有加载

##方法

加

BC::instance()->add(1, 1.11111); // "2.11"

BC::instance(1)->add(2.22, 2, 2, 2, 2,...); //不限制参数个数

BC::instance(0)->add([1,1,1,1,1.111]); //数组参数

减

BC::instance()->sub(2, 2); // "0.00"

BC::instance(4)->sub(6, 2, 2, ...); //不限制参数个数

BC::instance(6)->sub([8.000005, 2, 2]); //数组参数

乘

BC::instance(2)->mul(2, 2)； // "4.00"

BC::instance(4)->mul(2, 2, 2, ...); //不限制参数个数

BC::instance(6)->mul([2,2,2,2.000001]); //数组参数

除 

BC::instance(0)->div(1, 1); // "1"

BC::instance(1)->div(4, 2, 1); //不限制参数个数

BC::instance(2)->div([64.32, 8, 2]); //数组参数
