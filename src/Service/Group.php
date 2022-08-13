<?php

declare(strict_types=1);

namespace Chenjiacheng\Tim\Service;

use Chenjiacheng\Tim\Constant\GroupType;
use Chenjiacheng\Tim\Exception\InvalidConfigException;
use Chenjiacheng\Tim\Service\Group\GroupInfo;
use Chenjiacheng\Tim\Service\Group\GroupInfoResponseFilter;
use Chenjiacheng\Tim\Service\Group\GroupMemberResponseFilter;
use Chenjiacheng\Tim\Service\Group\GroupMsgList;
use Chenjiacheng\Tim\Service\Group\JoinedGroupResponseFilter;
use Chenjiacheng\Tim\Service\Message\OfflinePushInfo;
use Chenjiacheng\Tim\Support\Arr;
use Chenjiacheng\Tim\Support\Collection;
use Chenjiacheng\Tim\Traits\TIMMsgTrait;
use GuzzleHttp\Exception\GuzzleException;

class Group extends AbstractService
{
    use TIMMsgTrait;

    /**
     * 离线推送信息配置
     *
     * @var array
     */
    public array $offlinePushInfo = [];

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
     * 消息自定义数据（云端保存，会发送到对端，程序卸载重装后还能拉取到）
     *
     * @var string
     */
    public string $cloudCustomData = '';

    /**
     * 获取 App 中的所有群组
     *
     * @see https://cloud.tencent.com/document/product/269/1639
     *
     * @param int $limit 数量上限，不得超过 10000
     * @param int $next 上一次返回的值，返回为 0 代表拉取完了，第一次填 0
     * @param string $groupType 群组类型
     *
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
     * @param string|int $ownerAccount 群主 ID
     * @param string $groupId 自定义群组 ID
     * @param array $memberList 初始群成员列表，最多100个
     * @param GroupInfo|null $groupInfo 群资料
     *
     * @return Collection
     *
     * @throws InvalidConfigException
     * @throws GuzzleException
     */
    public function create(string $name, string $type = GroupType::PUBLIC, string|int $ownerAccount = '',
                           string $groupId = '', array $memberList = [], GroupInfo $groupInfo = null): Collection
    {
        return $this->httpPostJson(
            'v4/group_open_http_svc/create_group',
            array_merge([
                'Type' => $type,
                'Name' => $name,
            ], array_filter([
                'Owner_Account' => (string)$ownerAccount,
                'GroupId'       => $groupId,
                'MemberList'    => $memberList,
            ]), array_filter(
                isset($groupInfo) ? $groupInfo->output() : []
            )));
    }

    /**
     * 获取群详细资料
     *
     * @see https://cloud.tencent.com/document/product/269/1616
     *
     * @param array|string $groupIdList 需要拉取的群组列表
     * @param GroupInfoResponseFilter|null $groupInfoResponseFilter 字段过滤器包括：基础信息字段过滤器，成员信息字段过滤器，群组维度的自定义字段过滤器
     *
     * @return Collection
     *
     * @throws InvalidConfigException
     * @throws GuzzleException
     */
    public function get(array|string $groupIdList, GroupInfoResponseFilter $groupInfoResponseFilter = null): Collection
    {
        return $this->httpPostJson(
            'v4/group_open_http_svc/get_group_info',
            array_merge([
                'GroupIdList' => Arr::wrap($groupIdList),
            ], array_filter([
                'ResponseFilter' => isset($groupInfoResponseFilter) ? $groupInfoResponseFilter->output() : []
            ])));
    }

