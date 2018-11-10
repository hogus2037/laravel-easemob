<?php

namespace Hogus\LaravelEasemob\Messages;

use Hogus\LaravelEasemob\Easemob;
use Hogus\LaravelEasemob\Exceptions\InvalidArgumentException;

/**
 * Class Messages
 * @package Hogus\LaravelEasemob\Messages
 */
abstract class Messages
{
    /**
     * @var array
     */
    protected static $targetTypes = ['users', 'chatgroups', 'chatrooms'];
    /**
     * @var string
     */
    protected $target_type = 'users';
    /**
     * @var array
     */
    protected $target = [];
    /**
     * @var string
     */
    protected $from = 'admin';
    /**
     * @var
     */
    protected $ext;

    /**
     * @var Easemob
     */
    protected $easemob;

    /**
     * @var
     */
    protected $parameter;

    /**
     * Messages constructor.
     * @param Easemob $easemob
     */
    public function __construct(Easemob $easemob)
    {
        $this->easemob = $easemob;
    }

    /**
     * @return mixed
     */
    abstract function msgType();

    /**
     * @return mixed
     */
    abstract function getMsg();


    /**
     * @return string
     */
    public function getTargetType()
    {
        return $this->target_type;
    }

    /**
     * @return array
     */
    public function getTarget()
    {
        return $this->target;
    }

    /**
     * @return string
     */
    public function getFrom()
    {
        return $this->from;
    }

    /**
     * @param $value
     * @return $this
     */
    public function targetType($value)
    {
        $this->target_type = $value;

        return $this;
    }

    /**
     * @param $value
     */
    public function setTargetType($value)
    {
        $this->target_type = $value;
    }

    /**
     * @param $value
     * @return $this
     */
    public function target($value)
    {
        $this->target = is_array($value) ? $value : func_get_args();

        return $this;
    }

    /**
     * @param $value
     */
    public function setTarget($value)
    {
        $this->target = is_array($value) ? $value : func_get_args();
    }

    /**
     * @param $value
     * @return $this
     */
    public function from($value)
    {
        $this->from = $value;

        return $this;
    }

    /**
     * @param $value
     */
    public function setFrom($value)
    {
        $this->from = $value;
    }

    /**
     * @return mixed
     */
    public function getExt()
    {
        return $this->ext;
    }

    /**
     * @param $value
     */
    public function setExt($value)
    {
        $this->ext = $value;
    }

    /**
     * @param $value
     * @return $this
     */
    public function ext($value)
    {
        $this->ext = $value;

        return $this;
    }

    /**
     * @return array
     * @throws InvalidArgumentException
     */
    public function send()
    {
        $this->validate('from', 'target');

        $target_type = $this->getTargetType();
        if (!in_array($target_type, static::$targetTypes))
            throw new InvalidArgumentException('target_type not in:' . implode(',', static::$targetTypes));

        $options = [
            'target_type' => $target_type,
            'target'      => $this->getTarget(),
            'from'        => $this->getFrom(),
            'msg'         => $this->getMsg(),
        ];

        if (!is_null($this->getExt()) || !empty($this->getExt())) {
            $options = array_merge($options, ['ext' => $this->getExt()]);
        }

        return $options;

    }

    /**
     * @param array $data
     * @return array
     * @throws InvalidArgumentException
     */
    public function sendData(array $data)
    {
        foreach ($data as $key => $value) {
            $method = 'set' . ucfirst(camel_case($key));
            if (method_exists($this, $method)) {
                $this->$method($value);
            } else {
                throw new InvalidArgumentException("Method $method is not found");
            }

        }

        return $this->send();
    }

    /**
     * @throws InvalidArgumentException
     */
    protected function validate()
    {
        foreach (func_get_args() as $key) {
            $method = "get" . ucfirst(camel_case($key));
            $value = $this->$method();
            if (empty($value) || is_null($value))
                throw new InvalidArgumentException("$key is required");

        }
    }
}
