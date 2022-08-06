<?php

declare(strict_types=1);

namespace Chenjiacheng\Tim\Service\Group;

use Chenjiacheng\Tim\Service\AbstractService;
use Chenjiacheng\Tim\Support\Collection;
use Chenjiacheng\Tim\Tim;
use JetBrains\PhpStorm\Pure;

class GroupAttr extends AbstractService
{
    /**
     * @var string
     */
    protected string $groupId;

    /**
     * GroupAttr constructor.
     * @param Tim $app
     * @param string $groupId 操作的群 ID
     */
    #[Pure] public function __construct(Tim $app, string $groupId)
    {
        parent::__construct($app);

        $this->groupId = $groupId;
    }

    /**
     * 重置群自定义属性
     *
     * @see https://cloud.tencent.com/document/product/269/67011
     *
     * @param array $groupAttr 自定义属性列表，key 为自定义属性的键，value 为自定义属性的值
     *
     * @return \Chenjiacheng\Tim\Support\Collection
     *
     * @throws \Chenjiacheng\Tim\Exception\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function set(array $groupAttr): Collection
    {
        return $this->httpPostJson(
            'v4/group_open_http_svc/set_group_attr',
            [
                'GroupId'   => $this->groupId,
                'GroupAttr' => $groupAttr,
            ]);
    }

    /**
     * 获取群自定义属性
     *
     * @see https://cloud.tencent.com/document/product/269/67012
     *
     * @return \Chenjiacheng\Tim\Support\Collection
     *
     * @throws \Chenjiacheng\Tim\Exception\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function get(): Collection
    {
        return $this->httpPostJson(
            'v4/group_open_attr_http_svc/get_group_attr',
            [
                'GroupId' => $this->groupId,
            ]);
    }

    /**
     * 修改群自定义属性
     *
     * @see https://cloud.tencent.com/document/product/269/67010
     *
     * @param array $groupAttr 自定义属性列表，key 为自定义属性的键，value 为自定义属性的值
     *
     * @return \Chenjiacheng\Tim\Support\Collection
     *
     * @throws \Chenjiacheng\Tim\Exception\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function modify(array $groupAttr): Collection
    {
        return $this->httpPostJson(
            'v4/group_open_http_svc/modify_group_attr',
            [
                'GroupId'   => $this->groupId,
                'GroupAttr' => $groupAttr,
            ]);
    }

    /**
     * 清空群自定义属性
     *
     * @see https://cloud.tencent.com/document/product/269/67009
     *
     * @return \Chenjiacheng\Tim\Support\Collection
     *
     * @throws \Chenjiacheng\Tim\Exception\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function clear(): Collection
    {
        return $this->httpPostJson(
            'v4/group_open_http_svc/clear_group_attr',
            [
                'GroupId' => $this->groupId,
            ]);
    }
}