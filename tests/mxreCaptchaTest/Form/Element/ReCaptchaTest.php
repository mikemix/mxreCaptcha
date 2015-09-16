<?php
namespace mxreCaptchaTest\Form\Element;

use mxreCaptcha\Form\Element\ReCaptcha;

class ReCaptchaTest extends \PHPUnit_Framework_TestCase
{
    /** @var ReCaptcha */
    private $element;

    public function setUp()
    {
        $this->element = new ReCaptcha();
    }

    public function testSetSiteKey()
    {
        $reference = $this->element->setSiteKey('ABC');

        $this->assertSame('ABC', $this->element->getSiteKey());
        $this->assertSame($reference, $this->element);
    }

    public function testGetSpecification()
    {
        $this->assertInternalType('array', $this->element->getInputSpecification());
    }
}
