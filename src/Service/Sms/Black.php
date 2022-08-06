<?php

declare(strict_types=1);

namespace Chenjiacheng\Tim\Service\Sms;

use Chenjiacheng\Tim\Exception\InvalidConfigException;
use Chenjiacheng\Tim\Service\AbstractService;
use Chenjiacheng\Tim\Support\Arr;
use Chenjiacheng\Tim\Support\Collection;
use Chenjiacheng\Tim\Tim;
use GuzzleHttp\Exception\GuzzleException;
use JetBrains\PhpStorm\Pure;

class Black extends AbstractService
{
    /**
     * @var string
     */
    protected string $fromAccount;

    /**
     * Black constructor.
     * @param Tim $app
     * @param string|int $fromAccount
     */
    #[Pure] public function __construct(Tim $app, string|int $fromAccount)
    {
        parent::__construct($app);

        $this->fromAccount = (string)$fromAccount;
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
     * @param int $lastSequence 上一次拉黑名单时后台返回给客户端的 Seq，初次拉取时为0；（Rest API 接口拉取填 0 即可）
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
     * @param bool $checkTypeSingle 校验模式：true 单向校验黑名单关系，false 双向校验黑名单关系
     *
     * @return Collection
     *
     * @throws InvalidConfigException
     * @throws GuzzleException
     */
    public function check(array|string|int $toAccount, bool $checkTypeSingle = false): Collection
    {
        return $this->httpPostJson(
            'v4/sns/black_list_check',
            [
                'From_Account' => $this->fromAccount,
                'To_Account'   => array_map('strval', Arr::wrap($toAccount)),
                'CheckType'    => $checkTypeSingle ? 'BlackCheckResult_Type_Single' : 'BlackCheckResult_Type_Both',
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