<?php

declare(strict_types=1);

namespace Chenjiacheng\Tim\Service;

use Chenjiacheng\Tim\Exception\InvalidConfigException;
use Chenjiacheng\Tim\Support\Arr;
use Chenjiacheng\Tim\Support\Collection;
use Chenjiacheng\Tim\Traits\TIMMsgTrait;
use GuzzleHttp\Exception\GuzzleException;

class Message extends AbstractService
{
    use TIMMsgTrait;

    /**
     * 消息自定义数据（云端保存，会发送到对端，程序卸载重装后还能拉取到）
     *
     * @var string
     */
    public string $cloudCustomData = '';

    /**
     * 消息回调禁止开关，只对本条消息有效
     * ForbidBeforeSendMsgCallback 表示禁止发消息前回调
     * ForbidAfterSendMsgCallback 表示禁止发消息后回调
     *
     * @var array
     */
    public array $forbidCallbackControl = [];

    /**
     * 消息发送控制选项，是一个 String 数组，只对本条消息有效。
     * "NoUnread"表示该条消息不计入未读数。
     * "NoLastMsg"表示该条消息不更新会话列表。
     * "WithMuteNotifications"表示该条消息的接收方对发送方设置的免打扰选项生效（默认不生效）。
     *
     * @var array
     */
    public array $sendMsgControl = [];

    /**
     * 离线推送信息配置
     *
     * @var array
     */
    public array $offlinePushInfo = [];

    /**
     * 单发单聊消息
     *
     * @see https://cloud.tencent.com/document/product/269/2282
     *
     * @param string|int $toAccount 消息接收方 UserID
     * @param string|int|null $fromAccount 消息发送方 UserID（用于指定发送消息方帐号）
     * @param bool $syncOtherMachine true：把消息同步到 From_Account 在线终端和漫游上（默认）；false：消息不同步至 From_Account；
     * @param int $msgLifeTime 消息离线保存时长（单位：秒），最长并默认为7天（604800秒）若设置该字段为0，则消息只发在线用户，不保存离线
     * @param int|null $msgSeq 消息序列号，后台会根据该字段去重及进行同秒内消息的排序，若不填该字段，则由后台填入随机数
     *
     * @return Collection
     *
     * @throws InvalidConfigException
     * @throws GuzzleException
     */
    public function sendMsg(string|int $toAccount, string|int $fromAccount = null, bool $syncOtherMachine = true,
                            int $msgLifeTime = 604800, int $msgSeq = null): Collection
    {
        return $this->httpPostJson(
            'v4/openim/sendmsg',
            array_merge([
                'SyncOtherMachine' => $syncOtherMachine ? 1 : 2,
                'To_Account'       => (string)$toAccount,
                'MsgLifeTime'      => $msgLifeTime,
                'MsgRandom'        => $this->getRandom(),
                'MsgBody'          => $this->msgBody,
            ], array_filter([
                'From_Account'          => (string)$fromAccount,
                'MsgSeq'                => $msgSeq,
                'ForbidCallbackControl' => $this->forbidCallbackControl,
                'SendMsgControl'        => $this->sendMsgControl,
                'CloudCustomData'       => $this->cloudCustomData,
                'OfflinePushInfo'       => $this->offlinePushInfo,
            ])));
    }

    /**
     * 批量发单聊消息
     *
     * @see https://cloud.tencent.com/document/product/269/1612
     *
     * @param array $toAccount 消息接收方 UserID
     * @param string|int|null $fromAccount 消息发送方 UserID（用于指定发送消息方帐号）
     * @param bool $syncOtherMachine true：把消息同步到 From_Account 在线终端和漫游上（默认）；false：消息不同步至 From_Account；
     * @param int $msgLifeTime 消息离线保存时长（单位：秒），最长并默认为7天（604800秒）若设置该字段为0，则消息只发在线用户，不保存离线
     * @param int|null $msgSeq 消息序列号，后台会根据该字段去重及进行同秒内消息的排序，若不填该字段，则由后台填入随机数
     *
     * @return Collection
     * @throws InvalidConfigException
     * @throws GuzzleException
     */
    public function batchSendMsg(array $toAccount, string|int $fromAccount = null, bool $syncOtherMachine = true,
                                 int $msgLifeTime = 604800, int $msgSeq = null): Collection
    {
        return $this->httpPostJson(
            'v4/openim/batchsendmsg',
            array_merge([
                'SyncOtherMachine' => $syncOtherMachine ? 1 : 2,
                'To_Account'       => array_map('strval', $toAccount),
                'MsgLifeTime'      => $msgLifeTime,
                'MsgRandom'        => $this->getRandom(),
                'MsgBody'          => $this->msgBody,
            ], array_filter([
                'From_Account'          => (string)$fromAccount,
                'MsgSeq'                => $msgSeq,
                'ForbidCallbackControl' => $this->forbidCallbackControl,
                'SendMsgControl'        => $this->sendMsgControl,
                'CloudCustomData'       => $this->cloudCustomData,
                'OfflinePushInfo'       => $this->offlinePushInfo,
            ])));
    }

