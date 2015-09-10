<?php
namespace mxreCaptchaTest\Factory\Form\Element;

use mxreCaptcha\Factory\Form\Element\ReCaptchaFactory;
use mxreCaptcha\Form\Element\ReCaptcha;
use mxreCaptcha\View\Helper\ReCaptchaElement;
use mxreCaptchaTest\MockObject\FormElement;
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

        $serviceLocator->expects($this->at(1))
            ->method('get')->with($this->equalTo('config'))
            ->will($this->returnValue(['mxreCaptcha' => ['sitekey' => '']]));

        $this->setExpectedException(\InvalidArgumentException::class);
        $this->factory->createService($serviceLocator);
    }

    public function testCreateServiceAndConfigureRendererWithConfiguredPublicKey()
    {
        $serviceLocator = $this->getServiceLocator();

        $serviceLocator->expects($this->at(1))
            ->method('get')->with($this->equalTo('config'))
            ->will($this->returnValue(['mxreCaptcha' => ['sitekey' => 'ABC']]));

        $helper = $this->getMock(FormElement::class, ['addClass']);
        $helper->expects($this->once())
            ->method('addClass')->with($this->equalTo(ReCaptcha::class), $this->equalTo(ReCaptchaElement::class));

        $serviceLocator->expects($this->at(2))->method('get')->will($this->returnSelf());
        $serviceLocator->expects($this->at(3))->method('get')->will($this->returnValue($helper));

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
