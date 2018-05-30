<?php

namespace Mossengine\JCode;

use Illuminate\Support\Arr;

/**
 * Trait ArrTrait
 * @package Mossengine\JCode
 */
trait ArrTrait
{
    /**
     * Class helper function to get objects at array key
     *
     * @param $array
     * @param $key
     * @param null $default
     * @return mixed
     */
    private static function array_get($array, $key, $default = null) {
        return Arr::get($array, $key, $default);
    }

    /**
     * Class helper function to set objects at array key
     *
     * @param $array
     * @param $key
     * @param $value
     * @return array
     */
    private static function array_set(&$array, $key, $value) {
        return Arr::set($array, $key, $value);
    }

    /**
     * Class helper function to check if an array has a key with an object
     *
     * @param $array
     * @param $keys
     * @return bool
     */
    private static function array_has($array, $keys) {
        return Arr::has($array, $keys);
    }

    /**
     * Class helper function to forget the object at a key
     *
     * @param $array
     * @param $keys
     */
    private static function array_forget(&$array, $keys) {
        Arr::forget($array, $keys);
    }
}