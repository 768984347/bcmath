<?php
/**
 * Created by PhpStorm.
 * User: pxb
 * Date: 2019/1/19
 * Time: 下午5:10
 */
require "../vendor/autoload.php";

use Noob\Lib\BC;

echo BC::instance(0)->add([1,1,1,1,1.111]);
