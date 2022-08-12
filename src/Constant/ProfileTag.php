<?php

declare(strict_types=1);

namespace Chenjiacheng\Tim\Constant;

/**
 * 标配资料字段
 */
class ProfileTag
{
    /**
     * string 昵称 长度不得超过500个字节
     */
    const NICK = 'Tag_Profile_IM_Nick';

    /**
     * string 性别
     *
     * 未知=ProfileGenderType::UNKNOWN
     * 男性=ProfileGenderType::MALE
     * 女性=ProfileGenderType::FEMALE
     */
    const GENDER = 'Tag_Profile_IM_Gender';

    /**
     * uint32 生日 推荐用法：20190419
     */
    const BIRTHDAY = 'Tag_Profile_IM_BirthDay';

    /**
     * string 所在地 长度不得超过16个字节
     */
    const LOCATION = 'Tag_Profile_IM_Location';

    /**
     * string 个性签名 长度不得超过500个字节
     */
    const SIGNATURE = 'Tag_Profile_IM_SelfSignature';

    /**
     * string 加好友验证方式
     *
     * 需要经过自己确认对方才能添加自己为好友=ProfileAllowType::NEED_CONFIRM
     * 允许任何人添加自己为好友=ProfileAllowType::ALLOW_ANY
     * 不允许任何人添加自己为好友=ProfileAllowType::DENY_ANY
     */
    const ALLOW_TYPE = 'Tag_Profile_IM_AllowType';

    /**
     * uint32 语言 App 本地定义数字与语言的映射关系，需要 App 本地将语言对应的数字转换为文字
     */
    const LANGUAGE = 'Tag_Profile_IM_Language';

    /**
     * string 头像URL 长度不得超过500个字节
     */
    const IMAGE = 'Tag_Profile_IM_Image';

    /**
     * string 管理员禁止加好友标识
     *
     * 允许加好友=ProfileAdminForbidType::NONE
     * 禁止该用户发起加好友请求=ProfileAdminForbidType::SEND_OUT
     */
    const ADMIN_FORBID_TYPE = 'Tag_Profile_IM_AdminForbidType';

    /**
     * uint32 等级
     */
    const LEVEL = 'Tag_Profile_IM_Level';

    /**
     * uint32 角色
     */
    const ROLE = 'Tag_Profile_IM_Role';
}