<?php

namespace Hogus\LaravelEasemob\Messages;


/**
 * Class AudioMessage
 * @package Hogus\LaravelEasemob\Messages
 */
class AudioMessage extends Messages
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
    protected $length = 10;

    /**
     * @return string
     */
    public function msgType()
    {
        return 'audio';
    }

    /**
     * @return array
     * @throws \Hogus\LaravelEasemob\Exceptions\InvalidArgumentException
     */
    public function getMsg()
    {
        $this->validate('uuid', 'filename', 'secret');

        return [
            'type' => $this->msgType(),
            'url' => $this->easemob->getBaseUri() .'chatfiles/'. $this->getUuid(),
            'filename' => $this->getFilename(),
            'length' => $this->getLength(),
            'secret' => $this->getSecret()
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
     * @param $length
     * @return $this
     */
    public function length($length)
    {
        $this->length = $length;

        return $this;
    }

    /**
     * @param $length
     */
    public function setLength($length)
    {
        $this->length = $length;
    }

    /**
     * @return int
     */
    public function getLength()
    {
        return $this->length;
    }
}