    /**
     * 导入单聊消息
     *
     * @see https://cloud.tencent.com/document/product/269/2568
     *
     * @param string|int $fromAccount 消息发送方 UserID，用于指定发送消息方
     * @param string|int $toAccount 消息接收方 UserID
     * @param int|null $msgTimeStamp 消息时间戳，UNIX 时间戳，单位为秒。后台会根据该字段去重，详细规则请看本接口的功能说明。
     * @param bool $syncFromOldSystem true：表示实时消息导入，消息计入未读计数，false：表示历史消息导入，消息不计入未读
     * @param int|null $msgSeq 消息序列号，后台会根据该字段去重及进行同秒内消息的排序，若不填该字段，则由后台填入随机数
     * @return Collection
     * @throws \Chenjiacheng\Tim\Exception\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function importMsg(string|int $fromAccount, string|int $toAccount, int $msgTimeStamp = null,
                              bool $syncFromOldSystem = true, int $msgSeq = null): Collection
    {
        return $this->httpPostJson(
            'v4/openim/importmsg',
            array_merge([
                'SyncFromOldSystem' => $syncFromOldSystem ? 1 : 2,
                'From_Account'      => (string)$fromAccount,
                'To_Account'        => (string)$toAccount,
                'MsgRandom'         => $this->getRandom(),
                'MsgTimeStamp'      => $msgTimeStamp ?? time(),
                'MsgBody'           => $this->msgBody,
            ], array_filter([
                'MsgSeq'          => $msgSeq,
                'CloudCustomData' => $this->cloudCustomData,
            ])));
    }

    /**
     * 查询单聊消息
     *
     * @see https://cloud.tencent.com/document/product/269/42794
     *
     * @param string|int $operatorAccount 会话其中一方的 UserID，以该 UserID 的角度去查询消息
     * @param string|int $peerAccount 会话的另一方 UserID
     * @param int $maxCnt 请求的消息条数
     * @param int $minTime 请求的消息时间范围的最小值
     * @param int $maxTime 请求的消息时间范围的最大值
     * @param string $lastMsgKey 上一次拉取到的最后一条消息的 MsgKey，续拉时需要填该字段
     *
     * @return Collection
     *
     * @throws InvalidConfigException
     * @throws GuzzleException
     */
    public function getRoamMsg(string|int $operatorAccount, string|int $peerAccount, int $maxCnt,
                               int $minTime, int $maxTime, string $lastMsgKey = ''): Collection
    {
        return $this->httpPostJson(
            'v4/openim/admin_getroammsg',
            array_merge([
                'Operator_Account' => (string)$operatorAccount,
                'Peer_Account'     => (string)$peerAccount,
                'MaxCnt'           => $maxCnt,
                'MinTime'          => $minTime,
                'MaxTime'          => $maxTime,
            ], array_filter([
                'LastMsgKey' => $lastMsgKey,
            ])));
    }

    /**
     * 撤回单聊消息
     *
     * @see https://cloud.tencent.com/document/product/269/38980
     *
     * @param string|int $fromAccount 消息发送方 UserID
     * @param string|int $toAccount 消息接收方 UserID
     * @param string $msgKey 待撤回消息的唯一标识。
     *
     * @return Collection
     *
     * @throws InvalidConfigException
     * @throws GuzzleException
     */
    public function msgWithdraw(string|int $fromAccount, string|int $toAccount, string $msgKey): Collection
    {
        return $this->httpPostJson(
            'v4/openim/admin_msgwithdraw',
            [
                'From_Account' => (string)$fromAccount,
                'To_Account'   => (string)$toAccount,
                'MsgKey'       => $msgKey,
            ]);
    }

