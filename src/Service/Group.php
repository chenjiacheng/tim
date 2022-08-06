<?php

declare(strict_types=1);

namespace Chenjiacheng\Tim\Service;

use Chenjiacheng\Tim\Constant\GroupType;
use Chenjiacheng\Tim\Exception\InvalidConfigException;
use Chenjiacheng\Tim\Service\Group\GroupAttr;
use Chenjiacheng\Tim\Service\Group\GroupInfo;
use Chenjiacheng\Tim\Service\Group\GroupMember;
use Chenjiacheng\Tim\Service\Group\ResponseFilter;
use Chenjiacheng\Tim\Support\Arr;
use Chenjiacheng\Tim\Support\Collection;
use GuzzleHttp\Exception\GuzzleException;
use JetBrains\PhpStorm\Pure;

class Group extends AbstractService
{
    use TIMMsgTrait;

    /**
     * 获取 App 中的所有群组
     *
     * @see https://cloud.tencent.com/document/product/269/1639
     *
     * @param int $limit 数量上限，不得超过 10000
     * @param int $next 上一次返回的值，返回为 0 代表拉取完了，第一次填 0
     * @param string $groupType 群组类型
     * @return Collection
     *
     * @throws InvalidConfigException
     * @throws GuzzleException
     */
    public function getAll(int $limit = 10000, int $next = 0, string $groupType = ''): Collection
    {
        return $this->httpPostJson(
            'v4/group_open_http_svc/get_appid_group_list',
            array_merge([
                'Limit' => $limit,
            ], array_filter([
                'Next'      => $next,
                'GroupType' => $groupType,
            ])));
    }

    /**
     * 创建群组
     *
     * @see https://cloud.tencent.com/document/product/269/1615
     *
     * @param string $name 群名称，最长30字节
     * @param string $type 群组类型
     * @param string $ownerAccount 群主 ID，成员使用 AVChatroom（直播群）时，必须每次调用进群操作
     * @param string $groupId 自定义群组 ID
     * @param array $memberList 初始群成员列表，最多100个；成员信息字段详情请参阅 群成员资料
     * @param GroupInfo|null $groupInfo 群资料
     *
     * @return Collection
     *
     * @throws InvalidConfigException
     * @throws GuzzleException
     */
    public function create(string $name, string $type = GroupType::PUBLIC, string $ownerAccount = '',
                           string $groupId = '', array $memberList = [], ?GroupInfo $groupInfo = null): Collection
    {
        return $this->httpPostJson(
            'v4/group_open_http_svc/create_group',
            array_merge([
                'Type' => $type,
                'Name' => $name,
            ], array_filter([
                'Owner_Account' => $ownerAccount,
                'GroupId'       => $groupId,
                'MemberList'    => $memberList,
            ]), $groupInfo ?? $groupInfo->output()));
    }

    /**
     * 获取群详细资料
     *
     * @see https://cloud.tencent.com/document/product/269/1616
     *
     * @param array|string $groupIdList 需要拉取的群组列表
     * @param ResponseFilter|null $responseFilter 过滤器
     * @return Collection
     *
     * @throws InvalidConfigException
     * @throws GuzzleException
     */
    public function get(array|string $groupIdList, ?ResponseFilter $responseFilter = null): Collection
    {
        return $this->httpPostJson(
            'v4/group_open_http_svc/get_group_info',
            array_merge([
                'GroupIdList' => Arr::wrap($groupIdList),
            ], array_filter([
                'ResponseFilter' => $responseFilter ?? $responseFilter->output()
            ])));
    }

    /**
     * 修改群基础资料
     *
     * @see https://cloud.tencent.com/document/product/269/1620
     *
     * @param string $groupId 需要修改基础信息的群组的 ID
     * @param string $name 群名称
     * @param string $muteAllMember 设置全员禁言："On"开启，"Off"关闭
     * @param GroupInfo|null $groupInfo 群资料
     *
     * @return Collection
     *
     * @throws InvalidConfigException
     * @throws GuzzleException
     */
    public function modify(string $groupId, string $name = '', string $muteAllMember = '', ?GroupInfo $groupInfo = null): Collection
    {
        return $this->httpPostJson(
            'v4/group_open_http_svc/modify_group_base_info',
            array_merge([
                'GroupId' => $groupId,
            ], array_filter([
                'Name'          => $name,
                'MuteAllMember' => $muteAllMember,
            ]), $groupInfo ?? $groupInfo->output()));
    }

