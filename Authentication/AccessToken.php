<?php

namespace PageCall\Authentication;
use PageCall\Exceptions\PageCallAuthenticationException;
use PageCall\Exceptions\PageCallAuthenticationTokenExpiredException;

/**
 * Class AccessToken
 * @package PageCall\Authentication
 * Copyright 2018 ppLINK(https://www.pplink.net/), Inc.
 */
class AccessToken
{
    public $tokenInformation;
    private $accessKey;
    private $secretKey;

    /**
     * AccessToken constructor.
     * @param string $accessKey
     * @param string $secretKey
     * @throws PageCallAuthenticationException
     */
    public function __construct(string $accessKey, string $secretKey)
    {
        $this->accessKey = $accessKey;
        $this->secretKey = $secretKey;

        $this->tokenInformation = $this->getTokenFromPCA();
    }

    /**
     * @return array
     * @throws PageCallAuthenticationException
     * @throws \Exception
     */
    private function getTokenFromPCA(): array
    {
        $ch = curl_init(__PAGE_CALL_API_ENDPOINT__.'authentication/token');
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
            'apiKey' => $this->accessKey,
            'apiSecret' => $this->secretKey
        ]));
        $response = json_decode(curl_exec($ch), true);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ( (int)substr($httpCode, 0, 1) !== 2 ) {
            throw new PageCallAuthenticationException(curl_error($ch), $httpCode);
        }

        $date = new \DateTime();
        $date->add(new \DateInterval('PT'.$response['exp'].'S'));

        return array_merge($response, ['expiredAt' => $date->getTimestamp()]);
    }

    /**
     * @param array $accessTokenInformation
     * @return bool
     * @throws PageCallAuthenticationTokenExpiredException
     */
    public static function validate(array $accessTokenInformation): bool
    {
        // safe padding 1 minutes
        if ( $accessTokenInformation['expiredAt'] < ( (new \DateTime())->getTimestamp() - (1 * 60)) ) {
            throw new PageCallAuthenticationTokenExpiredException(null, 401);
        }
        return true;
    }
}