    /**
     * 设置单聊消息已读
     *
     * @see https://cloud.tencent.com/document/product/269/50349
     *
     * @param string|int $reportAccount 进行消息已读的用户 UserId
     * @param string|int $peerAccount 进行消息已读的单聊会话的另一方用户 UserId
     * @param string|int|null $msgReadTime 时间戳（秒），该时间戳之前的消息全部已读。若不填，则取当前时间戳
     *
     * @return Collection
     *
     * @throws InvalidConfigException
     * @throws GuzzleException
     */
    public function setMsgRead(string|int $reportAccount, string|int $peerAccount,
                               string|int $msgReadTime = null): Collection
    {
        return $this->httpPostJson(
            'v4/openim/admin_set_msg_read',
            array_merge([
                'Report_Account' => (string)$reportAccount,
                'Peer_Account'   => (string)$peerAccount,
            ], array_filter([
                'MsgReadTime' => (string)$msgReadTime,
            ])));
    }

    /**
     * 查询单聊未读消息计数
     *
     * @see https://cloud.tencent.com/document/product/269/56043
     *
     * @param string|int $toAccount 待查询的用户 UserId
     * @param array|string|int $peerAccount 待查询的单聊会话对端的用户 UserId。若要查询单个会话的未读数，该字段必填，最大大小为10
     *
     * @return Collection
     *
     * @throws InvalidConfigException
     * @throws GuzzleException
     */
    public function getUnreadMsgNum(string|int $toAccount, array|string|int $peerAccount = []): Collection
    {
        return $this->httpPostJson(
            'v4/openim/get_c2c_unread_msg_num',
            array_merge([
                'To_Account' => (string)$toAccount,
            ], array_filter([
                'Peer_Account' => array_map('strval', Arr::wrap($peerAccount)),
            ])));
    }

    /**
     * 修改单聊历史消息
     *
     * @see https://cloud.tencent.com/document/product/269/74740
     *
     * @param string|int $fromAccount 消息发送方 UserID
     * @param string|int $toAccount 消息接收方 UserID
     * @param string $msgKey 待修改消息的唯一标识
     *
     * @return Collection
     *
     * @throws InvalidConfigException
     * @throws GuzzleException
     */
    public function modifyMsg(string|int $fromAccount, string|int $toAccount, string $msgKey): Collection
    {
        return $this->httpPostJson(
            'v4/openim/modify_c2c_msg',
            array_merge([
                'From_Account' => (string)$fromAccount,
                'To_Account'   => (string)$toAccount,
                'MsgKey'       => $msgKey,
            ], array_filter([
                'MsgBody'         => $this->msgBody,
                'CloudCustomData' => $this->cloudCustomData,
            ])));
    }

    /**
     * @param string $cloudCustomData
     *
     * @return $this
     */
    public function setCloudCustomData(string $cloudCustomData): static
    {
        $this->cloudCustomData = $cloudCustomData;
        return $this;
    }

    /**
     * @param bool $bool false 表示禁止发消息前回调
     *
     * @return $this
     */
    public function beforeCallback(bool $bool = true): static
    {
        !$bool && $this->forbidCallbackControl[] = 'ForbidBeforeSendMsgCallback';
        return $this;
    }

    /**
     * @param bool $bool false 表示禁止发消息后回调
     *
     * @return $this
     */
    public function afterCallback(bool $bool = true): static
    {
        !$bool && $this->forbidCallbackControl[] = 'ForbidAfterSendMsgCallback';
        return $this;
    }

    /**
     * @param false $bool true 表示该条消息不计入未读数。
     *
     * @return $this
     */
    public function noUnread(bool $bool = false): static
    {
        $bool && $this->sendMsgControl[] = 'NoUnread';
        return $this;
    }

    /**
     * @param false $bool true 表示该条消息不更新会话列表。
     *
     * @return $this
     */
    public function noLastMsg(bool $bool = false): static
    {
        $bool && $this->sendMsgControl[] = 'NoLastMsg';
        return $this;
    }

    /**
     * @param false $bool true 表示该条消息的接收方对发送方设置的免打扰选项生效（默认不生效）。
     *
     * @return $this
     */
    public function withMuteNotifications(bool $bool = false): static
    {
        $bool && $this->sendMsgControl[] = 'WithMuteNotifications';
        return $this;
    }

    /**
     * @param array $offlinePushInfo 离线推送信息配置
     *
     * @return $this
     */
    public function setOfflinePushInfo(array $offlinePushInfo): static
    {
        $this->offlinePushInfo = $offlinePushInfo;
        return $this;
    }
}