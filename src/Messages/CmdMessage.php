<?php

namespace Hogus\LaravelEasemob\Messages;


/**
 * Class CmdMessage
 * @package Hogus\LaravelEasemob\Messages
 */
class CmdMessage extends Messages
{
    /**
     * @var
     */
    protected $action;

    /**
     * @return string
     */
    public function msgType()
    {
        return 'cmd';
    }

    /**
     * @see http://docs-im.easemob.com/im/100serverintegration/50messages#%E5%8F%91%E9%80%81%E9%80%8F%E4%BC%A0%E6%B6%88%E6%81%AF
     * @return array
     */
    public function getMsg()
    {
        return [
            'type' => $this->msgType(),
            'auction' => $this->getAction()
        ];
    }

    /**
     * @param $action
     * @return $this
     */
    public function action($action)
    {
        $this->action = $action;

        return $this;
    }

    /**
     * @param $action
     */
    public function setAction($action)
    {
        $this->action = $action;
    }

    /**
     * @return mixed
     */
    public function getAction()
    {
        return $this->action;
    }

}