    /**
     * 解散群组
     *
     * @see https://cloud.tencent.com/document/product/269/1624
     *
     * @param string $groupId 操作的群 ID
     *
     * @return Collection
     *
     * @throws InvalidConfigException
     * @throws GuzzleException
     */
    public function destroy(string $groupId): Collection
    {
        return $this->httpPostJson(
            'v4/group_open_http_svc/destroy_group',
            [
                'GroupId' => $groupId,
            ]);
    }

    /**
     * 获取用户所加入的群组
     *
     * @see https://cloud.tencent.com/document/product/269/1625
     *
     * @param array|string|int $memberAccount 需要查询的用户帐号
     * @param int $limit 单次拉取的群组数量，如果不填代表所有群组
     * @param int $offset 从第多少个群组开始拉取
     * @param string $groupType 拉取哪种群组类型
     * @param int $withHugeGroups 是否获取用户加入的 AVChatRoom(直播群)，0表示不获取，1表示获取。默认为0
     * @param int $withNoActiveGroups 是否获取用户已加入但未激活的 Private（即新版本中 Work，好友工作群) 群信息，0表示不获取，1表示获取。默认为0
     * @param array $responseFilter
     *
     * @return Collection
     *
     * @throws InvalidConfigException
     * @throws GuzzleException
     */
    public function getJoinedGroupList(array|string|int $memberAccount, int $limit = 0, int $offset = 0,
                                       string $groupType = '', int $withHugeGroups = 0, int $withNoActiveGroups = 0,
                                       array $responseFilter = []): Collection
    {
        return $this->httpPostJson(
            'v4/group_open_http_svc/get_joined_group_list',
            array_merge([
                'Member_Account' => array_map('strval', Arr::wrap($memberAccount)),
            ], array_filter([
                'Limit'              => $limit,
                'Offset'             => $offset,
                'GroupType'          => $groupType,
                'WithHugeGroups'     => $withHugeGroups,
                'WithNoActiveGroups' => $withNoActiveGroups,
                'ResponseFilter'     => $responseFilter,
            ])));
    }

    /**
     * 在群组中发送普通消息
     *
     * @see https://cloud.tencent.com/document/product/269/1629
     *
     * @param string $groupId
     *
     * @return Collection
     *
     * @throws InvalidConfigException
     * @throws GuzzleException
     */
    public function sendMsg(string $groupId): Collection
    {
        // TODO
        return $this->httpPostJson(
            'v4/group_open_http_svc/send_group_msg',
            [
                'GroupId'   => $groupId,
                'MsgRandom' => $this->getRandom(),
                'MsgBody'   => $this->msgBody,
            ]);
    }

    /**
     * 在群组中发送系统通知
     *
     * @see https://cloud.tencent.com/document/product/269/1630
     *
     * @param string $groupId 向哪个群组发送系统通知
     * @param string $content 系统通知的内容
     * @param array|string|int $toMembersAccount 接收者群成员列表，请填写接收者 UserID，最多填写500个，不填或为空表示全员下发
     *
     * @return Collection
     *
     * @throws InvalidConfigException
     * @throws GuzzleException
     */
    public function sendSystemNotification(string $groupId, string $content, array|string|int $toMembersAccount = []): Collection
    {
        return $this->httpPostJson(
            'v4/group_open_http_svc/send_group_system_notification',
            array_merge([
                'GroupId' => $groupId,
                'Content' => $content,
            ], array_filter([
                'ToMembers_Account' => array_map('strval', Arr::wrap($toMembersAccount)),
            ])));
    }

