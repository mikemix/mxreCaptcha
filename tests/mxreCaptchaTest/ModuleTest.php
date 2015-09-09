<?php
namespace mxreCaptchaTest;

use mxreCaptcha\Module;

class ModuleTest extends \PHPUnit_Framework_TestCase
{
    public function testGetConfig()
    {
        $module = new Module();
        $this->assertInternalType('array', $module->getConfig());
    }
}
