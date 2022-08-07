<?php

declare(strict_types=1);

namespace Chenjiacheng\Tim\Constant;

/**
 * 运营字段
 */
class OperateField
{
    /**
     * 应用名称
     */
    const APP_NAME = 'AppName';

    /**
     * 应用 SDKAppID
     */
    const APP_ID = 'AppId';

    /**
     * 所属客户名称
     */
    const COMPANY = 'Company';

    /**
     * 活跃用户数
     */
    const ACTIVE_USER_NUM = 'ActiveUserNum';

    /**
     * 新增注册人数
     */
    const REGIST_USER_NUM_ONE_DAY = 'RegistUserNumOneDay';

    /**
     * 累计注册人数
     */
    const REGIST_USER_NUM_TOTAL = 'RegistUserNumTotal';

    /**
     * 登录次数
     */
    const LOGIN_TIMES = 'LoginTimes';

    /**
     * 登录人数
     */
    const LOGIN_USER_NUM = 'LoginUserNum';

    /**
     * 上行消息数
     */
    const UP_MSG_NUM = 'UpMsgNum';

    /**
     * 发消息人数
     */
    const SEND_MSG_USER_NUM = 'SendMsgUserNum';

    /**
     * APNs 推送数
     */
    const APNS_MSG_NUM = 'APNSMsgNum';

    /**
     * 上行消息数（C2C）
     */
    const C2C_UP_MSG_NUM = 'C2CUpMsgNum';

    /**
     * 下行消息数（C2C）
     */
    const C2C_DOWN_MSG_NUM = 'C2CDownMsgNum';

    /**
     * 发消息人数（C2C）
     */
    const C2C_SEND_MSG_USER_NUM = 'C2CSendMsgUserNum';

    /**
     * APNs 推送数（C2C）
     */
    const C2C_APNS_MSG_NUM = 'C2CAPNSMsgNum';

    /**
     * 最高在线人数
     */
    const MAX_ONLINE_NUM = 'MaxOnlineNum';

    /**
     * 下行消息总数（C2C和群）
     */
    const DOWN_MSG_NUM = 'DownMsgNum';

    /**
     * 关系链对数增加量
     */
    const CHAIN_INCREASE = 'ChainIncrease';

    /**
     * 关系链对数删除量
     */
    const CHAIN_DECREASE = 'ChainDecrease';

    /**
     * 上行消息数（群）
     */
    const GROUP_UP_MSG_NUM = 'GroupUpMsgNum';

    /**
     * 下行消息数（群）
     */
    const GROUP_DOWN_MSG_NUM = 'GroupDownMsgNum';

    /**
     * 发消息人数（群）
     */
    const GROUP_SEND_MSG_USER_NUM = 'GroupSendMsgUserNum';

    /**
     * APNs 推送数（群）
     */
    const GROUP_APNS_MSG_NUM = 'GroupAPNSMsgNum';

    /**
     * 发消息群组数
     */
    const GROUP_SEND_MSG_GROUP_NUM = 'GroupSendMsgGroupNum';

    /**
     * 入群总数
     */
    const GROUP_JOIN_GROUP_TIMES = 'GroupJoinGroupTimes';

    /**
     * 退群总数
     */
    const GROUP_QUIT_GROUP_TIMES = 'GroupQuitGroupTimes';

    /**
     * 新增群组数
     */
    const GROUP_NEW_GROUP_NUM = 'GroupNewGroupNum';

    /**
     * 累计群组数
     */
    const GROUP_ALL_GROUP_NUM = 'GroupAllGroupNum';

    /**
     * 解散群个数
     */
    const GROUP_DESTROY_GROUP_NUM = 'GroupDestroyGroupNum';

    /**
     * 回调请求数
     */
    const CALL_BACK_REQ = 'CallBackReq';

    /**
     * 回调应答数
     */
    const CALL_BACK_RSP = 'CallBackRsp';

    /**
     * 日期
     */
    const DATE = 'Date';

}