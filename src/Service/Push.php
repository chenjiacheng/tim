<?php

declare(strict_types=1);

namespace Chenjiacheng\Tim\Service;

use Chenjiacheng\Tim\Exception\InvalidConfigException;
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
     * @param string|int|null $fromAccount
     * @param int|null $msgLifeTime
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
     * @param array $offlinePushInfo 离线推送信息配置
     *
     * @return $this
     */
    public function setOfflinePushInfo(array $offlinePushInfo): static
    {
        $this->offlinePushInfo = $offlinePushInfo;
        return $this;
    }
}