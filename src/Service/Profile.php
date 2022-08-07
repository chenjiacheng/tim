<?php

declare(strict_types=1);

namespace Chenjiacheng\Tim\Service;

use Chenjiacheng\Tim\Exception\InvalidConfigException;
use Chenjiacheng\Tim\Support\Arr;
use Chenjiacheng\Tim\Support\Collection;
use GuzzleHttp\Exception\GuzzleException;

class Profile extends AbstractService
{
    /**
     * 设置资料
     *
     * @see https://cloud.tencent.com/document/product/269/1640
     *
     * @param string|int $fromAccount 需要设置该 UserID 的资料
     * @param array $profileTags 待设置的用户的资料
     *
     * @return Collection
     *
     * @throws InvalidConfigException
     * @throws GuzzleException
     */
    public function set(string|int $fromAccount, array $profileTags): Collection
    {
        $profileItem = [];
        foreach ($profileTags as $tag => $value) {
            $profileItem[] = ['Tag' => $tag, 'Value' => $value];
        }

        return $this->httpPostJson(
            'v4/profile/portrait_set',
            [
                'From_Account' => (string)$fromAccount,
                'ProfileItem'  => $profileItem,
            ]);
    }

    /**
     * 拉取资料
     *
     * @see https://cloud.tencent.com/document/product/269/1639
     *
     * @param array|string|int $toAccount 需要拉取这些 UserID 的资料，每次拉取的用户数不得超过100
     * @param array $tagList 指定要拉取的资料字段的 Tag
     *
     * @return Collection
     *
     * @throws InvalidConfigException
     * @throws GuzzleException
     */
    public function get(array|string|int $toAccount, array $tagList): Collection
    {
        return $this->httpPostJson(
            'v4/profile/portrait_get',
            [
                'To_Account' => array_map('strval', Arr::wrap($toAccount)),
                'TagList'    => $tagList,
            ]);
    }
}