    /**
     * 转让群组
     *
     * @see https://cloud.tencent.com/document/product/269/1633
     *
     * @param string $groupId 要被转移的群组 ID
     * @param string|int $newOwnerAccount 新群主 ID
     *
     * @return Collection
     *
     * @throws InvalidConfigException
     * @throws GuzzleException
     */
    public function changeOwner(string $groupId, string|int $newOwnerAccount): Collection
    {
        return $this->httpPostJson(
            'v4/group_open_http_svc/change_group_owner',
            [
                'GroupId'          => $groupId,
                'NewOwner_Account' => (string)$newOwnerAccount,
            ]);
    }

    /**
     * 撤回群消息
     *
     * @see https://cloud.tencent.com/document/product/269/12341
     *
     * @param string $groupId 操作的群 ID
     * @param array $msgSeqList 被撤回的消息 seq 列表，一次请求最多可以撤回10条消息 seq
     *
     * @return Collection
     *
     * @throws InvalidConfigException
     * @throws GuzzleException
     */
    public function groupMsgRecall(string $groupId, array $msgSeqList): Collection
    {
        return $this->httpPostJson(
            'v4/group_open_http_svc/group_msg_recall',
            [
                'GroupId'    => $groupId,
                'MsgSeqList' => $msgSeqList,
            ]);
    }

    /**
     * 导入群基础资料
     *
     * @see https://cloud.tencent.com/document/product/269/1634
     *
     * @param string $name 群名称，最长30字节
     * @param string $type 群组类型
     * @param string $ownerAccount 群主 ID，成员使用 AVChatroom（直播群）时，必须每次调用进群操作
     * @param string $groupId 自定义群组 ID
     * @param int $createTime 群组的创建时间
     * @param GroupInfo|null $groupInfo 群资料
     *
     * @return Collection
     *
     * @throws InvalidConfigException
     * @throws GuzzleException
     */
    public function import(string $name, string $type = GroupType::PUBLIC, string $ownerAccount = '',
                           string $groupId = '', int $createTime = 0, ?GroupInfo $groupInfo = null): Collection
    {
        return $this->httpPostJson(
            'v4/group_open_http_svc/create_group',
            array_merge([
                'Type' => $type,
                'Name' => $name,
            ], array_filter([
                'Owner_Account' => $ownerAccount,
                'GroupId'       => $groupId,
                'CreateTime'    => $createTime,
            ]), $groupInfo ?? $groupInfo->output()));
    }

    /**
     * 导入群消息
     *
     * @see https://cloud.tencent.com/document/product/269/1635
     *
     * @param string $groupId 要导入消息的群 ID
     * @param array $msgList 导入的消息列表
     * @param int $recentContactFlag 会话更新识别，为1的时候标识触发会话更新，默认不触发（avchatroom 群不支持）
     *
     * @return Collection
     *
     * @throws InvalidConfigException
     * @throws GuzzleException
     */
    public function importMsg(string $groupId, array $msgList, int $recentContactFlag = 0): Collection
    {
        return $this->httpPostJson(
            'v4/group_open_http_svc/import_group_msg',
            array_merge([
                'MsgList' => $msgList,
            ], array_filter([
                'RecentContactFlag' => $recentContactFlag,
            ])));
    }

    /**
     * 拉取群历史消息
     *
     * @see https://cloud.tencent.com/document/product/269/2738
     *
     * @param string $groupId 要拉取历史消息的群组 ID
     * @param int $reqMsgNumber 拉取的历史消息的条数，目前一次请求最多返回20条历史消息，所以这里最好小于等于20
     * @param int $reqMsgSeq 拉取消息的最大 seq
     * @param int $withRecalledMsg 是否带撤回的消息，填1表明需要拉取撤回后的消息；默认不拉取撤回后的消息
     *
     * @return Collection
     *
     * @throws InvalidConfigException
     * @throws GuzzleException
     */
    public function groupMsgGetSimple(string $groupId, int $reqMsgNumber, int $reqMsgSeq = 0, int $withRecalledMsg = 0): Collection
    {
        return $this->httpPostJson(
            'v4/group_open_http_svc/group_msg_get_simple',
            array_merge([
                'GroupId'      => $groupId,
                'ReqMsgNumber' => $reqMsgNumber,
            ], array_filter([
                'ReqMsgSeq'       => $reqMsgSeq,
                'WithRecalledMsg' => $withRecalledMsg,
            ])));
    }

