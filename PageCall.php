<?php

namespace PageCall;


use PageCall\Exceptions\PageCallAuthenticationException;
use PageCall\Exceptions\PageCallAuthenticationTokenExpiredException;
use PageCall\Exceptions\PageCallSDKException;
use PageCall\Authentication\AccessToken;

/**
* Type Definitions for PageCall SDK v1.0.4
* Copyright 2018 ppLINK(https://www.pplink.net/), Inc.
*/
final class PageCall implements \PageCall\Interfaces\PageCall
{
    public $config;
    private $accessToken;

    /**
     * PageCall constructor.
     * @param array $config
     * @throws PageCallSDKException
     * @throws Exceptions\PageCallAuthenticationException
     */
    public function __construct(array $config = [])
    {
        if ( !$config['accessKey'] ) {
            throw new PageCallSDKException('Required "AccessKey" key not supplied in config and could not find fallback environment variable');
        }

        if ( !$config['secretKey'] ) {
            throw new PageCallSDKException('Required "SecretKey" key not supplied in config and could not find fallback environment variable');
        }

        $this->config = $config;
        $this->accessToken = new AccessToken($config['accessKey'], $config['secretKey']);
    }


    /**
     * @return array
     * @throws PageCallAuthenticationException
     * @throws PageCallSDKException
     */
    public function onGoing(): array
    {
        try {
            AccessToken::validate($this->accessToken->tokenInformation);
        } catch ( PageCallAuthenticationTokenExpiredException $e ) {
            $this->accessToken = new AccessToken($this->config['accessKey'], $this->config['secretKey']);
        }

        $ch = curl_init(__PAGE_CALL_API_ENDPOINT__.'information/ongoing');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer '. $this->accessToken->tokenInformation['token']
        ]);
        $response = json_decode(curl_exec($ch), true);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if ( (int)substr($httpCode, 0, 1) !== 2 ) {
            throw new PageCallSDKException(curl_error($ch), 401);
        }
        curl_close($ch);

        return $response;
    }


    /**
     * @param array $data
     * @return array
     * @throws PageCallAuthenticationException
     * @throws PageCallSDKException
     */
    public function connectIn(array $data = []): array
    {
        try {
            AccessToken::validate($this->accessToken->tokenInformation);
        } catch ( PageCallAuthenticationTokenExpiredException $e ) {
            $this->accessToken = new AccessToken($this->config['accessKey'], $this->config['secretKey']);
        }

        if ( !$data['userId'] ) {
            throw new PageCallSDKException('"userId" is required.');
        }

        if ( !$data['publicRoomId'] ) {
            throw new PageCallSDKException('"publicRoomId" is required.');
        }

        $ch = curl_init(__PAGE_CALL_API_ENDPOINT__.'connection/in');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer '. $this->accessToken->tokenInformation['token']
        ]);

        $response = (array)json_decode(curl_exec($ch), true);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if ( (int)substr($httpCode, 0, 1) !== 2 ) {
            throw new PageCallSDKException(curl_error($ch), 401);
        }

        curl_close($ch);
        return $response;
    }

    /**
     * @param array $data
     * @return array
     * @throws PageCallAuthenticationException
     * @throws PageCallSDKException
     */
    public function connectReplay(array $data = []): array
    {
        try {
            AccessToken::validate($this->accessToken->tokenInformation);
        } catch ( PageCallAuthenticationTokenExpiredException $e ) {
            $this->accessToken = new AccessToken($this->config['accessKey'], $this->config['secretKey']);
        }

        if ( !$data['roomId'] ) {
            throw new PageCallSDKException('"partnerId" is required.');
        }

        $ch = curl_init(__PAGE_CALL_API_ENDPOINT__.'connection/replay');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer '. $this->accessToken->tokenInformation['token']
        ]);
        $response = (array)json_decode(curl_exec($ch), true);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if ( (int)substr($httpCode, 0, 1) !== 2 ) {
            throw new PageCallSDKException(curl_error($ch), 401);
        }
        curl_close($ch);

        return $response;
    }

    /**
     * @param array $data
     * @return array
     * @throws PageCallAuthenticationException
     * @throws PageCallSDKException
     */
    public function connectReplayLegacy(array $data = []): array
    {
        try {
            AccessToken::validate($this->accessToken->tokenInformation);
        } catch ( PageCallAuthenticationTokenExpiredException $e ) {
            $this->accessToken = new AccessToken($this->config['accessKey'], $this->config['secretKey']);
        }

        if ( !$data['noteFile'] ) {
            throw new PageCallSDKException('"noteFile" is required.');
        }

        $ch = curl_init(__PAGE_CALL_API_ENDPOINT__.'connection/replay-legacy');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer '. $this->accessToken->tokenInformation['token']
        ]);
        $response = (array)json_decode(curl_exec($ch), true);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if ( (int)substr($httpCode, 0, 1) !== 2 ) {
            throw new PageCallSDKException(curl_error($ch), 401);
        }
        curl_close($ch);

        return $response;
    }
}