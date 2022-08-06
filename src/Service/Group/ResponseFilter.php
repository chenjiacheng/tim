<?php

declare(strict_types=1);

namespace Chenjiacheng\Tim\Service\Group;

class ResponseFilter
{
    /**
     * @var array
     */
    public array $groupBaseInfoFilter;

    /**
     * @var array
     */
    public array $memberInfoFilter;

    /**
     * @var array
     */
    public array $appDefinedDataFilterGroup;

    /**
     * @var array
     */
    public array $appDefinedDataFilterGroupMember;

    /**
     * GroupInfoResponseFilter constructor.
     * @param array $groupBaseInfoFilter 基础信息字段过滤器，指定需要获取的基础信息字段
     * @param array $memberInfoFilter 成员信息字段过滤器，指定需要获取的成员信息字段
     * @param array $appDefinedDataFilterGroup 该字段用来群组维度的自定义字段过滤器，指定需要获取的群组维度的自定义字段
     * @param array $appDefinedDataFilterGroupMember 该字段用来群成员维度的自定义字段过滤器，指定需要获取的群成员维度的自定义字段
     */
    public function __construct(array $groupBaseInfoFilter = [], array $memberInfoFilter = [],
                                array $appDefinedDataFilterGroup = [], array $appDefinedDataFilterGroupMember = [])
    {
        $this->groupBaseInfoFilter = $groupBaseInfoFilter;
        $this->memberInfoFilter = $memberInfoFilter;
        $this->appDefinedDataFilterGroup = $appDefinedDataFilterGroup;
        $this->appDefinedDataFilterGroupMember = $appDefinedDataFilterGroupMember;
    }

    /**
     * @return array
     */
    public function output(): array
    {
        return [
            'GroupBaseInfoFilter'              => $this->groupBaseInfoFilter,
            'MemberInfoFilter'                 => $this->memberInfoFilter,
            'AppDefinedDataFilter_Group'       => $this->appDefinedDataFilterGroup,
            'AppDefinedDataFilter_GroupMember' => $this->appDefinedDataFilterGroupMember,
        ];
    }

    /**
     * @return array
     */
    public function getGroupBaseInfoFilter(): array
    {
        return $this->groupBaseInfoFilter;
    }

    /**
     * @param array $groupBaseInfoFilter 基础信息字段过滤器，指定需要获取的基础信息字段
     *
     * @return $this
     */
    public function setGroupBaseInfoFilter(array $groupBaseInfoFilter): ResponseFilter
    {
        $this->groupBaseInfoFilter = $groupBaseInfoFilter;
        return $this;
    }

    /**
     * @return array
     */
    public function getMemberInfoFilter(): array
    {
        return $this->memberInfoFilter;
    }

    /**
     * @param array $memberInfoFilter 成员信息字段过滤器，指定需要获取的成员信息字段
     *
     * @return $this
     */
    public function setMemberInfoFilter(array $memberInfoFilter): ResponseFilter
    {
        $this->memberInfoFilter = $memberInfoFilter;
        return $this;
    }

    /**
     * @return array
     */
    public function getAppDefinedDataFilterGroup(): array
    {
        return $this->appDefinedDataFilterGroup;
    }

    /**
     * @param array $appDefinedDataFilterGroup 该字段用来群组维度的自定义字段过滤器，指定需要获取的群组维度的自定义字段
     *
     * @return $this
     */
    public function setAppDefinedDataFilterGroup(array $appDefinedDataFilterGroup): ResponseFilter
    {
        $this->appDefinedDataFilterGroup = $appDefinedDataFilterGroup;
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
     * @param array $appDefinedDataFilterGroupMember 该字段用来群成员维度的自定义字段过滤器，指定需要获取的群成员维度的自定义字段
     *
     * @return $this
     */
    public function setAppDefinedDataFilterGroupMember(array $appDefinedDataFilterGroupMember): ResponseFilter
    {
        $this->appDefinedDataFilterGroupMember = $appDefinedDataFilterGroupMember;
        return $this;
    }
}