<?php

namespace Mossengine\JCode;

use Illuminate\Support\Arr;

/**
 * Class JCode
 * @package Mossengine\JCode
 */
class JCode
{
    /**
     * @var array
     */
    private $arrayVariables = [];

    /**
     * @var array
     */
    private $arraySupportedFunctions = [
        'rand'
    ];

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
    private function array_get($array, $key, $default = null) {
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
    private function array_set(&$array, $key, $value) {
        return Arr::set($array, $key, $value);
    }

    /**
     * Class helper function to check if an array has a key with an object
     *
     * @param $array
     * @param $keys
     * @return bool
     */
    private function array_has($array, $keys) {
        return Arr::has($array, $keys);
    }

    /**
     * Class helper function to forget the object at a key
     *
     * @param $array
     * @param $keys
     */
    private function array_forget(&$array, $keys) {
        Arr::forget($array, $keys);
    }

    /**
     * @param string $stringJCode
     */
    public function execute($stringJCode = '[]') {
        // decode the JCode string
        $arrayJCode = json_decode($stringJCode, true);

        // Get the variables from the JCode
        $this->arrayVariables = $this->array_get($arrayJCode, 'variables', []);

        // Execute the first layer of instructions from the JCode
        $this->instructions($this->array_get($arrayJCode, 'instructions', []));
    }

    private function instructions(array $arrayInstructions = []) {
        // Process each instruction
        foreach ($arrayInstructions as $arrayInstruction) {
            switch ($this->array_get($arrayInstruction, 'type', null)) {
                case 'variables':
                    $this->variables($this->array_get($arrayInstruction, 'variables', []));
                    break;
                case 'functions':
                    $this->functions($this->array_get($arrayInstruction, 'functions', []));
                    break;
                case 'conditions':
                    if (
                        true === $this->array_get($this->conditions($this->array_get($arrayInstruction, 'conditions', [])), $this->array_get($arrayInstruction, 'validation', 'all'))
                        && $this->array_has($arrayInstruction, 'instructions')
                    ) {
                        $this->instructions($this->array_get($arrayInstruction, 'instructions', []));
                    }
                    break;
            }
        }
    }

    public function variable($name = null, $value = 'SuperCatMonkeyHotDog') {
        if ('SuperCatMonkeyHotDog' !== $value) {
            $this->array_set($this->arrayVariables, $name, $value);
        }
        return $this->array_get($this->arrayVariables, $name);
    }

    private function variables(array $arrayVariables = []) {
        foreach ($arrayVariables as $arrayVariable) {
            $this->variable($this->array_get($arrayVariable, 'variable', 'default'), $this->array_get($arrayVariable, 'value', null));
        }
    }

    private function functions(array $arrayFunctions = []) {
        foreach ($arrayFunctions as $arrayFunction) {
            if (in_array($this->array_get($arrayFunction, 'type', null), $this->arraySupportedFunctions)) {
                $arrayParameters = array_map(
                    function ($arrayParameter) {
                        switch ($this->array_get($arrayParameter, 'type', null)) {
                            case 'variable':
                                return $this->variable($this->array_get($arrayParameter, 'variable', 'default'));
                                break;
                            case 'value':
                                return $this->array_get($arrayParameter, 'value', null);
                                break;
                        }

                        return null;
                    },
                    $this->array_get($arrayFunction, 'parameters', [])
                );
                $result = call_user_func($this->array_get($arrayFunction, 'type', null), $arrayParameters);
                foreach ($this->array_get($arrayFunction, 'returns', []) as $arrayReturn) {
                    switch ($this->array_get($arrayReturn, 'type', null)) {
                        case 'variable':
                            $this->variable($this->array_get($arrayReturn, 'variable', 'default'), $result);
                            break;
                    }
                }
            }
        }
    }

    private function conditions(array $arrayConditions = []) {
        $boolAll = true;
        $boolAny = false;
        foreach ($arrayConditions as $arrayCondition) {
            switch ($this->array_get($arrayCondition, 'type', null)) {
                case 'compare':
                    switch ($this->array_get($arrayCondition, 'left.type', null)) {
                        case 'variable':
                            $mixedLeft = $this->variable($this->array_get($arrayCondition, 'left.variable', 'default'));
                            break;
                        case 'value':
                            $mixedLeft = $this->array_get($arrayCondition, 'left.value', 'BlueBatBerryWalk');
                            break;
                    }
                    switch ($this->array_get($arrayCondition, 'right.type', null)) {
                        case 'variable':
                            $mixedRight = $this->variable($this->array_get($arrayCondition, 'right.variable', 'default'));
                            break;
                        case 'value':
                            $mixedRight = $this->array_get($arrayCondition, 'right.value', 'SandMouseCherryWheel');
                            break;
                    }
                    switch ($this->array_get($arrayCondition, 'operator', null)) {
                        case 'lt':
                        case '<':
                            if ($mixedLeft < $mixedRight) {
                                $boolAny = true;
                            } else {
                                $boolAll = false;
                            }
                            break;
                        case 'lte':
                        case '<=':
                            if ($mixedLeft <= $mixedRight) {
                                $boolAny = true;
                            } else {
                                $boolAll = false;
                            }
                            break;
                        case 'eq':
                        case '==':
                            if ($mixedLeft == $mixedRight) {
                                $boolAny = true;
                            } else {
                                $boolAll = false;
                            }
                            break;
                        case 'neq':
                        case '!=':
                            if ($mixedLeft != $mixedRight) {
                                $boolAny = true;
                            } else {
                                $boolAll = false;
                            }
                            break;
                        case 'gt':
                        case '>':
                            if ($mixedLeft > $mixedRight) {
                                $boolAny = true;
                            } else {
                                $boolAll = false;
                            }
                            break;
                        case 'gte':
                        case '>=':
                            if ($mixedLeft >= $mixedRight) {
                                $boolAny = true;
                            } else {
                                $boolAll = false;
                            }
                            break;
                    }
                    break;
            }
        }
        return ['all' => $boolAll, 'any' => $boolAny];
    }
}