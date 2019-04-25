<?php
/**
 * Created by PhpStorm.
 * User: yinchuanjiang
 * Date: 2018/10/16
 * Time: 下午10:06
 */
namespace App\Http\Proxy;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

class TokenProxy
{
    protected $http;

    /**
     * TokenProxy constructor.
     * @param Client $http
     */
    public function __construct(Client $http)
    {
        $this->http = $http;
    }

    public function login($openid,$password)
    {
        return $this->proxy('password',[
            'username' => $openid,
            'password' => $password,
            'scope' => ''
        ]);
    }

    public function proxy($grantType, array $data = [])
    {
        $data = array_merge($data, [
            'client_id' => env('PASSPORT_Client_ID'),
            'client_secret' => env('PASSPORT_Client_Secret'),
            'grant_type' => $grantType,
            'scope' => ''
        ]);
        try {
            $response = $this->http->post(url('oauth/token'), [
                'form_params' => $data
            ]);
            $token = json_decode((string)$response->getBody(), true);
            return [
                'token' => $token['access_token'],
                'expires_in' => $token['expires_in'],
                'refresh_token' => $token['refresh_token']
            ];
        }catch (ClientException $clientException){
            return false;
        }
        //->cookie('refreshToken',$token['refresh_token'],14400,null,null,false,true);
    }

    //刷新
    public function refresh($refreshToken)
    {
        return $this->proxy('refresh_token',[
            'refresh_token' =>  $refreshToken
        ]);
    }
}