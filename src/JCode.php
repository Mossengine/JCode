<?php

namespace Mossengine\JCode;

use Illuminate\Support\Arr;

/**
 * Class JCode
 * @package Mossengine\JCode
 */
final class JCode
{
    /**
     * Call this method to get singleton
     *
     * @return JCode
     */
    public static function Instance($arrayParameters = []) {
        static $inst = null;
        if ($inst === null) {
            $inst = new JCode($arrayParameters);
        }
        return $inst;
    }

    /**
     * Swagabase constructor.
     */
    public function __construct($arrayParameters = []) {
        // Setup goes here...
    }

    /**
     * Class helper function to get objects at array key
     *
     * @param $array
     * @param $key
     * @param null $default
     * @return mixed
     */
    protected function array_get($array, $key, $default = null) {
        return Arr::get($array, $key, $default);
    }

    /**
     * Class helper function to check if an array has a key with an object
     *
     * @param $array
     * @param $keys
     * @return bool
     */
    protected function array_has($array, $keys) {
        return Arr::has($array, $keys);
    }

    /**
     * Class helper function to forget the object at a key
     *
     * @param $array
     * @param $keys
     */
    protected function array_forget(&$array, $keys) {
        Arr::forget($array, $keys);
    }

    /**
     * @param array $arrayParameters
     */
    public function execute($arrayParameters = []) {

    }
}