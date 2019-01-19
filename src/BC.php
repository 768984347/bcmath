<?php
namespace Noob\Lib;

use Noob\Lib\Exception\ExtensionNotFound;

/**
 * Created by PhpStorm.
 * User: pxb
 * Date: 2019/1/18
 * Time: 下午9:44
 */

class BC
{
    /**
     * singleton
     * @var
     */
    protected static $instance;

    /**
     * history of scale
     * @var array
     */
    protected $history = [];

    /**
     * scale
     * @var
     */
    protected $scale;

    /**
     * BC constructor.
     * @throws ExtensionNotFound
     */
    public function __construct()
    {
        if (!extension_loaded('bcmath')) {
            throw new ExtensionNotFound("bc math extension not found");
        }
    }

    /**
     * singleton
     * @param int $scale
     * @return BC
     */
    public static function instance($scale = 2)
    {
        if (!self::$instance) {
            self::$instance = new self();
        }

        if (self::$instance->scale) {
            array_push(self::$instance->history, self::$instance->scale);
        }

        self::$instance->setScale($scale);

        return self::$instance;
    }

    /**
     * 加
     * @return mixed|null|string
     */
    public function add()
    {
        $res = $this->batchOperation(func_get_args(), func_num_args(), "baseAdd");
        $this->goBack();
        return $res;
    }

    /**
     * 减
     * @return mixed|null|string
     */
    public function sub()
    {
        $res = $this->batchOperation(func_get_args(), func_num_args(), "baseSub");
        $this->goBack();
        return $res;
    }

    /**
     * 乘
     * @return mixed|null|string
     */
    public function mul()
    {
        $res = $this->batchOperation(func_get_args(), func_num_args(), "baseMul");
        $res = $this->baseAdd(0, $res);
        $this->goBack();
        return $res;
    }

    /**
     * 除
     * @return mixed|null|string
     */
    public function div()
    {
        $res = $this->batchOperation(func_get_args(), func_num_args(), "baseDiv");
        $this->goBack();
        return $res;
    }

    /**
     * 操作单一方法
     * @param $leftNum
     * @param $rightNum
     * @param $funcName
     * @return mixed
     */
    protected function operation($leftNum, $rightNum, $funcName)
    {
        return call_user_func([$this,$funcName], $leftNum, $rightNum);
    }

    /**
     * 批量操作
     * @param array $args
     * @param $argNum
     * @param $funcName
     * @return mixed|null|string
     */
    protected function batchOperation(array $args, $argNum, $funcName)
    {
        if ($argNum < 2) {
            if ($args) {
                if (is_array($args[0])) {
                    return $this->batchOperation($args[0], count($args[0]), $funcName);
                }
                return $this->baseAdd(0, $args[0]);
            }
            return null;
        } elseif ($argNum > 2) {
            $res = $this->operation($args[0], $args[1], $funcName);
            array_shift($args);
            array_shift($args);
            foreach ($args as $arg) {
                $res = $this->operation($res, $arg, $funcName);
            }
            return $res;
        } else {
            return $this->operation($args[0], $args[1], $funcName);
        }
    }

    /**
     * 将小数位设置为上一次的小数位
     */
    protected function goBack()
    {
        if ($this->history) {
            $prev = array_shift($this->history);
            $this->setScale($prev);
        }
    }

    /**
     * @return mixed
     */
    public function getScale()
    {
        return $this->scale;
    }

    /**
     * @param mixed $scale
     */
    protected function setScale($scale)
    {
        $this->scale = $scale;
    }

    /**
     * @param $leftNum
     * @param $rightNum
     * @return string
     */
    protected function baseAdd($leftNum, $rightNum)
    {
        return bcadd($leftNum, $rightNum, $this->getScale());
    }

    /**
     * @param $leftNum
     * @param $rightNum
     * @return string
     */
    protected function baseSub($leftNum, $rightNum)
    {
        return bcsub($leftNum, $rightNum, $this->getScale());
    }

    /**
     * @param $leftNum
     * @param $rightNum
     * @return string
     */
    protected function baseMul($leftNum, $rightNum)
    {
        return bcmul($leftNum, $rightNum, $this->getScale());
    }

    /**
     * @param $leftNum
     * @param $rightNum
     * @return string
     */
    protected function baseDiv($leftNum, $rightNum)
    {
        return bcdiv($leftNum, $rightNum, $this->getScale());
    }
}
