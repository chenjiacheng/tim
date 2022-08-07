<?php

declare(strict_types=1);

namespace Chenjiacheng\Tim\Constant;

/**
 * 群组类型
 *
 * Class GroupType
 * @package Chenjiacheng\Tim\Constant
 */
class GroupType
{
    /**
     * 公开群
     */
    const PUBLIC = 'Public';

    /**
     * 好友工作群
     */
    const PRIVATE = 'Private';

    /**
     * 会议群
     */
    const CHAT_ROOM = 'ChatRoom';

    /**
     * 音视频聊天室
     */
    const AV_CHAT_ROOM = 'AVChatRoom';

    /**
     * 在线成员广播大群
     */
    const B_CHAT_ROOM = 'BChatRoom';

    /**
     * 社群
     */
    const COMMUNITY = 'Community';
}