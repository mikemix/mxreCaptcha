<?php
namespace mxreCaptcha\Factory\Validator;

use mxreCaptcha\Validator\ReCaptcha;
use Zend\ServiceManager\AbstractPluginManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ReCaptchaFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return ReCaptcha
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        if ($serviceLocator instanceof AbstractPluginManager) {
            $serviceLocator = $serviceLocator->getServiceLocator();
        }

        $config = $serviceLocator->get('config');

        if (empty($config['mxreCaptcha']['secretkey'])) {
            throw new \InvalidArgumentException('mxreCaptcha.secretkey is missing');
        }

        return new ReCaptcha(
            $config['mxreCaptcha']['secretkey'],
            $serviceLocator->get('request')->getPost()->toArray()
        );
    }
}
