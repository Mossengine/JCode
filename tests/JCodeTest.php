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
        $classJCode->execute([
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
        ]);

        $this->assertTrue(true === $classJCode->variable('boolResult'));
        unset($classJCode);
    }

    public function testJCodeVariableSetExecuteJson() {
        $classJCode = new Mossengine\JCode\JCode;
        $classJCode->executeJson(json_encode([
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

    public function testJCodeSubInstructions() {
        $classJCode = new Mossengine\JCode\JCode;
        $classJCode->execute([
            'variables' => [
                'boolResult' => false,
            ],
            'instructions' => [
                [
                    'type' => 'instructions',
                    'instructions' => [
                        [
                            'type' => 'instructions',
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
                ]
            ]
        ]);

        $this->assertTrue(true === $classJCode->variable('boolResult'));
        unset($classJCode);
    }

    public function testJCodeCondtions() {
        $classJCode = new Mossengine\JCode\JCode;
        $classJCode->execute([
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
        ]);

        $this->assertTrue(true === $classJCode->variable('boolResult'));
        unset($classJCode);
    }

    public function testJCodeIterateEachVariable() {
        $classJCode = new Mossengine\JCode\JCode([
            'functions' => [
                'mossengine.jcode.math.addition' => '\Mossengine\JCode\Math::addition',
            ]
        ]);
        $classJCode->execute([
            'variables' => [
                'boolResult' => false,
                'intSum' => 0,
                'arrayNumber' => [
                    'five' => 5,
                    'seven' => 7,
                    'nine' => 9,
                    'two' => 2
                ]
            ],
            'instructions' => [
                [
                    'type' => 'iterators',
                    'iterators' => [
                        [
                            'type' => 'each',
                            'each' => 'variable',
                            'variable' => 'arrayNumber',
                            'instructions' => [
                                [
                                    'type' => 'functions',
                                    'functions' => [
                                        [
                                            'parameters' => [
                                                [
                                                    'type' => 'variable',
                                                    'variable' => 'intSum'
                                                ],
                                                [
                                                    'type' => 'variable',
                                                    'variable' => 'iterate.value'
                                                ]
                                            ],
                                            'type' => 'mossengine.jcode.math.addition',
                                            'returns' => [
                                                [
                                                    'type' => 'variable',
                                                    'variable' => 'intSum'
                                                ]
                                            ]
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ]
                ],
                [
                    'type' => 'conditions',
                    'conditions' => [
                        [
                            'type' => 'compare',
                            'left' => [
                                'type' => 'variable',
                                'variable' => 'intSum'
                            ],
                            'operator' => '==',
                            'right' => [
                                'type' => 'value',
                                'value' => 23
                            ]
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
        ]);

        $this->assertTrue(true === $classJCode->variable('boolResult'));
        unset($classJCode);
    }

    public function testJCodeIterateEachValue() {
        $classJCode = new Mossengine\JCode\JCode([
            'functions' => [
                'mossengine.jcode.math.addition' => '\Mossengine\JCode\Math::addition',
            ]
        ]);
        $classJCode->execute([
            'variables' => [
                'boolResult' => false,
                'intSum' => 0
            ],
            'instructions' => [
                [
                    'type' => 'iterators',
                    'iterators' => [
                        [
                            'type' => 'each',
                            'each' => 'value',
                            'value' => [
                                'five' => 5,
                                'seven' => 7,
                                'nine' => 9,
                                'two' => 2
                            ],
                            'instructions' => [
                                [
                                    'type' => 'functions',
                                    'functions' => [
                                        [
                                            'parameters' => [
                                                [
                                                    'type' => 'variable',
                                                    'variable' => 'intSum'
                                                ],
                                                [
                                                    'type' => 'variable',
                                                    'variable' => 'iterate.value'
                                                ]
                                            ],
                                            'type' => 'mossengine.jcode.math.addition',
                                            'returns' => [
                                                [
                                                    'type' => 'variable',
                                                    'variable' => 'intSum'
                                                ]
                                            ]
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ]
                ],
                [
                    'type' => 'conditions',
                    'conditions' => [
                        [
                            'type' => 'compare',
                            'left' => [
                                'type' => 'variable',
                                'variable' => 'intSum'
                            ],
                            'operator' => '==',
                            'right' => [
                                'type' => 'value',
                                'value' => 23
                            ]
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
        ]);

        $this->assertTrue(true === $classJCode->variable('boolResult'));
        unset($classJCode);
    }

    public function testJCodeIterateFor() {
        $classJCode = new Mossengine\JCode\JCode([
            'functions' => [
                'mossengine.jcode.math.addition' => '\Mossengine\JCode\Math::addition',
            ]
        ]);
        $classJCode->execute([
            'variables' => [
                'boolResult' => false,
                'intSumStepOne' => 0,
                'intSumStepTwo' => 0
            ],
            'instructions' => [
                [
                    'type' => 'iterators',
                    'iterators' => [
                        [
                            'type' => 'for',
                            'start' => 5,
                            'limit' => 10,
                            'step' => 1,
                            'instructions' => [
                                [
                                    'type' => 'functions',
                                    'functions' => [
                                        [
                                            'parameters' => [
                                                [
                                                    'type' => 'variable',
                                                    'variable' => 'intSumStepOne'
                                                ],
                                                [
                                                    'type' => 'variable',
                                                    'variable' => 'iterate.index'
                                                ]
                                            ],
                                            'type' => 'mossengine.jcode.math.addition',
                                            'returns' => [
                                                [
                                                    'type' => 'variable',
                                                    'variable' => 'intSumStepOne'
                                                ]
                                            ]
                                        ]
                                    ]
                                ]
                            ]
                        ],
                        [
                            'type' => 'for',
                            'start' => 1,
                            'limit' => 10,
                            'step' => 2,
                            'instructions' => [
                                [
                                    'type' => 'functions',
                                    'functions' => [
                                        [
                                            'parameters' => [
                                                [
                                                    'type' => 'variable',
                                                    'variable' => 'intSumStepTwo'
                                                ],
                                                [
                                                    'type' => 'variable',
                                                    'variable' => 'iterate.index'
                                                ]
                                            ],
                                            'type' => 'mossengine.jcode.math.addition',
                                            'returns' => [
                                                [
                                                    'type' => 'variable',
                                                    'variable' => 'intSumStepTwo'
                                                ]
                                            ]
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ]
                ],
                [
                    'type' => 'conditions',
                    'conditions' => [
                        [
                            'type' => 'compare',
                            'left' => [
                                'type' => 'variable',
                                'variable' => 'intSumStepOne'
                            ],
                            'operator' => '==',
                            'right' => [
                                'type' => 'value',
                                'value' => 45
                            ]
                        ],
                        [
                            'type' => 'compare',
                            'left' => [
                                'type' => 'variable',
                                'variable' => 'intSumStepTwo'
                            ],
                            'operator' => '==',
                            'right' => [
                                'type' => 'value',
                                'value' => 25
                            ]
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
        ]);

        $this->assertTrue(true === $classJCode->variable('boolResult'));
        unset($classJCode);
    }
}