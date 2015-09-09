<?php
namespace mxreCaptcha\Provider;

class CurlProvider implements ProviderInterface
{
	const URL = 'https://www.google.com/recaptcha/api/siteverify';
	
	public function __construct($url = self::URL)
	{
		$this->url = $url;
	}
	
    public function isResponseValid($secret, $response, $ip)
    {
        $ch = curl_init($this->url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, [
            'secret'   => $secret,
            'response' => $response,
            'remoteip' => $ip
        ]);

        $verification = json_decode(curl_exec($ch));
        curl_close($ch);

        if (isset($verification->success) && $verification->success) {
            return true;
        }

        return false;
    }
}
