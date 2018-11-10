<?php

namespace Hogus\LaravelEasemob\Messages;


/**
 * Class TextMessage
 * @package Hogus\LaravelEasemob\Messages
 */
class TextMessage extends Messages
{
    /**
     * @var
     */
    protected $content;

    /**
     * @return mixed|string
     */
    public function msgType()
    {
        return 'txt';
    }

    /**
     * @return array|mixed
     * @throws \Hogus\LaravelEasemob\Exceptions\InvalidArgumentException
     */
    public function getMsg()
    {
        $this->validate('content');

        return [
            'type' => $this->msgType(),
            'msg' => $this->getContent()
        ];
    }

    /**
     * @param $value
     * @return $this
     */
    public function content($value)
    {
        $this->content = $value;

        return $this;
    }

    /**
     * @param $value
     */
    public function setContent($value)
    {
        $this->content = $value;
    }


    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }
}
