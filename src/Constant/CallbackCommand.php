<?php

declare(strict_types=1);

namespace Chenjiacheng\Tim\Constant;

/**
 * 回调命令列表
 */
class CallbackCommand
{
    /**
     * 状态变更回调
     */
    const STATE_STATE_CHANGE = 'State.StateChange';

    /**
     * 更新资料之后回调
     */
    const PROFILE_CALLBACK_PORTRAIT_SET = 'Profile.CallbackPortraitSet';

    /**
     * 添加好友之前回调
     */
    const SNS_CALLBACK_PREV_FRIEND_ADD = 'Sns.CallbackPrevFriendAdd';

    /**
     * 添加好友回应之前回调
     */
    const SNS_CALLBACK_PREV_FRIEND_RESPONSE = 'Sns.CallbackPrevFriendResponse';

    /**
     * 添加好友之后回调
     */
    const SNS_CALLBACK_FRIEND_ADD = 'Sns.CallbackFriendAdd';

    /**
     * 删除好友之后回调
     */
    const SNS_CALLBACK_FRIEND_DELETE = 'Sns.CallbackFriendDelete';

    /**
     * 添加黑名单之后回调
     */
    const SNS_CALLBACK_BLACK_LIST_ADD = 'Sns.CallbackBlackListAdd';

    /**
     * 删除黑名单之后回调
     */
    const SNS_CALLBACK_BLACK_LIST_DELETE = 'Sns.CallbackBlackListDelete';

    /**
     * 发单聊消息之前回调
     */
    const C2C_CALLBACK_BEFORE_SEND_MSG = 'C2C.CallbackBeforeSendMsg';

    /**
     * 发单聊消息之后回调
     */
    const C2C_CALLBACK_AFTER_SEND_MSG = 'C2C.CallbackAfterSendMsg';

    /**
     * 单聊消息已读上报后回调
     */
    const C2C_CALLBACK_AFTER_MSG_REPORT = 'C2C.CallbackAfterMsgReport';

    /**
     * 单聊消息撤回后回调
     */
    const C2C_CALLBACK_AFTER_MSG_WITH_DRAW = 'C2C.CallbackAfterMsgWithDraw';

    /**
     * 创建群组之前回调
     */
    const GROUP_CALLBACK_BEFORE_CREATE_GROUP = 'Group.CallbackBeforeCreateGroup';

    /**
     * 创建群组之后回调
     */
    const GROUP_CALLBACK_AFTER_CREATE_GROUP = 'Group.CallbackAfterCreateGroup';

    /**
     * 申请入群之前回调
     */
    const GROUP_CALLBACK_BEFORE_APPLY_JOIN_GROUP = 'Group.CallbackBeforeApplyJoinGroup';

    /**
     * 拉人入群之前回调
     */
    const GROUP_CALLBACK_BEFORE_INVITE_JOIN_GROUP = 'Group.CallbackBeforeInviteJoinGroup';

    /**
     * 新成员入群之后回调
     */
    const GROUP_CALLBACK_AFTER_NEW_MEMBER_JOIN = 'Group.CallbackAfterNewMemberJoin';

    /**
     * 群成员离开之后回调
     */
    const GROUP_CALLBACK_AFTER_MEMBER_EXIT = 'Group.CallbackAfterMemberExit';

    /**
     * 群内发言之前回调
     */
    const GROUP_CALLBACK_BEFORE_SEND_MSG = 'Group.CallbackBeforeSendMsg';

    /**
     * 群内发言之后回调
     */
    const GROUP_CALLBACK_AFTER_SEND_MSG = 'Group.CallbackAfterSendMsg';

    /**
     * 群组满员之后回调
     */
    const GROUP_CALLBACK_AFTER_GROUP_FULL = 'Group.CallbackAfterGroupFull';

    /**
     * 群组解散之后回调
     */
    const GROUP_CALLBACK_AFTER_GROUP_DESTROYED = 'Group.CallbackAfterGroupDestroyed';

    /**
     * 群组资料变动之后回调
     */
    const GROUP_CALLBACK_AFTER_GROUP_INFO_CHANGED = 'Group.CallbackAfterGroupInfoChanged';

    /**
     * 直播群成员在线状态回调
     */
    const GROUP_CALLBACK_ON_MEMBER_STATE_CHANGE = 'Group.CallbackOnMemberStateChange';

    /**
     * 发送群聊消息异常回调
     */
    const GROUP_CALLBACK_SEND_MSG_EXCEPTION = 'Group.CallbackSendMsgException';

    /**
     * 创建话题之前回调
     */
    const GROUP_CALLBACK_BEFORE_CREATE_TOPIC = 'Group.CallbackBeforeCreateTopic';

    /**
     * 创建话题之后回调
     */
    const GROUP_CALLBACK_AFTER_CREATE_TOPIC = 'Group.CallbackAfterCreateTopic';

    /**
     * 解散话题之后回调
     */
    const GROUP_CALLBACK_AFTER_TOPIC_DESTROYED = 'Group.CallbackAfterTopicDestroyed';

    /**
     * 话题资料修改之后回调
     */
    const GROUP_CALLBACK_AFTER_TOPIC_INFO_CHANGED = 'Group.CallbackAfterTopicInfoChanged';
}