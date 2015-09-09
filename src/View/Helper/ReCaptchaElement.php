<?php
namespace mxreCaptcha\View\Helper;

use mxreCaptcha\Form\Element\ReCaptcha;
use Zend\View\Helper\AbstractHelper;

class ReCaptchaElement extends AbstractHelper
{
    public function __invoke(ReCaptcha $element)
    {
        return $this->getView()->render('mxreCaptcha/element', [
            'element' => $element,
            'options' => json_encode(array_merge(['sitekey' => $element->getSiteKey()], $element->getOptions())),
        ]);
    }
}
