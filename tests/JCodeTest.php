<?php

/**
 * Class JCodeTest
 */
class JCodeTest extends PHPUnit_Framework_TestCase
{

    public function testIfConstructable() {
        $classJCode = new Mossengine\JCode\JCode;
        $this->assertTrue($classJCode instanceof Mossengine\JCode\JCode);
        unset($classJCode);
    }

    public function testJCodeVariableSet() {
        $classJCode = new Mossengine\JCode\JCode;
        $classJCode->execute(json_encode([
            'variables' => [
                'boolResult' => false
            ],
            'instructions' => [
                [
                    'type' => 'variables',
                    'variables' => [
                        [
                            'variable' => 'boolResult',
                            'type' => 'value',
                            'value' => true
                        ]
                    ]
                ]
            ]
        ]));

        $this->assertTrue(true === $classJCode->variable('boolResult'));
        unset($classJCode);
    }

    public function testJCodeCondtions() {
        $classJCode = new Mossengine\JCode\JCode;
        $classJCode->execute(json_encode([
            'variables' => [
                'intLeft' => 5,
                'boolResult' => false
            ],
            'instructions' => [
                [
                    'type' => 'conditions',
                    'conditions' => [
                        [
                            'type' => 'compare',
                            'left' => [
                                'type' => 'variable',
                                'variable' => 'intLeft'
                            ],
                            'operator' => '>',
                            'right' => [
                                'type' => 'value',
                                'value' => 4
                            ],
                        ],
                        [
                            'type' => 'compare',
                            'left' => [
                                'type' => 'variable',
                                'variable' => 'intLeft'
                            ],
                            'operator' => '>=',
                            'right' => [
                                'type' => 'value',
                                'value' => 5
                            ],
                        ],
                        [
                            'type' => 'compare',
                            'left' => [
                                'type' => 'variable',
                                'variable' => 'intLeft'
                            ],
                            'operator' => '==',
                            'right' => [
                                'type' => 'value',
                                'value' => 5
                            ],
                        ],
                        [
                            'type' => 'compare',
                            'left' => [
                                'type' => 'variable',
                                'variable' => 'intLeft'
                            ],
                            'operator' => '!=',
                            'right' => [
                                'type' => 'value',
                                'value' => 6
                            ],
                        ],
                        [
                            'type' => 'compare',
                            'left' => [
                                'type' => 'variable',
                                'variable' => 'intLeft'
                            ],
                            'operator' => '<',
                            'right' => [
                                'type' => 'value',
                                'value' => 6
                            ],
                        ],
                        [
                            'type' => 'compare',
                            'left' => [
                                'type' => 'variable',
                                'variable' => 'intLeft'
                            ],
                            'operator' => '<=',
                            'right' => [
                                'type' => 'value',
                                'value' => 5
                            ],
                        ]
                    ],
                    'validation' => 'all',
                    'instructions' => [
                        [
                            'type' => 'variables',
                            'variables' => [
                                [
                                    'variable' => 'boolResult',
                                    'type' => 'value',
                                    'value' => true
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ]));

        $this->assertTrue(true === $classJCode->variable('boolResult'));
        unset($classJCode);
    }
}