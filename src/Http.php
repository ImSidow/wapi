<?php

namespace Imsidow\Wapi;

use GuzzleHttp\Client;

class Http
{
    private string $baseUrl = 'https://api.waafipay.net/asm';

    static public function post(string $url, array $request = [])
    {
        $response = self::client()->post($url, $request);

        return  $response;
    }

    static public function client(): Client
    {
        return new Client(['base_uri' => self::$baseUrl]);
    }
}
