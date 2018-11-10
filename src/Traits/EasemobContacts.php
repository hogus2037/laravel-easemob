<?php

namespace Hogus\LaravelEasemob\Traits;

use Hogus\LaravelEasemob\Exceptions\GatewayErrorException;

trait EasemobContacts
{
    /**
     * 添加联系人
     *
     * @param $username
     * @param $contact
     * @return mixed
     * @throws GatewayErrorException
     */
    public function addContacts($username, $contact)
    {
        try {
            $response = $this->postJson("users/{$username}/contacts/users/{$contact}", [], $this->getAuthorization());
        } catch (\Exception $e) {
            throw new GatewayErrorException($e->getMessage(), $e->getCode(), $e);
        }

        return $response;
    }

    /**
     * 删除联系人
     *
     * @param $username
     * @param $contact
     * @return mixed
     * @throws GatewayErrorException
     */
    public function deleteContacts($username, $contact)
    {
        try {
            $response = $this->request('delete',"users/{$username}/contacts/users/{$contact}", [
                'headers' => $this->getAuthorization(),
            ]);
        } catch (\Exception $e) {
            throw new GatewayErrorException($e->getMessage(), $e->getCode(), $e);
        }

        return $response;
    }

    /**
     * 获取联系列表
     *
     * @param $username
     * @return mixed
     * @throws GatewayErrorException
     */
    public function getContacts($username)
    {
        try {
            $response = $this->get("users/{$username}/contacts/users", [], $this->getAuthorization());
        } catch (\Exception $e) {
            throw new GatewayErrorException($e->getMessage(), $e->getCode(), $e);
        }

        return $response;
    }

    /**
     * 获取黑名单列表
     *
     * @param $username
     * @return mixed
     * @throws GatewayErrorException
     */
    public function getBlocks($username)
    {
        try {
            $response = $this->get("users/{$username}/blocks/users", [], $this->getAuthorization());
        } catch (\Exception $e) {
            throw new GatewayErrorException($e->getMessage(), $e->getCode(), $e);
        }

        return $response;
    }

    /**
     * 设置黑名单
     *
     * @param $username
     * @param array $users
     * @return mixed
     * @throws GatewayErrorException
     */
    public function block($username, array $users)
    {
        try {
            $options = [
                'usernames' => $users,
            ];
            $response = $this->postJson("users/{$username}/blocks/users", $options, $this->getAuthorization());
        } catch (\Exception $e) {
            throw new GatewayErrorException($e->getMessage(), $e->getCode(), $e);
        }

        return $response;
    }

    /**
     * 取消黑名单
     *
     * @param $username
     * @param $user
     * @return mixed
     * @throws GatewayErrorException
     */
    public function unblock($username, $user)
    {
        try {
            $response = $this->request('delete', "users/{$username}/blocks/users/{$user}", [
                'headers' => $this->getAuthorization()
            ]);
        } catch (\Exception $e) {
            throw new GatewayErrorException($e->getMessage(), $e->getCode(), $e);
        }

        return $response;
    }

}
