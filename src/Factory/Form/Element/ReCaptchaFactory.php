<?php
namespace mxreCaptcha\Factory\Form\Element;

use mxreCaptcha\Form\Element\ReCaptcha;
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

        if (!isset($config['mxreCaptcha']['sitekey'])) {
            throw new \InvalidArgumentException('mxreCaptcha.sitekey is missing');
        }

        $element = new ReCaptcha();
        $element->setSiteKey($config['mxreCaptcha']['sitekey']);

        return $element;
    }
}
