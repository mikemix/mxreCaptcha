<?php
namespace mxreCaptcha\Factory\Form\Element;

use mxreCaptcha\Form\Element\ReCaptcha;
use mxreCaptcha\View\Helper\ReCaptchaElement;
use Zend\ServiceManager\AbstractPluginManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ReCaptchaFactory implements FactoryInterface
{
    /**
     * @param ServiceLocatorInterface $serviceLocator
     * @return ReCaptcha
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        if ($serviceLocator instanceof AbstractPluginManager) {
            $serviceLocator = $serviceLocator->getServiceLocator();
        }

        $config = $serviceLocator->get('config');

        if (empty($config['mxreCaptcha']['sitekey'])) {
            throw new \InvalidArgumentException('mxreCaptcha.sitekey is missing');
        }

        // register custom renderer for the element
        $serviceLocator->get('ViewHelperManager')
            ->get('FormElement')->addClass(ReCaptcha::class, ReCaptchaElement::class);

        $element = new ReCaptcha();
        $element->setSiteKey($config['mxreCaptcha']['sitekey']);

        return $element;
    }
}
