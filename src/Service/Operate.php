<?php

declare(strict_types=1);

namespace Chenjiacheng\Tim\Service;

use Chenjiacheng\Tim\Constant\ChatType;
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
     * @param string $msgTime 需要下载的消息记录的时间段
     * @param string $chatType 消息类型，单发消息=ChatType::C2C，表示群组消息=ChatType::Group
     *
     * @return Collection
     *
     * @throws InvalidConfigException
     * @throws GuzzleException
     */
    public function getHistory(string $msgTime, string $chatType = ChatType::C2C): Collection
    {
        return $this->httpPostJson(
            'v4/open_msg_svc/get_history',
            [
                'MsgTime'  => $msgTime,
                'ChatType' => $chatType,
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
     * @param string $rawURL 文件 URL，可从 IM 富媒体消息的 URL 字段获取
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
     * @param string $rawURL 文件 URL，可从 IM 富媒体消息的 URL 字段获取
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
     * @param array $rawURLs 批量查询的文件 URL，可从 IM 富媒体消息的 URL 字段获取
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
}