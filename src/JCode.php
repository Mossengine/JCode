<?php

namespace Mossengine\JCode;

/**
 * Class JCode
 * @package Mossengine\JCode
 */
class JCode
{
    use ArrTrait;

    /**
     * @var array
     */
    private $arrayVariables = [];

    /**
     * @var array
     */
    private $arraySupportedJCodeFunctions = [
        'php.rand' => 'rand',

        'math.addition' => '\Mossengine\JCode\Math::addition',
        'math.subtract' => '\Mossengine\JCode\Math::subtract',
        'math.divide' => '\Mossengine\JCode\Math::divide',
        'math.multiply' => '\Mossengine\JCode\Math::multiply'
    ];

    /**
     * Swagabase constructor.
     */
    public function __construct($arrayParameters = []) {
        // Setup goes here...
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
                case 'instructions':
                    $this->instructions($this->array_get($arrayInstruction, 'instructions', []));
                    break;
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
                case 'iterators':
                    $this->iterators($this->array_get($arrayInstruction, 'iterators', []));
                    break;
            }
        }
    }

    public function variable($name = null, $value = 'SuperCatMonkeyHotDog') {
        if ('SuperCatMonkeyHotDog' !== $value) {
            if (!is_null($value)) {
                $this->array_set($this->arrayVariables, $name, $value);
            } else {
                $this->array_forget($this->arrayVariables, $name);
            }
        }
        return $this->array_get($this->arrayVariables, $name, null);
    }

    private function variables(array $arrayVariables = []) {
        foreach ($arrayVariables as $arrayVariable) {
            switch ($this->array_get($arrayVariable, 'type', null)) {
                case 'variable':
                    $this->variable($this->array_get($arrayVariable, 'variable', 'default'), $this->variable($this->array_get($arrayVariable, 'variable', 'default')));
                    break;
                case 'value':
                    $this->variable($this->array_get($arrayVariable, 'variable', 'default'), $this->array_get($arrayVariable, 'value', null));
                    break;
            }
        }
    }

    private function functions(array $arrayFunctions = []) {
        foreach ($arrayFunctions as $arrayFunction) {
            if ($this->array_has($arrayFunction, 'parameters')) {
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
            } else {
                $arrayParameters = [];
            }

            $result = null;

            if (in_array($this->array_get($arrayFunction, 'type', null), array_keys($this->arraySupportedJCodeFunctions))) {
                $result = call_user_func($this->array_get($this->arraySupportedJCodeFunctions, $this->array_get($arrayFunction, 'type', null), null), $arrayParameters);
            }

            if (!empty($result)) {
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

    private function iterators(array $arrayIterators = []) {
        foreach ($arrayIterators as $arrayIterator) {
            $this->variable('iterate.key', null);
            $this->variable('iterate.value', null);
            switch ($this->array_get($arrayIterator, 'type', null)) {
                case 'for':
                    for (
                        $i = $this->array_get($arrayIterator, 'start', 1);
                        $i < $this->array_get($arrayIterator, 'limit', 10);
                        $i += $this->array_get($arrayIterator, 'step', 1)
                    ) {
                        $this->variable('iterate.key', $i);
                        $this->instructions($this->array_get($arrayIterator, 'instructions', []));
                    }
                    break;
                case 'each':
                    $arrayToIterate = [];
                    switch ($this->array_get($arrayIterator, 'each', null)) {
                        case 'variable':
                            $arrayToIterate = $this->variable($this->array_get($arrayIterator, 'variable', 'default'));
                            break;
                        case 'value':
                            $arrayToIterate = $this->array_get($arrayIterator, 'value', []);
                            break;
                    }

                    if (is_array($arrayToIterate)) {
                        foreach ($arrayToIterate as $mixedIterateKey => $mixedIterateValue) {
                            $this->variable('iterate.key', $mixedIterateKey);
                            $this->variable('iterate.value', $mixedIterateValue);
                            $this->instructions($this->array_get($arrayIterator, 'instructions', []));
                        }
                    }
                    break;
            }
        }
    }
}