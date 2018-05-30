# JCode

[![Latest Stable Version](https://poser.pugx.org/mossengine/jcode/v/stable)](https://packagist.org/packages/mossengine/jcode)
[![Latest Unstable Version](https://poser.pugx.org/mossengine/jcode/v/unstable)](https://packagist.org/packages/mossengine/jcode)
[![License](https://poser.pugx.org/mossengine/jcode/license)](https://packagist.org/packages/mossengine/jcode)
[![composer.lock](https://poser.pugx.org/mossengine/jcode/composerlock)](https://packagist.org/packages/mossengine/jcode)

[![Build Status](https://travis-ci.org/Mossengine/JCode.svg?branch=master)](https://travis-ci.org/Mossengine/JCode)
[![codecov](https://codecov.io/gh/Mossengine/JCode/branch/master/graph/badge.svg)](https://codecov.io/gh/Mossengine/JCode)

[![Total Downloads](https://poser.pugx.org/mossengine/jcode/downloads)](https://packagist.org/packages/mossengine/jcode)
[![Monthly Downloads](https://poser.pugx.org/mossengine/jcode/d/monthly)](https://packagist.org/packages/mossengine/jcode)
[![Daily Downloads](https://poser.pugx.org/mossengine/jcode/d/daily)](https://packagist.org/packages/mossengine/jcode)

PHP Class to enable JSON driven programmatic instructions to execute controlled php code in the backend. 


## Functions
### __constructor()
```php
<?php
// Currently no constructor but one will be here soon to support limits and settings.
```

## Installation

### With Composer

```
$ composer require mossengine/swagabase
```

```json
{
    "require": {
        "mossengine/jcode": "~1.0.0"
    }
}
```

```php
<?php
// Require the autoloader, normal composer stuff
require 'vendor/autoload.php';

// Instantiate a Jcode class
$classJCode = new Mossengine\JCode\JCode;

// Execute an array of JCode directly into the class
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
```


### Without Composer

Why are you not using [composer](http://getcomposer.org/)? Download [Jcode.php](https://github.com/Mossengine/JCode/blob/master/src/JCode.php) from the repo and save the file into your project path somewhere. This project does not support composerless environments.


### String JSON

Instead of PHP Associative Array you can also just send in JSON stringify structure and to save you the time we decode it for you.

```php
$classJCode->executeJson('{"variables":{"boolResult":false},"instructions":[{"type":"variables","variables":[{"variable":"boolResult","type":"value","value":true}]}]}');
```


### Getting back the results

Simply call on the variable function and define a variable key to get a specific key value back or no defined key and you will get all the variables back

```php
$mixedValue = $classJCode->variable('boolResult');

$arrayVariables = $classJCode->variable();
```


### Modify variables

You can also modify variable values or define new variables by using the exact same variable function but provide a second parameter for the value you wish to assign to the variable name

```php
$classJCode->variable('boolResult', false);

$classJCode->variable('stringNewVariable', 'Hello Wolrd is cliché!');

$classJCode->variable(null, [
    'new' => 'array'
]);
```