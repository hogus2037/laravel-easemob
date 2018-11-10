<?php

namespace Hogus\LaravelEasemob\Traits;

use Hogus\LaravelEasemob\Exceptions\GatewayErrorException;

trait EasemobUsers
{
    /**
     * 开放注册
     *
     * @param $username
     * @param $password
     * @return array
     * @throws GatewayErrorException
     */
    public function register($username, $password)
    {
        $options = [
            'username' => $username,
            'password' => $password
        ];
        return $this->createUsers($options);
    }

    /**
     * 批量注册
     * $users = [
     *  ['username' => $username,'password' => $password, 'nickname' => $nickname],
     *  ['username' => $username,'password' => $password, 'nickname' => $nickname],
     * ]
     * $auth 是否使用授权模式 建议为true
     * @param array $users
     * @param bool $auth
     * @return array
     * @throws GatewayErrorException
     */
    public function batchRegister(array $users, $auth = false)
    {
        return $this->createUsers($users, $auth ? $this->getAuthorization() : []);
    }
    /**
     * 授权注册
     *
     * @param $username
     * @param $password
     * @return array
     * @throws GatewayErrorException
     */
    public function authorizedRegister($username, $password)
    {
        $options = [
            'username' => $username,
            'password' => $password
        ];
        return $this->createUsers($options, $this->getAuthorization());
    }

    /**
     * @param $options
     * @param array $headers
     * @return array
     * @throws GatewayErrorException
     */
    public function createUsers($options, $headers = [])
    {
        try {
            $response = $this->postJson('users', $options, $headers);
        } catch (\Exception $e) {
            throw new GatewayErrorException($e->getMessage(), $e->getCode(), $e);
        }

        return $response;
    }

    /**
     * 获取单个用户
     *
     * @param $username
     * @return mixed
     * @throws GatewayErrorException
     */
    public function getUser($username)
    {
        try {
            $response = $this->get("users/{$username}", [], $this->getAuthorization());
        } catch (\Exception $e) {
            throw new GatewayErrorException($e->getMessage(), $e->getCode(), $e);
        }

        return $response;
    }

    /**
     * 分页获取用户
     *
     * @param int $limit
     * @param string $cursor
     * @return mixed
     * @throws GatewayErrorException
     */
    public function getUsers($limit = 0, $cursor = '')
    {
        try {
            $options = (!empty($limit) || !empty($cursor)) ? ['limit' => $limit, 'cursor' => $cursor] : '';
            $response = $this->get('users', $options, $this->getAuthorization());
        } catch (\Exception $e) {
            throw new GatewayErrorException($e->getMessage(), $e->getCode(), $e);
        }

        return $response;
    }

    /**
     * 删除特定用户
     *
     * @param $username
     * @return mixed
     * @throws GatewayErrorException
     */
    public function deleteUser($username)
    {
        try {
            $response = $this->request('delete', "users/{$username}", [
                'headers' => $this->getAuthorization(),
            ]);
        } catch (\Exception $e) {
            throw new GatewayErrorException($e->getMessage(), $e->getCode(), $e);
        }

        return $response;
    }

    /**
     * 批量删除用户
     *
     * @param int $limit
     * @return mixed
     * @throws GatewayErrorException
     */
    public function deleteUsers($limit = 5)
    {
        try {
            $response = $this->request('delete', 'users', [
                'headers' => $this->getAuthorization(),
                'query' => ['limit' => $limit]
            ]);
        } catch (\Exception $e) {
            throw new GatewayErrorException($e->getMessage(), $e->getCode(), $e);
        }

        return $response;
    }

    /**
     * 重置用户密码
     *
     * @param $username
     * @param $password
     * @return mixed
     * @throws GatewayErrorException
     */
    public function resetPassword($username, $password)
    {
        try {
            $options = [
                'newpassword' => $password,
            ];
            $response = $this->request('put', "users/{$username}/password", [
                'headers' => $this->getAuthorization(),
                'json' => $options
            ]);
        } catch (\Exception $e) {
            throw new GatewayErrorException($e->getMessage(), $e->getCode(), $e);
        }

        return $response;
    }

    /**
     * 更新用户信息 昵称等
     *
     * @param $username
     * @param $options
     * @return mixed
     * @throws GatewayErrorException
     */
    public function updateUser($username, $options)
    {
        try {

            $response = $this->request('put', "users/{$username}", [
                'headers' => $this->getAuthorization(),
                'json' => $options
            ]);
        } catch (\Exception $e) {
            throw new GatewayErrorException($e->getMessage(), $e->getCode(), $e);
        }

        return $response;
    }

    /**
     * 获取用户在线状态
     *
     * @param $username
     * @return mixed
     * @throws GatewayErrorException
     */
    public function getUserStatus($username)
    {
        try {
            $response = $this->get( "users/{$username}/status", [], $this->getAuthorization());
        } catch (\Exception $e) {
            throw new GatewayErrorException($e->getMessage(), $e->getCode(), $e);
        }

        return $response;
    }

    /**
     * 获取离线未读消息
     *
     * @param $username
     * @return mixed
     * @throws GatewayErrorException
     */
    public function offlineMsgCount($username)
    {
        try {
            $response = $this->get( "users/{$username}/offline_msg_count", [], $this->getAuthorization());
        } catch (\Exception $e) {
            throw new GatewayErrorException($e->getMessage(), $e->getCode(), $e);
        }

        return $response;
    }

    /**
     * 获取某一条消息的状态
     *
     * @param $username
     * @param $msg_id
     * @return mixed
     * @throws GatewayErrorException
     */
    public function getOfflineMsgStatus($username, $msg_id)
    {
        try {
            $response = $this->get( "users/{$username}/offline_msg_status/{$msg_id}", [], $this->getAuthorization());
        } catch (\Exception $e) {
            throw new GatewayErrorException($e->getMessage(), $e->getCode(), $e);
        }

        return $response;
    }

    /**
     * 账号禁用
     *
     * @param $username
     * @return mixed
     * @throws GatewayErrorException
     */
    public function deactivate($username)
    {
        try {
            $response = $this->postJson( "users/{$username}/deactivate", [], $this->getAuthorization());
        } catch (\Exception $e) {
            throw new GatewayErrorException($e->getMessage(), $e->getCode(), $e);
        }

        return $response;
    }

    /**
     * 账号解禁
     *
     * @param $username
     * @return mixed
     * @throws GatewayErrorException
     */
    public function activate($username)
    {
        try {
            $response = $this->postJson( "users/{$username}/activate", [], $this->getAuthorization());
        } catch (\Exception $e) {
            throw new GatewayErrorException($e->getMessage(), $e->getCode(), $e);
        }

        return $response;
    }

    /**
     * 强制下线
     *
     * @param $username
     * @return mixed
     * @throws GatewayErrorException
     */
    public function disconnect($username)
    {
        try {
            $response = $this->get( "users/{$username}/disconnect", [], $this->getAuthorization());
        } catch (\Exception $e) {
            throw new GatewayErrorException($e->getMessage(), $e->getCode(), $e);
        }

        return $response;
    }

    /**
     * 获取一个用户参与的所有群组
     *
     * @param $username
     * @return mixed
     * @throws GatewayErrorException
     */
    public function getUsersJoinsGroups($username)
    {
        try {
            $response = $this->get("users/{$username}/joined_chatgroups", [], $this->getAuthorization());
        } catch (\Exception $e) {
            throw new GatewayErrorException($e->getMessage(), $e->getCode(), $e);
        }

        return $response;
    }
}
