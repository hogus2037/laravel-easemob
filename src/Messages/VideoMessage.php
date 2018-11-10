<?php

namespace Hogus\LaravelEasemob\Messages;


/**
 * Class VideoMessage
 * @package Hogus\LaravelEasemob\Messages
 */
class VideoMessage extends Messages
{
    // 发送视频消息，需要先上传视频文件和视频缩略图文件，然后再发送此消息
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
    protected $length = 10;//视频播放长度

    /**
     * @var
     */
    protected $thumb;//成功上传视频缩略图返回的UUID
    /**
     * @var int
     */
    protected $file_length = 10;//视频文件大小
    /**
     * @var
     */
    protected $thumb_secret;//成功上传视频缩略图后返回的secret

    /**
     * @return mixed|string
     */
    public function msgType()
    {
        return 'video';
    }

    /**
     * @return array|mixed
     * @throws \Hogus\LaravelEasemob\Exceptions\InvalidArgumentException
     */
    public function getMsg()
    {
        $this->validate('uuid', 'filename', 'secret', 'thumb', 'thumb_secret');

        return [
            'type' => $this->msgType(),
            'url' => $this->easemob->getBaseUri() .'chatfiles/'. $this->getUuid(),
            'filename' => $this->getFilename(),
            'length' => $this->getLength(),
            'secret' => $this->getSecret(),
            'thumb' => $this->easemob->getBaseUri() .'chatfiles/'. $this->getThumb(),
            'file_length' => $this->getFileLength(),
            'thumb_secret' => $this->getThumbSecret()

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

    /**
     * @param $thumb
     * @return $this
     */
    public function thumb($thumb)
    {
        $this->thumb = $thumb;

        return $this;
    }

    /**
     * @param $thumb
     */
    public function setThumb($thumb)
    {
        $this->thumb = $thumb;
    }

    /**
     * @return mixed
     */
    public function getThumb()
    {
        return $this->thumb;
    }

    /**
     * @param $fileLength
     * @return $this
     */
    public function fileLength($fileLength)
    {
        $this->file_length = $fileLength;

        return $this;
    }

    /**
     * @param $fileLength
     */
    public function setFileLength($fileLength)
    {
        $this->file_length = $fileLength;
    }

    /**
     * @return int
     */
    public function getFileLength()
    {
        return $this->file_length;
    }

    /**
     * @param $thumb_secret
     * @return $this
     */
    public function thumbSecret($thumb_secret)
    {
        $this->thumb_secret = $thumb_secret;

        return $this;
    }

    /**
     * @param $thumb_secret
     */
    public function setThumbSecret($thumb_secret)
    {
        $this->thumb_secret = $thumb_secret;
    }

    /**
     * @return mixed
     */
    public function getThumbSecret()
    {
        return $this->thumb_secret;
    }
}
