<?php

namespace Mossengine\JCode;

/**
 * Class Math
 * @package Mossengine\JCode
 */
class Math
{
    use ArrTrait;

    public static $arrayJCodeFunctions = [
        'mossengine.jcode.math.addition' => '\Mossengine\JCode\Math::addition',
        'mossengine.jcode.math.subtract' => '\Mossengine\JCode\Math::subtract',
        'mossengine.jcode.math.divide' => '\Mossengine\JCode\Math::divide',
        'mossengine.jcode.math.multiply' => '\Mossengine\JCode\Math::multiply',
        'mossengine.jcode.math.random' => '\Mossengine\JCode\Math::random',
    ];

    /**
     * @return float|int
     */
    public static function addition() {
        $arrayParameters = func_get_args();
        $value = static::array_pull($arrayParameters, 0, 0);
        foreach ($arrayParameters as $arg) {
            $value += floatval($arg);
        }
        return $value;
    }

    /**
     * @return float|int
     */
    public static function subtract() {
        $arrayParameters = func_get_args();
        $value = static::array_pull($arrayParameters, 0, 0);
        foreach ($arrayParameters as $arg) {
            $value -= floatval($arg);
        }
        return $value;
    }

    /**
     * @return float|int
     */
    public static function divide() {
        $arrayParameters = func_get_args();
        $value = static::array_pull($arrayParameters, 0, 0);
        foreach ($arrayParameters as $arg) {
            $value /= floatval($arg);
        }
        return $value;
    }

    /**
     * @return float|int
     */
    public static function multiply() {
        $arrayParameters = func_get_args();
        $value = static::array_pull($arrayParameters, 0, 0);
        foreach ($arrayParameters as $arg) {
            $value *= floatval($arg);
        }
        return $value;
    }

    /**
     * @return int
     */
    public static function random() {
        $arrayParameters = func_get_args();
        return mt_rand(static::array_get($arrayParameters, 0, 0), static::array_get($arrayParameters, 1, 100));
    }
}