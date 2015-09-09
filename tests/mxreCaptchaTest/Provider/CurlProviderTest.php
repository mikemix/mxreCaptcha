<?php
namespace mxreCaptchaTest\Provider;

use mxreCaptcha\Provider\CurlProvider;
use mxreCaptcha\Provider\ProviderInterface;

class CurlProviderTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $this->assertInstanceOf(ProviderInterface::class, new CurlProvider());
    }

    public function testSuccess()
    {
        $provider = new CurlProvider($this->translateToUri(__DIR__ . '/../../resources/CurlSuccess.txt'));
        $this->assertTrue($provider->isResponseValid('secret', 'response', 'ip'));
    }

    public function testFail()
    {
        $provider = new CurlProvider($this->translateToUri(__DIR__ . '/../../resources/CurlFail.txt'));
        $this->assertFalse($provider->isResponseValid('secret', 'response', 'ip'));
    }

    protected function translateToUri($dir)
    {
        return 'file://' . str_replace('\\', '/', str_replace(':', '', $dir));
    }
}
