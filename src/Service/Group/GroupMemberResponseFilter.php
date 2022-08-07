<?php

declare(strict_types=1);

namespace Chenjiacheng\Tim\Service\Group;

class GroupMemberResponseFilter
{
    /**
     * GroupMemberResponseFilter constructor.
     *
     * @param array $memberInfoFilter 需要获取哪些信息， 如果没有该字段则为群成员全部资料
     * @param array $memberRoleFilter 拉取指定身份的群成员资料。如没有填写该字段，默认为所有身份成员资料，成员身份可以为：“Owner”，“Admin”，“Member”
     * @param array $appDefinedDataFilterGroupMember 默认情况是没有的。该字段用来群成员维度的自定义字段过滤器，指定需要获取的群成员维度的自定义字段
     */
    public function __construct(public array $memberInfoFilter = [],
                                public array $memberRoleFilter = [],
                                public array $appDefinedDataFilterGroupMember = [])
    {
    }

    /**
     * @return array
     */
    public function output(): array
    {
        return [
            'MemberInfoFilter'                 => $this->memberInfoFilter,
            'MemberRoleFilter'                 => $this->memberRoleFilter,
            'AppDefinedDataFilter_GroupMember' => $this->appDefinedDataFilterGroupMember,
        ];
    }

    /**
     * @return array
     */
    public function getMemberInfoFilter(): array
    {
        return $this->memberInfoFilter;
    }

    /**
     * @param array $memberInfoFilter
     * @return GroupMemberResponseFilter
     */
    public function setMemberInfoFilter(array $memberInfoFilter): GroupMemberResponseFilter
    {
        $this->memberInfoFilter = $memberInfoFilter;
        return $this;
    }

    /**
     * @return array
     */
    public function getMemberRoleFilter(): array
    {
        return $this->memberRoleFilter;
    }

    /**
     * @param array $memberRoleFilter
     * @return GroupMemberResponseFilter
     */
    public function setMemberRoleFilter(array $memberRoleFilter): GroupMemberResponseFilter
    {
        $this->memberRoleFilter = $memberRoleFilter;
        return $this;
    }

    /**
     * @return array
     */
    public function getAppDefinedDataFilterGroupMember(): array
    {
        return $this->appDefinedDataFilterGroupMember;
    }

    /**
     * @param array $appDefinedDataFilterGroupMember
     * @return GroupMemberResponseFilter
     */
    public function setAppDefinedDataFilterGroupMember(array $appDefinedDataFilterGroupMember): GroupMemberResponseFilter
    {
        $this->appDefinedDataFilterGroupMember = $appDefinedDataFilterGroupMember;
        return $this;
    }
}