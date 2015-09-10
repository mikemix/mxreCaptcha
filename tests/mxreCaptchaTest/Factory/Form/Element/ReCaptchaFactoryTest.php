<?php
namespace mxreCaptchaTest\Factory\Form\Element;

use mxreCaptcha\Factory\Form\Element\ReCaptchaFactory;
use Zend\ServiceManager\AbstractPluginManager;

class ReCaptchaFactoryTest extends \PHPUnit_Framework_TestCase
{
    /** @var ReCaptchaFactory */
    private $factory;

    public function setUp()
    {
        $this->factory = new ReCaptchaFactory();
    }

    public function testFailWithoutConfiguredPublicKey()
    {
        $serviceLocator = $this->getServiceLocator();

        $serviceLocator->expects($this->once())
            ->method('get')->with($this->equalTo('config'))
            ->will($this->returnValue(['mxreCaptcha' => ['sitekey' => '']]));

        $this->setExpectedException(\InvalidArgumentException::class);
        $this->factory->createService($serviceLocator);
    }

    public function testCreateServiceWithConfiguredPublicKey()
    {
        $serviceLocator = $this->getServiceLocator();

        $serviceLocator->expects($this->once())
            ->method('get')->with($this->equalTo('config'))
            ->will($this->returnValue(['mxreCaptcha' => ['sitekey' => 'ABC']]));

        $service = $this->factory->createService($serviceLocator);
        
        $this->assertEquals('ABC', $service->getSiteKey());
    }

    private function getServiceLocator()
    {
        $mock = $this->getMockBuilder(AbstractPluginManager::class)
            ->setMethods(['getServiceLocator', 'get'])
            ->getMockForAbstractClass();

        $mock->expects($this->any())
            ->method('getServiceLocator')
            ->will($this->returnSelf());

        return $mock;
    }
}
