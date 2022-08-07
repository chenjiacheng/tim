<?php

declare(strict_types=1);

namespace Chenjiacheng\Tim\Service\Sms;

use Chenjiacheng\Tim\Constant\BlackCheckType;
use Chenjiacheng\Tim\Exception\InvalidArgumentException;
use Chenjiacheng\Tim\Exception\InvalidConfigException;
use Chenjiacheng\Tim\Service\AbstractService;
use Chenjiacheng\Tim\Support\Arr;
use Chenjiacheng\Tim\Support\Collection;
use Chenjiacheng\Tim\Tim;
use GuzzleHttp\Exception\GuzzleException;

class Black extends AbstractService
{
    /**
     * Black constructor.
     *
     * @param Tim $app
     * @param string $fromAccount
     */
    public function __construct(protected Tim $app, protected string $fromAccount)
    {
        parent::__construct($this->app);
    }

    /**
     * 添加黑名单
     *
     * @see https://cloud.tencent.com/document/product/269/3718
     *
     * @param array|string|int $toAccount 待添加为黑名单的用户 UserID 列表，单次请求的 To_Account 数不得超过1000
     *
     * @return Collection
     *
     * @throws InvalidConfigException
     * @throws GuzzleException
     */
    public function add(array|string|int $toAccount): Collection
    {
        return $this->httpPostJson(
            'v4/sns/black_list_add',
            [
                'From_Account' => $this->fromAccount,
                'To_Account'   => array_map('strval', Arr::wrap($toAccount)),
            ]);
    }

    /**
     * 拉取黑名单
     *
     * @see https://cloud.tencent.com/document/product/269/3722
     *
     * @param int $startIndex 拉取的起始位置
     * @param int $maxLimited 每页最多拉取的黑名单数
     * @param int $lastSequence 上一次拉黑名单时后台返回给客户端的 Seq，初次拉取时为0
     *
     * @return Collection
     *
     * @throws InvalidConfigException
     * @throws GuzzleException
     */
    public function get(int $startIndex = 0, int $maxLimited = 30, int $lastSequence = 0): Collection
    {
        return $this->httpPostJson(
            'v4/sns/black_list_get',
            [
                'From_Account' => $this->fromAccount,
                'StartIndex'   => $startIndex,
                'MaxLimited'   => $maxLimited,
                'LastSequence' => $lastSequence,
            ]);
    }

    /**
     * 检验黑名单
     *
     * @see https://cloud.tencent.com/document/product/269/3725
     *
     * @param array|string|int $toAccount 待校验的黑名单的 UserID 列表，单次请求的 To_Account 数不得超过1000
     * @param string $checkType 校验模式：单向校验黑名单关系=BlackCheckType::SINGLE，双向校验黑名单关系=BlackCheckType::BOTH
     *
     * @return Collection
     *
     * @throws InvalidArgumentException
     * @throws InvalidConfigException
     * @throws GuzzleException
     */
    public function check(array|string|int $toAccount, string $checkType = BlackCheckType::SINGLE): Collection
    {
        if (!in_array($checkType, [BlackCheckType::SINGLE, BlackCheckType::BOTH])) {
            throw new InvalidArgumentException(sprintf('Unsupported check type "%s"', $checkType));
        }

        return $this->httpPostJson(
            'v4/sns/black_list_check',
            [
                'From_Account' => $this->fromAccount,
                'To_Account'   => array_map('strval', Arr::wrap($toAccount)),
                'CheckType'    => $checkType,
            ]);
    }

    /**
     * 删除黑名单
     *
     * @see https://cloud.tencent.com/document/product/269/3719
     *
     * @param array|string|int $toAccount 待删除的黑名单的 UserID 列表，单次请求的 To_Account 数不得超过1000
     *
     * @return Collection
     *
     * @throws InvalidConfigException
     * @throws GuzzleException
     */
    public function delete(array|string|int $toAccount): Collection
    {
        return $this->httpPostJson(
            'v4/sns/black_list_delete',
            [
                'From_Account' => $this->fromAccount,
                'To_Account'   => array_map('strval', Arr::wrap($toAccount)),
            ]);
    }
}