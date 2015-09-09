<?php
namespace mxreCaptchaTest\Validator;

use mxreCaptcha\Provider\ProviderInterface;
use mxreCaptcha\Validator\ReCaptcha;

class ReCaptchaTest extends \PHPUnit_Framework_TestCase
{
    public function testMissingResponse()
    {
        $validator = new ReCaptcha('ABC', []);

        $this->assertFalse($validator->isValid(''));
    }

    public function testEmptyResponse()
    {
        $validator = new ReCaptcha('ABC', [ReCaptcha::FIELD_NAME => '']);

        $this->assertFalse($validator->isValid(''));
    }

    public function testInvalidResponse()
    {
        $_SERVER['REMOTE_ADDR'] = '10.0.0.1';

        $provider = $this->getMockBuilder(ProviderInterface::class)
            ->setMethods(['isResponseValid'])
            ->getMockForAbstractClass();

        $provider->expects($this->once())
            ->method('isResponseValid')
            ->with(
                $this->equalTo('ABC'),
                $this->equalTo('response'),
                $this->equalTo($_SERVER['REMOTE_ADDR'])
            )
            ->will($this->returnValue(false));

        $validator = new ReCaptcha('ABC', [ReCaptcha::FIELD_NAME => 'response']);
        $validator->setProvider($provider);

        $this->assertFalse($validator->isValid(''));
    }

    public function testValidResponse()
    {
        $_SERVER['REMOTE_ADDR'] = '10.0.0.1';

        $provider = $this->getMockBuilder(ProviderInterface::class)
            ->setMethods(['isResponseValid'])
            ->getMockForAbstractClass();

        $provider->expects($this->once())
            ->method('isResponseValid')
            ->with(
                $this->equalTo('ABC'),
                $this->equalTo('response'),
                $this->equalTo($_SERVER['REMOTE_ADDR'])
            )
            ->will($this->returnValue(true));

        $validator = new ReCaptcha('ABC', [ReCaptcha::FIELD_NAME => 'response']);
        $validator->setProvider($provider);

        $this->assertTrue($validator->isValid(''));
    }
}
