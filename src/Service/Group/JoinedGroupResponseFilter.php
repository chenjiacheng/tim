<?php

declare(strict_types=1);

namespace Chenjiacheng\Tim\Service\Group;

class JoinedGroupResponseFilter
{
    /**
     * GroupMemberResponseFilter constructor.
     *
     * @param array $groupBaseInfoFilter 需要拉取哪些基础信息字段
     * @param array $selfInfoFilter 需要拉取用户在每个群组中的哪些个人资料
     */
    public function __construct(public array $groupBaseInfoFilter = [],
                                public array $selfInfoFilter = [])
    {
    }

    /**
     * @return array
     */
    public function output(): array
    {
        return [
            'GroupBaseInfoFilter' => $this->groupBaseInfoFilter,
            'SelfInfoFilter'      => $this->selfInfoFilter,
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
     * @param array $groupBaseInfoFilter 需要拉取哪些基础信息字段
     *
     * @return JoinedGroupResponseFilter
     */
    public function setGroupBaseInfoFilter(array $groupBaseInfoFilter): JoinedGroupResponseFilter
    {
        $this->groupBaseInfoFilter = $groupBaseInfoFilter;
        return $this;
    }

    /**
     * @return array
     */
    public function getSelfInfoFilter(): array
    {
        return $this->selfInfoFilter;
    }

    /**
     * @param array $selfInfoFilter 需要拉取用户在每个群组中的哪些个人资料
     *
     * @return JoinedGroupResponseFilter
     */
    public function setSelfInfoFilter(array $selfInfoFilter): JoinedGroupResponseFilter
    {
        $this->selfInfoFilter = $selfInfoFilter;
        return $this;
    }
}