<?php

namespace Mossengine\JCode;

/**
 * Class Math
 * @package Mossengine\JCode
 */
class Math
{
    use ArrTrait;

    /**
     * @return float|int
     */
    public static function addition() {
        $value = 0;
        foreach (static::array_get(func_get_args(), 0, []) as $arg) {
            $value += floatval($arg);
        }
        return $value;
    }

    /**
     * @return float|int
     */
    public static function subtract() {
        $value = 0;
        foreach (static::array_get(func_get_args(), 0, []) as $arg) {
            $value -= floatval($arg);
        }
        return $value;
    }

    /**
     * @return float|int
     */
    public static function divide() {
        $value = 0;
        foreach (static::array_get(func_get_args(), 0, []) as $arg) {
            $value /= floatval($arg);
        }
        return $value;
    }

    /**
     * @return float|int
     */
    public static function multiply() {
        $value = 0;
        foreach (static::array_get(func_get_args(), 0, []) as $arg) {
            $value *= floatval($arg);
        }
        return $value;
    }
}