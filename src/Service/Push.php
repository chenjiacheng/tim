<?php

declare(strict_types=1);

namespace Chenjiacheng\Tim\Service;

use Chenjiacheng\Tim\Exception\InvalidConfigException;
use Chenjiacheng\Tim\Support\Arr;
use Chenjiacheng\Tim\Support\Collection;
use GuzzleHttp\Exception\GuzzleException;

class Push extends AbstractService
{
    use TIMMsgTrait;

    protected array $condition;

    /**
     * 离线推送信息配置
     *
     * @var array
     */
    protected array $offlinePushInfo;

    /**
     * 全员推送
     *
     * @see https://cloud.tencent.com/document/product/269/45934
     *
     * @param string|int|null $fromAccount 消息推送方帐号
     * @param int|null $msgLifeTime 消息离线存储时间，单位秒，最多保存7天（604800秒）。默认为0，表示不离线存储，即只推在线用户
     *
     * @return Collection
     *
     * @throws InvalidConfigException
     * @throws GuzzleException
     */
    public function allMember(string|int $fromAccount = null, int $msgLifeTime = null): Collection
    {
        $data = [
            'MsgRandom' => $this->getRandom(),
        ];

        isset($fromAccount) && $data['From_Account'] = (string)$fromAccount;
        isset($msgLifeTime) && $data['MsgLifeTime'] = $msgLifeTime;
        isset($this->condition) && $data['Condition'] = $this->condition;
        isset($this->offlinePushInfo) && $data['OfflinePushInfo'] = $this->offlinePushInfo;

        return $this->httpPostJson('v4/all_member_push/im_push', $data);
    }

    /**
     * 设置应用属性名称
     *
     * @see https://cloud.tencent.com/document/product/269/45935
     *
     * @param array $attrNames 数字键，表示第几个属性（“0”到“9”之间）属性名最长不超过50字节。
     *
     * @return Collection
     *
     * @throws InvalidConfigException
     * @throws GuzzleException
     */
    public function setAppAttr(array $attrNames): Collection
    {
        return $this->httpPostJson(
            'v4/all_member_push/im_set_attr_name',
            [
                'AttrNames' => $attrNames,
            ]);
    }

    /**
     * 获取应用属性名称
     *
     * @see https://cloud.tencent.com/document/product/269/45936
     *
     * @return Collection
     *
     * @throws InvalidConfigException
     * @throws GuzzleException
     */
    public function getAppAttr(): Collection
    {
        return $this->httpPostJson('v4/all_member_push/im_get_attr_name');
    }

    /**
     * 获取用户属性
     *
     * @see https://cloud.tencent.com/document/product/269/45937
     *
     * @param array|string|int $toAccount 目标用户帐号列表
     *
     * @return Collection
     *
     * @throws InvalidConfigException
     * @throws GuzzleException
     */
    public function getAttr(array|string|int $toAccount): Collection
    {
        return $this->httpPostJson(
            'v4/all_member_push/im_get_attr',
            [
                'To_Account' => array_map('strval', Arr::wrap($toAccount)),
            ]);
    }

    /**
     * 设置用户属性
     *
     * @see https://cloud.tencent.com/document/product/269/45938
     *
     * @param array $userAttrs 目标用户帐号和属性集合
     *
     * @return Collection
     *
     * @throws InvalidConfigException
     * @throws GuzzleException
     */
    public function setAttr(array $userAttrs): Collection
    {
        return $this->httpPostJson(
            'v4/all_member_push/im_set_attr',
            [
                'UserAttrs' => $userAttrs,
            ]);
    }

    /**
     * 删除用户属性
     *
     * @see https://cloud.tencent.com/document/product/269/45939
     *
     * @param array $userAttrs 目标用户帐号和属性集合
     *
     * @return Collection
     *
     * @throws InvalidConfigException
     * @throws GuzzleException
     */
    public function removeAttr(array $userAttrs): Collection
    {
        return $this->httpPostJson(
            'v4/all_member_push/im_remove_attr',
            [
                'UserAttrs' => $userAttrs,
            ]);
    }

    /**
     * 获取用户标签
     *
     * @see https://cloud.tencent.com/document/product/269/45940
     *
     * @param array|string|int $toAccount 目标用户帐号列表
     *
     * @return Collection
     *
     * @throws InvalidConfigException
     * @throws GuzzleException
     */
    public function getTag(array|string|int $toAccount): Collection
    {
        return $this->httpPostJson(
            'v4/all_member_push/im_get_tag',
            [
                'To_Account' => array_map('strval', Arr::wrap($toAccount)),
            ]);
    }

    /**
     * 添加用户标签
     *
     * @see https://cloud.tencent.com/document/product/269/45941
     *
     * @param array $userTags 目标用户帐号和标签集合
     *
     * @return Collection
     *
     * @throws InvalidConfigException
     * @throws GuzzleException
     */
    public function setTag(array $userTags): Collection
    {
        return $this->httpPostJson(
            'v4/all_member_push/im_add_tag',
            [
                'UserTags' => $userTags,
            ]);
    }

    /**
     * 删除用户标签
     *
     * @see https://cloud.tencent.com/document/product/269/45942
     *
     * @param array $userTags 目标用户帐号和标签集合
     *
     * @return Collection
     *
     * @throws InvalidConfigException
     * @throws GuzzleException
     */
    public function removeTag(array $userTags): Collection
    {
        return $this->httpPostJson(
            'v4/all_member_push/im_remove_tag',
            [
                'UserTags' => $userTags,
            ]);
    }

    /**
     * 删除用户所有标签
     *
     * @see https://cloud.tencent.com/document/product/269/45943
     *
     * @param array|string|int $toAccount 目标用户帐号
     *
     * @return Collection
     *
     * @throws InvalidConfigException
     * @throws GuzzleException
     */
    public function removeAllTags(array|string|int $toAccount): Collection
    {
        return $this->httpPostJson(
            'v4/all_member_push/im_remove_all_tags',
            [
                'To_Account' => array_map('strval', Arr::wrap($toAccount)),
            ]);
    }

    /**
     * @param array $offlinePushInfo 离线推送信息配置
     *
     * @return $this
     */
    public function setOfflinePushInfo(array $offlinePushInfo): static
    {
        $this->offlinePushInfo = $offlinePushInfo;
        return $this;
    }

    /**
     * @param array $tags
     * @return $this
     */
    public function tagsAnd(array $tags): Push
    {
        $this->condition['TagsAnd'] = isset($this->condition['TagsAnd']) ?
            array_merge($this->condition['TagsAnd'], $tags) : $tags;

        return $this;
    }

    /**
     * @param array $tags
     * @return $this
     */
    public function tagsOr(array $tags): Push
    {
        $this->condition['TagsOr'] = isset($this->condition['TagsOr']) ?
            array_merge($this->condition['TagsOr'], $tags) : $tags;

        return $this;
    }

    /**
     * @param array $attrs
     * @return $this
     */
    public function attrsAnd(array $attrs): Push
    {
        $this->condition['AttrsAnd'] = isset($this->condition['AttrsAnd']) ?
            array_merge($this->condition['AttrsAnd'], $attrs) : $attrs;

        return $this;
    }

    /**
     * @param array $attrs
     * @return $this
     */
    public function attrsOr(array $attrs): Push
    {
        $this->condition['AttrsOr'] = isset($this->condition['AttrsOr']) ?
            array_merge($this->condition['AttrsOr'], $attrs) : $attrs;

        return $this;
    }
}