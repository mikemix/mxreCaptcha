<?php
namespace mxreCaptchaTest\Factory\Validator;

use mxreCaptcha\Validator\ReCaptcha;
use mxreCaptcha\Factory\Validator\ReCaptchaFactory;
use Zend\Http\Request;
use Zend\ServiceManager\AbstractPluginManager;
use Zend\Stdlib\Parameters;

class ReCaptchaFactoryTest extends \PHPUnit_Framework_TestCase
{
    /** @var ReCaptchaFactory */
    private $factory;

    public function setUp()
    {
        $this->factory = new ReCaptchaFactory();
    }

    public function testFailWithoutConfiguredPrivateKey()
    {
        $serviceLocator = $this->getServiceLocator();

        $serviceLocator->expects($this->once())
            ->method('get')->with($this->equalTo('config'))
            ->will($this->returnValue(['mxreCaptcha' => ['secretkey' => '']]));

        $this->setExpectedException(\InvalidArgumentException::class);
        $this->factory->createService($serviceLocator);
    }

    public function testCreateServiceWithConfiguredPrivateKey()
    {
        $request = $this->getMockBuilder(Request::class)->setMethods(['getPost'])->getMock();
        $request->expects($this->once())->method('getPost')->will($this->returnValue(new Parameters([
            'test' => 'value',
        ])));

        $serviceLocator = $this->getServiceLocator();

        $serviceLocator->expects($this->at(1))
            ->method('get')->with($this->equalTo('config'))
            ->will($this->returnValue(['mxreCaptcha' => ['secretkey' => 'ABC']]));

        $serviceLocator->expects($this->at(2))
            ->method('get')->with($this->equalTo('request'))
            ->will($this->returnValue($request));

        $this->assertInstanceOf(ReCaptcha::class, $this->factory->createService($serviceLocator));
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
