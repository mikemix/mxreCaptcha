<?php
namespace mxreCaptcha\Validator;

use mxreCaptcha\Provider\CurlProvider;
use mxreCaptcha\Provider\ProviderInterface;
use Zend\Validator\AbstractValidator;
use Zend\Validator\Exception;

class ReCaptcha extends AbstractValidator
{
    const FIELD_NAME = 'g-recaptcha-response';

    /** @var string */
    protected $privateKey;

    /** @var array */
    protected $postValues;

    /** @var ProviderInterface */
    protected $provider;

    /**
     * @param array|null|\Traversable $privateKey
     * @param array $postValues
     */
    public function __construct($privateKey, array $postValues)
    {
        $this->privateKey = $privateKey;
        $this->postValues = $postValues;
    }

    /**
     * @return ProviderInterface
     */
    public function getProvider()
    {
        if (!$this->provider) {
            $this->setProvider(new CurlProvider());
        }

        return $this->provider;
    }

    /**
     * @param ProviderInterface $provider
     */
    public function setProvider(ProviderInterface $provider)
    {
        $this->provider = $provider;
    }

    /**
     * Returns true if and only if $value meets the validation requirements
     *
     * If $value fails validation, then this method returns false, and
     * getMessages() will return an array of messages that explain why the
     * validation failed.
     *
     * @param  mixed $value
     * @return bool
     * @throws Exception\RuntimeException If validation of $value is impossible
     */
    public function isValid($value)
    {
        if (!isset($this->postValues[self::FIELD_NAME]) || empty($response = $this->postValues[self::FIELD_NAME])) {
            return false;
        }

        return $this->getProvider()->isResponseValid($this->privateKey, $response, $_SERVER['REMOTE_ADDR']);
    }
}
