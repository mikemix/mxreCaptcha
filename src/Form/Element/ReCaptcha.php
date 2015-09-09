<?php
namespace mxreCaptcha\Form\Element;

use mxreCaptcha\Validator;
use Zend\Form\Element;
use Zend\InputFilter\InputProviderInterface;

class ReCaptcha extends Element implements InputProviderInterface
{
    /** @var string */
    protected $siteKey;

    /**
     * @param string $siteKey
     * @return $this
     */
    public function setSiteKey($siteKey)
    {
        $this->siteKey = $siteKey;
        return $this;
    }

    /**
     * @return string
     */
    public function getSiteKey()
    {
        return $this->siteKey;
    }

    /**
     * Should return an array specification compatible with
     * {@link Zend\InputFilter\Factory::createInput()}.
     *
     * @return array
     */
    public function getInputSpecification()
    {
        return [
            'name'       => $this->getName(),
            'required'   => true,
            'validators' => [
                ['name' => Validator\ReCaptcha::class],
            ],
        ];
    }
}
