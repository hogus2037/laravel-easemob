<?php

namespace Hogus\LaravelEasemob\Messages;


/**
 * Class ImgMessage
 * @package Hogus\LaravelEasemob\Messages
 */
class ImgMessage extends Messages
{
    /**
     * @var
     */
    protected $uuid;
    /**
     * @var
     */
    protected $filename;
    /**
     * @var
     */
    protected $secret;
    /**
     * @var int
     */
    protected $width = 480;
    /**
     * @var int
     */
    protected $height = 720;

    /**
     * @return string
     */
    public function msgType()
    {
        return 'img';
    }

    /**
     * @return array
     * @throws \Hogus\LaravelEasemob\Exceptions\InvalidArgumentException
     */
    public function getMsg()
    {
        $this->validate('uuid','filename','secret');

        return [
            'type' => $this->msgType(),
            'url' => $this->easemob->getBaseUri() .'chatfiles/'.$this->getUuid(),
            'filename' => $this->getFilename(),
            'secret' => $this->getSecret(),
            'size' => $this->getSize(),
        ];
    }

    /**
     * @param $uuid
     * @return $this
     */
    public function uuid($uuid)
    {
        $this->uuid = $uuid;

        return $this;
    }

    /**
     * @param $uuid
     */
    public function setUuid($uuid)
    {
        $this->uuid = $uuid;
    }

    /**
     * @return mixed
     */
    public function getUuid()
    {
        return $this->uuid;
    }

    /**
     * @param $filename
     * @return $this
     */
    public function filename($filename)
    {
        $this->filename = $filename;

        return $this;
    }

    /**
     * @param $filename
     */
    public function setFilename($filename)
    {
        $this->filename = $filename;
    }

    /**
     * @return mixed
     */
    public function getFilename()
    {
        return $this->filename;
    }

    /**
     * @param $secret
     * @return $this
     */
    public function secret($secret)
    {
        $this->secret = $secret;

        return $this;
    }

    /**
     * @param $secret
     */
    public function setSecret($secret)
    {
        $this->secret = $secret;
    }

    /**
     * @return mixed
     */
    public function getSecret()
    {
        return $this->secret;
    }

    /**
     * @param $width
     * @param $height
     * @return $this
     */
    public function size($width, $height)
    {
        $this->width = $width;

        $this->height = $height;

        return $this;
    }

    /**
     * @param $width
     * @param $height
     */
    public function setSize($width, $height)
    {
        $this->width = $width;

        $this->height = $height;
    }

    /**
     * @return array
     */
    public function getSize()
    {
        return [
            'width' => $this->width,
            'height' => $this->height
        ];
    }

    /**
     * @param $value
     */
    public function setWidth($value)
    {
        $this->width = $value;
    }

    /**
     * @param $value
     */
    public function setHeight($value)
    {
        $this->height = $value;
    }


}
