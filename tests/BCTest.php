<?php
/**
 * Created by PhpStorm.
 * User: pxb
 * Date: 2019/1/19
 * Time: 下午4:35
 */

use Noob\Lib\BC;

class BCTest extends PHPUnit_Framework_TestCase
{
    public function testInstance()
    {
        $this->assertInstanceOf(BC::class, BC::instance());
    }

    public function testAdd()
    {
        $this->assertEquals("2.11", BC::instance()->add(1, 1.11111));
        $this->assertEquals("10.2", BC::instance(1)->add(2.22, 2, 2, 2, 2));
        $this->assertEquals("5", BC::instance(0)->add([1,1,1,1,1.111]));
    }

    public function testDiv()
    {
        $this->assertEquals("1", BC::instance(0)->div(1, 1));
        $this->assertEquals("2.0", BC::instance(1)->div(4, 2, 1));
        $this->assertEquals("4.02", BC::instance(2)->div([64.32, 8, 2]));
    }

    public function testSub()
    {
        $this->assertEquals("0.00", BC::instance()->sub(2, 2));
        $this->assertEquals("2.0000", BC::instance(4)->sub(6, 2, 2));
        $this->assertEquals("4.000005", BC::instance(6)->sub([8.000005, 2, 2]));
    }

    public function testMul()
    {
        $this->assertEquals("4.00", BC::instance(2)->mul(2, 2));
        $this->assertEquals("8.0000", BC::instance(4)->mul(2, 2, 2));
        $this->assertEquals("16.000008", BC::instance(6)->mul([2,2,2,2.000001]));
    }

    public function testGetScale()
    {
        $this->assertEquals(5, BC::instance(5)->getScale());
    }
}
