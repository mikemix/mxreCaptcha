<?php
namespace mxreCaptchaTest\View\Helper;

use mxreCaptcha\Form\Element\ReCaptcha;
use mxreCaptcha\View\Helper\ReCaptchaElement;
use Zend\View\Renderer\RendererInterface;

class ReCaptchaElementTest extends \PHPUnit_Framework_TestCase
{
    public function testInvoke()
    {
        $element = $this->getMockBuilder(ReCaptcha::class)
            ->setMethods(['getSiteKey', 'getOptions'])
            ->disableOriginalConstructor()
            ->getMock();

        $element->expects($this->once())
            ->method('getSiteKey')
            ->will($this->returnValue('ABC'));

        $element->expects($this->once())
            ->method('getOptions')
            ->will($this->returnValue([
                'customOption' => 'value'
            ]));

        $view = $this->getMockBuilder(RendererInterface::class)
            ->setMethods(['render'])
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();

        $view->expects($this->once())
            ->method('render')
            ->with(
                $this->equalTo('mxreCaptcha/element'),
                $this->equalTo([
                    'element' => $element,
                    'options' => json_encode(['sitekey' => 'ABC', 'customOption' => 'value'])
                ]))
            ->will($this->returnValue('html'));

        $helper = new ReCaptchaElement();
        $helper->setView($view);
        $this->assertEquals('html', $helper->__invoke($element));
    }
}
