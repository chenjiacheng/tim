<?php

declare(strict_types=1);

namespace Chenjiacheng\Tim\Service;

use Chenjiacheng\Tim\Exception\InvalidConfigException;
use Chenjiacheng\Tim\Support\Collection;
use GuzzleHttp\Exception\GuzzleException;

class Operate extends AbstractService
{
    /**
     * 拉取运营数据
     *
     * @see https://cloud.tencent.com/document/product/269/4193
     *
     * @param array $requestField
     * @return Collection
     *
     * @throws InvalidConfigException
     * @throws GuzzleException
     */
    public function getAppInfo(array $requestField = []): Collection
    {
        return $this->httpPostJson(
            'v4/openconfigsvr/getappinfo',
            [
                'RequestField' => $requestField
            ]);
    }

    /**
     * 下载最近消息记录
     *
     * @see https://cloud.tencent.com/document/product/269/1650
     *
     * @param string $chatType
     * @param string $msgTime
     *
     * @return Collection
     *
     * @throws InvalidConfigException
     * @throws GuzzleException
     */
    public function getHistory(string $msgTime, bool $isGroup = false): Collection
    {
        return $this->httpPostJson(
            'v4/open_msg_svc/get_history',
            [
                'ChatType' => $isGroup ? 'Group' : 'C2C',
                'MsgTime'  => $msgTime,
            ]);
    }

    /**
     * 获取服务器 IP 地址
     *
     * @see https://cloud.tencent.com/document/product/269/45438
     *
     * @return Collection
     *
     * @throws InvalidConfigException
     * @throws GuzzleException
     */
    public function getIPList(): Collection
    {
        return $this->httpPostJson('v4/ConfigSvc/GetIPList');
    }

    /**
     * 聊天文件封禁
     *
     * @see https://cloud.tencent.com/document/product/269/74775
     *
     * @param string $rawURL
     *
     * @return Collection
     *
     * @throws InvalidConfigException
     * @throws GuzzleException
     */
    public function forbidIllegalObject(string $rawURL): Collection
    {
        return $this->httpPostJson(
            'v4/im_cos_msg/forbid_illegal_object',
            [
                'RawURL' => $rawURL,
            ]);
    }

    /**
     * 聊天文件解封
     *
     * @see https://cloud.tencent.com/document/product/269/74776
     *
     * @param string $rawURL
     *
     * @return Collection
     *
     * @throws InvalidConfigException
     * @throws GuzzleException
     */
    public function allowBannedObject(string $rawURL): Collection
    {
        return $this->httpPostJson(
            'v4/im_cos_msg/allow_banned_object',
            [
                'RawURL' => $rawURL,
            ]);
    }

    /**
     * 聊天文件签名
     *
     * @see https://cloud.tencent.com/document/product/269/74777
     *
     * @param array $rawURLs
     *
     * @return Collection
     *
     * @throws InvalidConfigException
     * @throws GuzzleException
     */
    public function getCosSig(array $rawURLs): Collection
    {
        return $this->httpPostJson(
            'v4/im_cos_msg/get_cos_sig',
            [
                'RawURLs' => $rawURLs,
            ]);
    }

    /**
     * 设置全局禁言
     *
     * @see https://cloud.tencent.com/document/product/269/4230
     *
     * @param string|int $setAccount
     * @param string $msgTime
     * @param bool $isGroup
     *
     * @return Collection
     *
     * @throws InvalidConfigException
     * @throws GuzzleException
     */
    public function setNoSpeaking(string|int $setAccount, string $msgTime, bool $isGroup = false): Collection
    {
        return $this->httpPostJson(
            'v4/openconfigsvr/setnospeaking',
            [
                'Set_Account'                                                => (string)$setAccount,
                $isGroup ? 'GroupmsgNospeakingTime' : 'C2CmsgNospeakingTime' => $msgTime,
            ]);
    }

    /**
     * 查询全局禁言
     *
     * @see https://cloud.tencent.com/document/product/269/4229
     *
     * @param string|int $getAccount
     *
     * @return Collection
     *
     * @throws InvalidConfigException
     * @throws GuzzleException
     */
    public function getNoSpeaking(string|int $getAccount): Collection
    {
        return $this->httpPostJson(
            'v4/openconfigsvr/getnospeaking',
            [
                'Get_Account' => (string)$getAccount,
            ]);
    }
}