    /**
     * 获取直播群在线人数
     *
     * @see https://cloud.tencent.com/document/product/269/49180
     *
     * @param string $groupId
     *
     * @return Collection
     *
     * @throws InvalidConfigException
     * @throws GuzzleException
     */
    public function getOnlineMemberNum(string $groupId): Collection
    {
        return $this->httpPostJson(
            'v4/group_open_http_svc/get_online_member_num',
            [
                'GroupId' => $groupId,
            ]);
    }

    /**
     * 修改群聊历史消息
     *
     * @see https://cloud.tencent.com/document/product/269/74741
     *
     * @param string $groupId
     * @param int $msgSeq
     * @return Collection
     *
     * @throws InvalidConfigException
     * @throws GuzzleException
     */
    public function modifyMsg(string $groupId, int $msgSeq): Collection
    {
        // TODO
        return $this->httpPostJson(
            'v4/openim/modify_group_msg',
            array_merge([
                'GroupId' => $groupId,
                'MsgSeq'  => $msgSeq,
            ], array_filter([
                'MsgBody' => $this->msgBody,
            ])));
    }

    /**
     * 拉取群消息已读回执详情
     *
     * @see https://cloud.tencent.com/document/product/269/77693
     *
     * @param string $groupId 要拉取已读回执详情的群组 ID
     * @param int $filter 拉取已读，未读成员列表，0表示拉取已读成员列表，1表示拉取未读列表
     * @param string $cursor 上一次拉取到的成员位置，第一次填写""
     * @param int $count 上一次拉取到的成员位置，第一次填写""
     * @param int $msgSeq 拉取消息的 seq
     *
     * @return Collection
     *
     * @throws InvalidConfigException
     * @throws GuzzleException
     */
    public function getGroupMsgReceiptDetail(string $groupId, int $filter, string $cursor, int $count, int $msgSeq): Collection
    {
        return $this->httpPostJson(
            'v4/group_open_http_svc/get_group_msg_receipt_detail',
            array_merge([
                'GroupId' => $groupId,
                'Filter'  => $filter,
                'Cursor'  => $cursor,
                'Count'   => $count,
            ], array_filter([
                'MsgSeq' => $msgSeq,
            ])));
    }

    /**
     * 拉取群消息已读回执信息
     *
     * @see https://cloud.tencent.com/document/product/269/77694
     *
     * @param string $groupId 要拉取已读回执详情的群组 ID
     * @param array $msgSeqList 拉取消息的 seq 列表
     *
     * @return Collection
     *
     * @throws InvalidConfigException
     * @throws GuzzleException
     */
    public function getGroupMsgReceipt(string $groupId, array $msgSeqList): Collection
    {
        return $this->httpPostJson(
            'v4/group_open_http_svc/get_group_msg_receipt',
            [
                'GroupId'    => $groupId,
                'MsgSeqList' => $msgSeqList,
            ]);
    }

    /**
     * 直播群广播消息
     *
     * @see https://cloud.tencent.com/document/product/269/77402
     *
     * @param string|int $fromAccount 消息来源帐号
     *
     * @return Collection
     *
     * @throws InvalidConfigException
     * @throws GuzzleException
     */
    public function sendBroadcastMsg(string|int $fromAccount = ''): Collection
    {
        // TODO
        return $this->httpPostJson(
            'v4/group_open_http_svc/send_broadcast_msg',
            array_merge([
                'Random'  => $this->getRandom(),
                'MsgBody' => $this->msgBody,
            ], array_filter([
                'From_Account' => (string)$fromAccount,
            ])));
    }

    /**
     * @param string $groupId
     *
     * @return GroupAttr
     */
    #[Pure] public function groupAttr(string $groupId): GroupAttr
    {
        return new GroupAttr($this->app, $groupId);
    }

    /**
     * @param string $groupId
     *
     * @return GroupMember
     */
    #[Pure] public function groupMember(string $groupId): GroupMember
    {
        return new GroupMember($this->app, $groupId);
    }
}