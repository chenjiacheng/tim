<?php

declare(strict_types=1);

namespace Chenjiacheng\Tim\Service\Group;

use Chenjiacheng\Tim\Service\AbstractService;
use Chenjiacheng\Tim\Support\Arr;
use Chenjiacheng\Tim\Support\Collection;
use Chenjiacheng\Tim\Tim;
use JetBrains\PhpStorm\Pure;

class GroupMember extends AbstractService
{
    /**
     * @var string
     */
    protected string $groupId;

    /**
     * GroupMember constructor.
     * @param Tim $app
     * @param string $groupId
     */
    #[Pure] public function __construct(Tim $app, string $groupId)
    {
        parent::__construct($app);

        $this->groupId = $groupId;
    }

    /**
     * 获取群成员详细资料
     *
     * @see https://cloud.tencent.com/document/product/269/1617
     *
     * @param int $limit 一次最多获取多少个成员的资料，不得超过200。如果不填，则获取群内全部成员的信息
     * @param int $offset 从第几个成员开始获取，如果不填则默认为0，表示从第一个成员开始获取
     * @param string $next 上一次拉取到的成员位置，社群必填，社群不支持 Offset 参数，使用 Next 参数，首次调用填写""，续拉使用返回中的 Next 值
     * @param array $memberInfoFilter 需要获取哪些信息， 如果没有该字段则为群成员全部资料
     * @param array $memberRoleFilter 拉取指定身份的群成员资料。如没有填写该字段，默认为所有身份成员资料，成员身份可以为：“Owner”，“Admin”，“Member”
     * @param array $appDefinedDataFilterGroupMember 默认情况是没有的。该字段用来群成员维度的自定义字段过滤器，指定需要获取的群成员维度的自定义字段
     *
     * @return \Chenjiacheng\Tim\Support\Collection
     *
     * @throws \Chenjiacheng\Tim\Exception\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function get(int $limit = 0, int $offset = 0, string $next = '', array $memberInfoFilter = [],
                        array $memberRoleFilter = [], array $appDefinedDataFilterGroupMember = []): Collection
    {
        return $this->httpPostJson(
            'v4/group_open_http_svc/get_group_member_info',
            array_merge([
                'GroupId' => $this->groupId,
            ], array_filter([
                'Limit'                            => $limit,
                'Offset'                           => $offset,
                'Next'                             => $next,
                'MemberInfoFilter'                 => $memberInfoFilter,
                'MemberRoleFilter'                 => $memberRoleFilter,
                'AppDefinedDataFilter_GroupMember' => $appDefinedDataFilterGroupMember,
            ])));
    }

    /**
     * 增加群成员
     *
     * @see https://cloud.tencent.com/document/product/269/1621
     *
     * @param array $memberList 待添加的群成员数组
     * @param bool $silence 是否静默加人
     *
     * @return \Chenjiacheng\Tim\Support\Collection
     *
     * @throws \Chenjiacheng\Tim\Exception\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function add(array $memberList, bool $silence = false): Collection
    {
        return $this->httpPostJson(
            'v4/group_open_http_svc/add_group_member',
            array_merge([
                'GroupId'    => $this->groupId,
                'MemberList' => $memberList,
            ], array_filter([
                'Silence' => $silence ? 1 : 0
            ])));
    }

    /**
     * 修改群成员资料
     *
     * @see https://cloud.tencent.com/document/product/269/1623
     *
     * @param array $memberAccount 要操作的群成员
     * @param string $role 成员身份，Admin/Member 分别为设置/取消管理员
     * @param string $msgFlag 消息屏蔽类型
     * @param string $nameCard 群名片（最大不超过50个字节）
     * @param array $appMemberDefinedData 群成员维度的自定义字段
     * @param int $muteTime 需禁言时间，单位为秒，0表示取消禁言
     *
     * @return \Chenjiacheng\Tim\Support\Collection
     *
     * @throws \Chenjiacheng\Tim\Exception\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function modify(array $memberAccount, string $role = '', string $msgFlag = '',
                           string $nameCard = '', array $appMemberDefinedData = [], int $muteTime = 0): Collection
    {
        return $this->httpPostJson(
            'v4/group_open_http_svc/modify_group_member_info',
            array_merge([
                'GroupId'        => $this->groupId,
                'Member_Account' => $memberAccount,
            ], array_filter([
                'Role'                 => $role,
                'MsgFlag'              => $msgFlag,
                'NameCard'             => $nameCard,
                'AppMemberDefinedData' => $appMemberDefinedData,
                'MuteTime'             => $muteTime,
            ])));
    }

    /**
     * 删除群成员
     *
     * @see https://cloud.tencent.com/document/product/269/1622
     *
     * @param array|string|int $memberToDelAccount 待删除的群成员
     * @param string $reason 踢出用户原因
     * @param bool $silence 是否静默删人
     *
     * @return \Chenjiacheng\Tim\Support\Collection
     *
     * @throws \Chenjiacheng\Tim\Exception\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function delete(array|string|int $memberToDelAccount,
                           string $reason = '', bool $silence = false): Collection
    {
        return $this->httpPostJson(
            'v4/group_open_http_svc/delete_group_member',
            array_merge([
                'GroupId'             => $this->groupId,
                'MemberToDel_Account' => array_map('strval', Arr::wrap($memberToDelAccount)),
            ], array_filter([
                'Reason'  => $reason,
                'Silence' => $silence ? 1 : 0
            ])));
    }

    /**
     * 查询用户在群组中的身份
     *
     * @see https://cloud.tencent.com/document/product/269/1626
     *
     * @param array|string|int $userAccount 表示需要查询的用户帐号，最多支持500个帐号
     *
     * @return \Chenjiacheng\Tim\Support\Collection
     *
     * @throws \Chenjiacheng\Tim\Exception\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getRole(array|string|int $userAccount): Collection
    {
        return $this->httpPostJson(
            'v4/group_open_http_svc/get_role_in_group',
            [
                'GroupId'      => $this->groupId,
                'User_Account' => array_map('strval', Arr::wrap($userAccount)),
            ]);
    }

    /**
     * 设置成员未读消息计数
     *
     * @see https://cloud.tencent.com/document/product/269/1637
     *
     * @param string|int $memberAccount 要操作的群成员
     * @param int $unreadMsgNum 成员未读消息数
     *
     * @return \Chenjiacheng\Tim\Support\Collection
     *
     * @throws \Chenjiacheng\Tim\Exception\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function setUnreadMsgNum(string|int $memberAccount, int $unreadMsgNum): Collection
    {
        return $this->httpPostJson(
            'v4/group_open_http_svc/set_unread_msg_num',
            [
                'GroupId'        => $this->groupId,
                'Member_Account' => (string)$memberAccount,
                'UnreadMsgNum'   => $unreadMsgNum,
            ]);
    }

    /**
     * 删除指定用户发送的消息
     *
     * @see https://cloud.tencent.com/document/product/269/2359
     *
     * @param string|int $senderAccount 被撤回消息的发送者 ID
     *
     * @return \Chenjiacheng\Tim\Support\Collection
     *
     * @throws \Chenjiacheng\Tim\Exception\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function deleteMsgBySender(string|int $senderAccount): Collection
    {
        return $this->httpPostJson(
            'v4/group_open_http_svc/delete_group_msg_by_sender',
            [
                'GroupId'        => $this->groupId,
                'Sender_Account' => (string)$senderAccount,
            ]);
    }

    /**
     * 获取直播群在线成员列表
     *
     * @see https://cloud.tencent.com/document/product/269/77266
     *
     * @param int $timestamp 首次请求传0，当直播群中人数较多时，后台返回非0的 Timestamp 表示需要分页拉取，后续请求将 Timestamp 传回，直到后台返回0
     *
     * @return \Chenjiacheng\Tim\Support\Collection
     *
     * @throws \Chenjiacheng\Tim\Exception\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getMembers($timestamp = 0): Collection
    {
        return $this->httpPostJson(
            'v4/group_open_avchatroom_http_svc/get_members',
            [
                'GroupId'   => $this->groupId,
                'Timestamp' => $timestamp,
            ]);
    }

    /**
     * 批量禁言和取消禁言
     *
     * @see https://cloud.tencent.com/document/product/269/1627
     *
     * @param array|string|int $membersAccount 需要禁言的用户帐号，最多支持500个帐号
     * @param int $muteTime 无符号类型。需禁言时间，单位为秒，为0时表示取消禁言，4294967295为永久禁言
     *
     * @return \Chenjiacheng\Tim\Support\Collection
     *
     * @throws \Chenjiacheng\Tim\Exception\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function forbidSendMsg(array|string|int $membersAccount, int $muteTime = 4294967295): Collection
    {
        return $this->httpPostJson(
            'v4/group_open_http_svc/forbid_send_msg',
            [
                'GroupId'         => $this->groupId,
                'Members_Account' => array_map('strval', Arr::wrap($membersAccount)),
                'MuteTime'        => $muteTime,
            ]);
    }

    /**
     * 获取被禁言群成员列表
     *
     * @see https://cloud.tencent.com/document/product/269/2925
     *
     * @return \Chenjiacheng\Tim\Support\Collection
     *
     * @throws \Chenjiacheng\Tim\Exception\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getMutedAccount(): Collection
    {
        return $this->httpPostJson(
            'v4/group_open_http_svc/get_group_muted_account',
            [
                'GroupId' => $this->groupId,
            ]);
    }

    /**
     * 导入群成员
     *
     * @see https://cloud.tencent.com/document/product/269/1636
     *
     * @param array $memberList 待添加的群成员数组
     * @return \Chenjiacheng\Tim\Support\Collection
     *
     * @throws \Chenjiacheng\Tim\Exception\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function importMember(array $memberList): Collection
    {
        return $this->httpPostJson(
            'v4/group_open_http_svc/import_group_member',
            [
                'GroupId'    => $this->groupId,
                'MemberList' => $memberList,
            ]);
    }
}