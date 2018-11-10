<?php

namespace Hogus\LaravelEasemob\Traits;

use Hogus\LaravelEasemob\Exceptions\GatewayErrorException;

trait EasemobGroups
{
    public function getGroups($limit = 0, $cursor = '')
    {
        try {
            $options = (!empty($limit) || !empty($cursor)) ? ['limit' => $limit, 'cursor' => $cursor] : '';
            $response = $this->get('chatgroups', $options, $this->getAuthorization());
        } catch (\Exception $e) {
            throw new GatewayErrorException($e->getMessage(), $e->getCode(), $e);
        }

        return $response;
    }


    public function getGroupDetail($group_ids)
    {
        try {
            $response = $this->get('chatgroups/' . $group_ids, '', $this->getAuthorization());
        } catch (\Exception $e) {
            throw new GatewayErrorException($e->getMessage(), $e->getCode(), $e);
        }

        return $response;
    }

    /**
     * 创建群组
     *
     * {
    "groupname":"testrestgrp12", //群组名称，此属性为必须的
    "desc":"server create group", //群组描述，此属性为必须的
    "public":true, //是否是公开群，此属性为必须的
    "maxusers":300, //群组成员最大数（包括群主），值为数值类型，默认值200，最大值2000，此属性为可选的
    "members_only":true // 加入群是否需要群主或者群管理员审批，默认是false
    "allowinvites": true  //是否允许群成员邀请别人加入此群。 true：允许群成员邀请人加入此群，false：只有群主或者管理员才可以往群里加人。
    "owner":"jma1", //群组的管理员，此属性为必须的
    "members":["jma2","jma3"] //群组成员，此属性为可选的，但是如果加了此项，数组元素至少一个（注：群主jma1不需要写入到members里面）
    }
     * @param array $options
     * @return mixed
     * @throws GatewayErrorException
     */
    public function createGroup(array $options)
    {
        try {
            $response = $this->postJson('chatgroups', $options, $this->getAuthorization());
        } catch (\Exception $e) {
            throw new GatewayErrorException($e->getMessage(), $e->getCode(), $e);
        }

        return $response;
    }

    /**
     * 更新群组信息
     *
     * @param $group_id
     * @param $options
     * @return mixed
     * @throws GatewayErrorException
     */
    public function updateGroup($group_id, $options)
    {
        try {
            $response = $this->request('put', "chatgroups/{$group_id}", [
                'headers' => $this->getAuthorization(),
                'json' => $options
            ] );
        } catch (\Exception $e) {
            throw new GatewayErrorException($e->getMessage(), $e->getCode(), $e);
        }

        return $response;
    }

    /**
     * 删除群组
     *
     * @param $group_id
     * @return mixed
     * @throws GatewayErrorException
     */
    public function deleteGroup($group_id)
    {
        try {
            $response = $this->request('delete',"chatgroups/{$group_id}", [
                'headers' => $this->getAuthorization(),
            ]);
        } catch (\Exception $e) {
            throw new GatewayErrorException($e->getMessage(), $e->getCode(), $e);
        }

        return $response;
    }


}