    /**
     * 获取群成员详细资料
     *
     * @see https://cloud.tencent.com/document/product/269/1617
     *
     * @param string $groupId
     * @param int $limit 一次最多获取多少个成员的资料，不得超过200。如果不填，则获取群内全部成员的信息
     * @param int $offset 从第几个成员开始获取，如果不填则默认为0，表示从第一个成员开始获取
     * @param string $next 上一次拉取到的成员位置，社群必填，社群不支持 Offset 参数，使用 Next 参数，首次调用填写""，续拉使用返回中的 Next 值
     *
     * @param GroupMemberResponseFilter|null $groupMemberResponseFilter
     *
     * @return Collection
     *
     * @throws InvalidConfigException
     * @throws GuzzleException
     */
    public function getMember(string $groupId, int $limit = 0, int $offset = 0, string $next = '',
                              GroupMemberResponseFilter $groupMemberResponseFilter = null): Collection
    {
        return $this->httpPostJson(
            'v4/group_open_http_svc/get_group_member_info',
            array_merge([
                'GroupId' => $groupId,
            ], array_filter([
                'Limit'  => $limit,
                'Offset' => $offset,
                'Next'   => $next,
            ]), array_filter(
                isset($groupMemberResponseFilter) ? $groupMemberResponseFilter->output() : []
            )));
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
    public function modify(string $groupId, string $name = '', string $muteAllMember = '', GroupInfo $groupInfo = null): Collection
    {
        return $this->httpPostJson(
            'v4/group_open_http_svc/modify_group_base_info',
            array_merge([
                'GroupId' => $groupId,
            ], array_filter([
                'Name'          => $name,
                'MuteAllMember' => $muteAllMember,
            ]), array_filter(
                isset($groupInfo) ? $groupInfo->output() : []
            )));
    }

    /**
     * 增加群成员
     *
     * @see https://cloud.tencent.com/document/product/269/1621
     *
     * @param string $groupId 操作的群 ID
     * @param array|string|int $accounts 待添加的群成员数组
     * @param bool $silence 是否静默加人，如果是静默加人，成员添加成功后，不会给任何人下发系统通知
     *
     * @return Collection
     *
     * @throws InvalidConfigException
     * @throws GuzzleException
     */
    public function addMember(string $groupId, array|string|int $accounts, bool $silence = false): Collection
    {
        $memberList = [];
        foreach (Arr::wrap($accounts) as $account) {
            $memberList[] = ['Member_Account' => (string)$account];
        }

        return $this->httpPostJson(
            'v4/group_open_http_svc/add_group_member',
            array_merge([
                'GroupId'    => $groupId,
                'MemberList' => $memberList,
            ], array_filter([
                'Silence' => $silence ? 1 : 0
            ])));
    }

    /**
     * 删除群成员
     *
     * @see https://cloud.tencent.com/document/product/269/1622
     *
     * @param string $groupId 操作的群 ID
     * @param array|string|int $memberToDelAccount 待删除的群成员
     * @param string $reason 踢出用户原因
     * @param bool $silence 是否静默删人，如果是静默删人，成员删除成功后，不会给任何人下发系统通知
     *
     * @return Collection
     *
     * @throws InvalidConfigException
     * @throws GuzzleException
     */
    public function deleteMember(string $groupId, array|string|int $memberToDelAccount, string $reason = '',
                                 bool $silence = false): Collection
    {
        return $this->httpPostJson(
            'v4/group_open_http_svc/delete_group_member',
            array_merge([
                'GroupId'             => $groupId,
                'MemberToDel_Account' => array_map('strval', Arr::wrap($memberToDelAccount)),
            ], array_filter([
                'Reason'  => $reason,
                'Silence' => $silence ? 1 : 0
            ])));
    }

    /**
     * 修改群成员资料
     *
     * @see https://cloud.tencent.com/document/product/269/1623
     *
     * @param string $groupId 操作的群 ID
     * @param string|int $memberAccount 要操作的群成员
     * @param string $role 成员身份，Admin/Member 分别为设置/取消管理员
     * @param string $msgFlag 消息屏蔽类型：
     *                        接收并提示消息=GroupMsgFlag::ACCEPT_AND_NOTIFY
     *                        不接收也不提示消息=GroupMsgFlag::DISCARD
     *                        接收消息但不提示=GroupMsgFlag::ACCEPT_NOT_NOTIFY
     * @param string $nameCard 群名片（最大不超过50个字节）
     * @param array $appMemberDefinedData 群成员维度的自定义字段
     * @param int $muteTime 需禁言时间，单位为秒，0表示取消禁言
     *
     * @return Collection
     *
     * @throws InvalidConfigException
     * @throws GuzzleException
     */
    public function modifyMember(string $groupId, string|int $memberAccount, string $role = '', string $msgFlag = '',
                                 string $nameCard = '', array $appMemberDefinedData = [], int $muteTime = 0): Collection
    {
        return $this->httpPostJson(
            'v4/group_open_http_svc/modify_group_member_info',
            array_merge([
                'GroupId'        => $groupId,
                'Member_Account' => (string)$memberAccount,
            ], array_filter([
                'Role'                 => $role,
                'MsgFlag'              => $msgFlag,
                'NameCard'             => $nameCard,
                'AppMemberDefinedData' => $appMemberDefinedData,
                'MuteTime'             => $muteTime,
            ])));
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
     * @param string|int $memberAccount 需要查询的用户帐号
     * @param int $limit 单次拉取的群组数量，如果不填代表所有群组
     * @param int $offset 从第多少个群组开始拉取
     * @param string $groupType 拉取哪种群组类型
     * @param int $withHugeGroups 是否获取用户加入的 AVChatRoom(直播群)，0表示不获取，1表示获取。默认为0
     * @param int $withNoActiveGroups 是否获取用户已加入但未激活的 Private（即新版本中 Work，好友工作群) 群信息，0表示不获取，1表示获取。默认为0
     * @param JoinedGroupResponseFilter|null $joinedGroupResponseFilter 字段过滤器
     *
     * @return Collection
     *
     * @throws InvalidConfigException
     * @throws GuzzleException
     */
    public function getJoinedGroupList(string|int $memberAccount, int $limit = 0, int $offset = 0,
                                       string $groupType = '', int $withHugeGroups = 0, int $withNoActiveGroups = 0,
                                       JoinedGroupResponseFilter $joinedGroupResponseFilter = null): Collection
    {
        return $this->httpPostJson(
            'v4/group_open_http_svc/get_joined_group_list',
            array_merge([
                'Member_Account' => (string)$memberAccount,
            ], array_filter([
                'Limit'              => $limit,
                'Offset'             => $offset,
                'GroupType'          => $groupType,
                'WithHugeGroups'     => $withHugeGroups,
                'WithNoActiveGroups' => $withNoActiveGroups,
                'ResponseFilter'     => isset($joinedGroupResponseFilter) ? $joinedGroupResponseFilter->output() : [],
            ])));
    }

    /**
     * 查询用户在群组中的身份
     *
     * @see https://cloud.tencent.com/document/product/269/1626
     *
     * @param string $groupId 需要查询的群组 ID
     * @param array|string|int $userAccount 表示需要查询的用户帐号，最多支持500个帐号
     *
     * @return Collection
     *
     * @throws InvalidConfigException
     * @throws GuzzleException
     */
    public function getRoleInGroup(string $groupId, array|string|int $userAccount): Collection
    {
        return $this->httpPostJson(
            'v4/group_open_http_svc/get_role_in_group',
            [
                'GroupId'      => $groupId,
                'User_Account' => array_map('strval', Arr::wrap($userAccount)),
            ]);
    }

    /**
     * 批量禁言和取消禁言
     *
     * @see https://cloud.tencent.com/document/product/269/1627
     *
     * @param string $groupId 需要查询的群组 ID
     * @param array|string|int $membersAccount 需要禁言的用户帐号，最多支持500个帐号
     * @param int $muteTime 无符号类型。需禁言时间，单位为秒，为0时表示取消禁言，4294967295为永久禁言
     *
     * @return Collection
     *
     * @throws InvalidConfigException
     * @throws GuzzleException
     */
    public function forbidSendMsg(string $groupId, array|string|int $membersAccount, int $muteTime = 4294967295): Collection
    {
        return $this->httpPostJson(
            'v4/group_open_http_svc/forbid_send_msg',
            [
                'GroupId'         => $groupId,
                'Members_Account' => array_map('strval', Arr::wrap($membersAccount)),
                'MuteTime'        => $muteTime,
            ]);
    }

    /**
     * 获取被禁言群成员列表
     *
     * @see https://cloud.tencent.com/document/product/269/2925
     *
     * @param string $groupId 需要获取被禁言成员列表的群组 ID
     *
     * @return Collection
     *
     * @throws InvalidConfigException
     * @throws GuzzleException
     */
    public function getMutedAccount(string $groupId): Collection
    {
        return $this->httpPostJson(
            'v4/group_open_http_svc/get_group_muted_account',
            [
                'GroupId' => $groupId,
            ]);
    }

    /**
     * 在群组中发送普通消息
     *
     * @see https://cloud.tencent.com/document/product/269/1629
     *
     * @param string $groupId
     * @param string|int|null $fromAccount
     * @param string $msgPriority
     * @param bool $onlineOnlyFlag
     * @param array|string|int|null $toAccount
     * @return Collection
     *
     * @throws InvalidConfigException
     * @throws GuzzleException
     */
    public function sendMsg(string $groupId, string|int $fromAccount = null, string $msgPriority = '',
                            bool $onlineOnlyFlag = false, array|string|int $toAccount = null): Collection
    {
        return $this->httpPostJson(
            'v4/group_open_http_svc/send_group_msg',
            array_merge([
                'GroupId'   => $groupId,
                'MsgRandom' => $this->getRandom(),
                'MsgBody'   => $this->msgBody,
            ], array_filter([
                'MsgPriority'           => $msgPriority,
                'From_Account'          => (string)$fromAccount,
                'To_Account'            => array_map('strval', Arr::wrap($toAccount)),
                'OfflinePushInfo'       => $this->offlinePushInfo,
                'ForbidCallbackControl' => $this->forbidCallbackControl,
                'OnlineOnlyFlag'        => $onlineOnlyFlag ? 1 : 0,
                'SendMsgControl'        => $this->sendMsgControl,
                'CloudCustomData'       => $this->cloudCustomData,
            ])));
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
     * @param OfflinePushInfo $offlinePushInfo 离线推送信息配置
     *
     * @return $this
     */
    public function setOfflinePushInfo(OfflinePushInfo $offlinePushInfo): static
    {
        $this->offlinePushInfo = array_filter($offlinePushInfo->output());
        return $this;
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
     * @param array|string $msgSeq 被撤回的消息 seq 列表，一次请求最多可以撤回10条消息 seq
     *
     * @return Collection
     *
     * @throws InvalidConfigException
     * @throws GuzzleException
     */
    public function groupMsgRecall(string $groupId, array|string $msgSeq): Collection
    {
        $msgSeqList = [];
        foreach (Arr::wrap($msgSeq) as $value) {
            $msgSeqList[] = ['MsgSeq' => $value];
        }

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
     * @param string|int $ownerAccount 群主 ID，成员使用 AVChatroom（直播群）时，必须每次调用进群操作
     * @param string $groupId 自定义群组 ID
     * @param int $createTime 群组的创建时间
     * @param GroupInfo|null $groupInfo 群资料
     *
     * @return Collection
     *
     * @throws InvalidConfigException
     * @throws GuzzleException
     */
    public function import(string $name, string $type = GroupType::PUBLIC, string|int $ownerAccount = '',
                           string $groupId = '', int $createTime = 0, GroupInfo $groupInfo = null): Collection
    {
        return $this->httpPostJson(
            'v4/group_open_http_svc/create_group',
            array_merge([
                'Type' => $type,
                'Name' => $name,
            ], array_filter([
                'Owner_Account' => (string)$ownerAccount,
                'GroupId'       => $groupId,
                'CreateTime'    => $createTime,
            ]), array_filter(
                isset($groupInfo) ? $groupInfo->output() : []
            )));
    }

    /**
     * 导入群消息
     *
     * @see https://cloud.tencent.com/document/product/269/1635
     *
     * @param string $groupId 要导入消息的群 ID
     * @param GroupMsgList $groupMsgList 导入的消息列表
     * @param bool $recentContactFlag 是否会话更新识别
     * @param string $topicId 话题的 ID, 仅支持话题的社群适用此选项
     *
     * @return Collection
     *
     * @throws InvalidConfigException
     * @throws GuzzleException
     */
    public function importMsg(string $groupId, GroupMsgList $groupMsgList,
                              bool $recentContactFlag = false, string $topicId = ''): Collection
    {
        return $this->httpPostJson(
            'v4/group_open_http_svc/import_group_msg',
            array_merge([
                'GroupId' => $groupId,
                'MsgList' => $groupMsgList->getMsgList(),
            ], array_filter([
                'RecentContactFlag' => $recentContactFlag ? 1 : 0,
                'TopicId'           => $topicId,
            ])));
    }

    /**
     * 导入群成员
     *
     * @see https://cloud.tencent.com/document/product/269/1636
     *
     * @param string $groupId 操作的群 ID
     * @param array $memberList 待添加的群成员数组
     *
     * @return Collection
     *
     * @throws InvalidConfigException
     * @throws GuzzleException
     */
    public function importMember(string $groupId, array $memberList): Collection
    {
        // TODO 优化 MemberList
        return $this->httpPostJson(
            'v4/group_open_http_svc/import_group_member',
            [
                'GroupId'    => $groupId,
                'MemberList' => $memberList,
            ]);
    }

    /**
     * 设置成员未读消息计数
     *
     * @see https://cloud.tencent.com/document/product/269/1637
     *
     * @param string $groupId 操作的群 ID
     * @param string|int $memberAccount 要操作的群成员
     * @param int $unreadMsgNum 成员未读消息数
     *
     * @return Collection
     *
     * @throws InvalidConfigException
     * @throws GuzzleException
     */
    public function setUnreadMsgNum(string $groupId, string|int $memberAccount, int $unreadMsgNum): Collection
    {
        return $this->httpPostJson(
            'v4/group_open_http_svc/set_unread_msg_num',
            [
                'GroupId'        => $groupId,
                'Member_Account' => (string)$memberAccount,
                'UnreadMsgNum'   => $unreadMsgNum,
            ]);
    }

    /**
     * 删除指定用户发送的消息
     *
     * @see https://cloud.tencent.com/document/product/269/2359
     *
     * @param string $groupId 要撤回消息的群 ID
     * @param string|int $senderAccount 被撤回消息的发送者 ID
     *
     * @return Collection
     *
     * @throws InvalidConfigException
     * @throws GuzzleException
     */
    public function deleteMsgBySender(string $groupId, string|int $senderAccount): Collection
    {
        return $this->httpPostJson(
            'v4/group_open_http_svc/delete_group_msg_by_sender',
            [
                'GroupId'        => $groupId,
                'Sender_Account' => (string)$senderAccount,
            ]);
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
    public function getHistory(string $groupId, int $reqMsgNumber = 20, int $reqMsgSeq = 0, int $withRecalledMsg = 0): Collection
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
     * @param string $groupId 操作的群 ID
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
     * 获取直播群在线成员列表
     *
     * @see https://cloud.tencent.com/document/product/269/77266
     *
     * @param string $groupId 操作的群 ID
     * @param int $timestamp 首次请求传0，当直播群中人数较多时，后台返回非0的 Timestamp 表示需要分页拉取，后续请求将 Timestamp 传回，直到后台返回0
     *
     * @return Collection
     *
     * @throws InvalidConfigException
     * @throws GuzzleException
     */
    public function getMembers(string $groupId, $timestamp = 0): Collection
    {
        return $this->httpPostJson(
            'v4/group_open_avchatroom_http_svc/get_members',
            [
                'GroupId'   => $groupId,
                'Timestamp' => $timestamp,
            ]);
    }

    /**
     * 获取群自定义属性
     *
     * @see https://cloud.tencent.com/document/product/269/67012
     *
     * @param string $groupId 获取自定义属性的群id
     *
     * @return Collection
     *
     * @throws InvalidConfigException
     * @throws GuzzleException
     */
    public function getAttr(string $groupId): Collection
    {
        return $this->httpPostJson(
            'v4/group_open_attr_http_svc/get_group_attr',
            [
                'GroupId' => $groupId,
            ]);
    }

    /**
     * 修改群自定义属性
     *
     * @see https://cloud.tencent.com/document/product/269/67010
     *
     * @param string $groupId 修改自定义属性的群id
     * @param array $groupAttr 自定义属性列表，key 为自定义属性的键，value 为自定义属性的值
     *
     * @return Collection
     *
     * @throws InvalidConfigException
     * @throws GuzzleException
     */
    public function modifyAttr(string $groupId, array $groupAttr): Collection
    {
        return $this->httpPostJson(
            'v4/group_open_http_svc/modify_group_attr',
            [
                'GroupId'   => $groupId,
                'GroupAttr' => $groupAttr,
            ]);
    }

    /**
     * 清空群自定义属性
     *
     * @see https://cloud.tencent.com/document/product/269/67009
     *
     * @param string $groupId 清空自定义属性的群 id
     * @return Collection
     *
     * @throws InvalidConfigException
     * @throws GuzzleException
     */
    public function clearAttr(string $groupId): Collection
    {
        return $this->httpPostJson(
            'v4/group_open_http_svc/clear_group_attr',
            [
                'GroupId' => $groupId,
            ]);
    }

    /**
     * 重置群自定义属性
     *
     * @see https://cloud.tencent.com/document/product/269/67011
     *
     * @param string $groupId 重置自定义属性的群id
     * @param array $groupAttr 自定义属性列表，key 为自定义属性的键，value 为自定义属性的值
     *
     * @return Collection
     *
     * @throws InvalidConfigException
     * @throws GuzzleException
     */
    public function setAttr(string $groupId, array $groupAttr): Collection
    {
        return $this->httpPostJson(
            'v4/group_open_http_svc/set_group_attr',
            [
                'GroupId'   => $groupId,
                'GroupAttr' => $groupAttr,
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
    public function getGroupMsgReceiptDetail(string $groupId, int $filter = 1, string $cursor = '', int $count = 200, int $msgSeq = 0): Collection
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
     * @param array|int $msgSeq 拉取消息的 seq 列表
     *
     * @return Collection
     *
     * @throws InvalidConfigException
     * @throws GuzzleException
     */
    public function getGroupMsgReceipt(string $groupId, array|int $msgSeq): Collection
    {
        $msgSeqList = [];
        foreach (Arr::wrap($msgSeq) as $value) {
            $msgSeqList[] = ['MsgSeq' => $value];
        }

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
}