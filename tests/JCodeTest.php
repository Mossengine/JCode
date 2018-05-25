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

    public function testIfSingletonable() {
        $this->assertTrue(Mossengine\JCode\JCode::Instance() instanceof Mossengine\JCode\JCode);
    }
}