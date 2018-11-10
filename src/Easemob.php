<?php

namespace Hogus\LaravelEasemob;

use Hogus\LaravelEasemob\Exceptions\GatewayErrorException;
use Hogus\LaravelEasemob\Exceptions\InvalidArgumentException;
use Hogus\LaravelEasemob\Traits\EasemobContacts;
use Hogus\LaravelEasemob\Traits\EasemobGroups;
use Hogus\LaravelEasemob\Traits\EasemobUsers;
use Hogus\LaravelEasemob\Traits\HttpRequest;

/**
 * Class Easemob
 *
 * @package Hogus\LaravelEasemob
 */
class Easemob
{
    use HttpRequest, EasemobGroups, EasemobUsers, EasemobContacts;


    protected $domain;
    protected $org_name;
    protected $app_name;
    protected $client_id;
    protected $client_secret;
    protected $base_uri;


    /**
     * Easemob constructor.
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->domain = $config['domain'];
        $this->org_name = $config['org_name'];
        $this->app_name = $config['app_name'];
        $this->client_id = $config['client_id'];
        $this->client_secret = $config['client_secret'];

        $this->base_uri = $this->getBaseUri();
    }


    /**
     * @return string
     */
    public function getBaseUri()
    {
        return sprintf('%s/%s/%s/', $this->domain, $this->org_name, $this->app_name);
    }



    /**
     * 发送消息
     *
     * 使用方式：
     *  Easemob::messages()->target_type()->to()->content()->from()->send();
     * 或
     *  Easemob::messages()->sendData();
     * @param string $type 消息类型 默认文本消息 可选参数text、img、video、audio、cmd、
     * @return mixed
     * @throws InvalidArgumentException
     */
    public function messages($type = 'text')
    {

        $class = __NAMESPACE__ . '\\Messages\\'.ucfirst($type) .'Message';

        if (! class_exists($class)) {
            //不存在的类
            throw new InvalidArgumentException("Class $class is not found");
        }

        return new $class($this);
    }


    /**
     * 文件上传
     *
     * @param string    $filePath   文件地址
     * @param bool      $access     是否限制访问权限
     * @return array
     * @throws GatewayErrorException
     * array:9 [
    "action" => "post"
    "application" => "3fbea500-5383-11e8-90a0-43fafa040b8e"
    "path" => "/chatfiles"
    "uri" => "https://a1.easemob.com/1194180509099040/tpt-test/chatfiles"
    "entities" => array:1 [
    0 => array:3 [
    "uuid" => "8c519d30-de7c-11e8-a617-09fe7b62dbca"
    "type" => "chatfile"
    "share-secret" => "jFGdOt58EeimLHN69XzLHizu_HMrlyeT-eEjXwLyA_fHfuQ3"
    ]
    ]
    "timestamp" => 1541148714628
    "duration" => 0
    "organization" => "1194180509099040"
    "applicationName" => "tpt-test"
    ]
     */
    public function uploadFile($filePath, $access = false)
    {
        try {
            if($access) $headers = [ 'restrict-access' => 'true'];

            $options = [
                'name' => 'file',
                'contents' => fopen($filePath, 'r')
            ];

            $response = $this->multipart('chatfiles', $options, $this->getAuthorization() + ($headers ?? []));

        } catch (\Exception $e) {
            throw new GatewayErrorException($e->getMessage(), $e->getCode(), $e);
        }

        return $response;
    }

    /**
     * 下载图片、语音、缩略图
     * Easemob::downloadFile($uuid, $shareSecret,$isThumbnail)->save($directory)
     * @param $uuid
     * @param $shareSecret
     * @param bool $isThumbnail
     * @return array|StreamResponse|string
     * @throws GatewayErrorException
     */
    public function downloadFile($uuid, $shareSecret, $isThumbnail = false)
    {
        try {
            $header = [
                'share-secret' => $shareSecret,
                'thumbnail' => $isThumbnail,
                'Accept' =>'application/octet-stream'
            ];
            $response = $this->get('chatfiles/'.$uuid, '', $header+$this->getAuthorization());
        } catch (\Exception $e) {
            throw new GatewayErrorException($e->getMessage(), $e->getCode(), $e);
        }

        return $response;
    }
    /**
     * @return array
     * @throws GatewayErrorException
     */
    public function getAuthorization()
    {
        return ['Authorization' => 'Bearer ' . $this->getToken()];
    }

    /**
     * 登陆 获取token username=test2,password=123456
     *
     * @param string $username
     * @param string $password
     * @return array
     * "access_token" => "YWMtjp3VaN25Eei6vC8MPzJN5D--pQBTgxHokKBD-voEC460XL2Q3aER6JezV1EncQCfAwMAAAFmzqFB2wBPGgD6bXk3W3OrLu3ewvwhv7XxBBU_jVUGlq6d77wXh_jOBA"
     * "expires_in" => 5184000
     * "user" => array:6 [
     * "uuid" => "b45cbd90-dda1-11e8-97b3-57512771009f"
     * "type" => "user"
     * "created" => 1541054722025
     * "modified" => 1541054722025
     * "username" => "test2"
     * "activated" => true
     * ]
     * @throws GatewayErrorException
     */
    public function login($username, $password)
    {
        $options = [
            'grant_type' => 'password',
            'username'   => $username,
            'password'   => $password,
            'timestamp'  => time()
        ];
        try {
            $response = $this->postJson('token', $options);
        } catch (\Exception $e) {
            throw new GatewayErrorException($e->getMessage(), $e->getCode(), $e);
        }

        return $response;
    }

    /**
     * 获取token
     *
     * @see http://docs.easemob.com/im/100serverintegration/20users
     * @return mixed
     * @throws GatewayErrorException
     */
    public function getToken()
    {
        if ($token = \Cache::get('easemob_token')) {
            return $token;
        }
        $options = [
            'grant_type'    => 'client_credentials',
            'client_id'     => $this->client_id,
            'client_secret' => $this->client_secret,
        ];
        try {
            $response = $this->postJson('token', $options);
        } catch (\Exception $e) {
            throw new GatewayErrorException($e->getMessage(), $e->getCode(), $e);
        }

        $token = $response['access_token'];

        \Cache::put('easemob_token', $token, (int)$response['expires_in'] / 60);

        return $token;
    }
}
