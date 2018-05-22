<?php

namespace App\Services;


use GuzzleHttp\Client;

class OpenWechatService
{

    const GET_ACCESS_TOKEN_URL = "https://api.weixin.qq.com/sns/oauth2/access_token";

    CONST GET_USER_INFO_URL = 'https://api.weixin.qq.com/sns/userinfo';

    public static function getAccessTokenByCode($code)
    {
        $appId = config('wechat.open_platform.default.app_id');
        $appSecret = config('wechat.open_platform.default.secret');
        $client = new Client([
            'query' => [
                'appid' => $appId,
                'secret' => $appSecret,
                'code' => $code,
                'grant_type' => 'authorization_code',
            ]
        ]);

        $result = $client->get(self::GET_ACCESS_TOKEN_URL);
        $html = $result->getBody()->getContents();
        return $html;

    }

    public static function getUserInfo($accessInfo)
    {
        $client = new Client([
            'query' => [
                'access_token' => $accessInfo['access_token'],
                'openid' => $accessInfo['openid'],
            ]
        ]);

        $result = $client->get(self::GET_USER_INFO_URL);
        $html = $result->getBody()->getContents();
        return $html;
    }


}
