<?php
namespace mxreCaptcha\Provider;

interface ProviderInterface
{
    public function isResponseValid($secret, $response, $ip);
}
