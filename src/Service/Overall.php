<?php

declare(strict_types=1);

namespace Chenjiacheng\Tim\Service;

use Chenjiacheng\Tim\Exception\InvalidConfigException;
use Chenjiacheng\Tim\Support\Collection;
use GuzzleHttp\Exception\GuzzleException;

class Overall extends AbstractService
{
    /**
     * 设置全局禁言
     *
     * @see https://cloud.tencent.com/document/product/269/4230
     *
     * @param string|int $setAccount 设置禁言配置的帐号
     * @param int|null $C2CMsgNoSpeakingTime 单聊消息禁言时间，单位为秒，非负整数，最大值为4294967295（永久禁言），0表示取消该帐号的单聊消息禁言
     * @param int|null $groupMsgNoSpeakingTime 群组消息禁言时间，单位为秒，非负整数，最大值为4294967295（永久禁言），0表示取消该帐号的群组消息禁言
     *
     * @return Collection
     *
     * @throws \Chenjiacheng\Tim\Exception\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function setNoSpeaking(string|int $setAccount, int $C2CMsgNoSpeakingTime = null, int $groupMsgNoSpeakingTime = null): Collection
    {
        return $this->httpPostJson(
            'v4/openconfigsvr/setnospeaking',
            array_merge([
                'Set_Account' => (string)$setAccount,
            ], isset($C2CMsgNoSpeakingTime) ? ['C2CmsgNospeakingTime' => $C2CMsgNoSpeakingTime] : [],
                isset($groupMsgNoSpeakingTime) ? ['GroupmsgNospeakingTime' => $groupMsgNoSpeakingTime] : []
            ));
    }

    /**
     * 查询全局禁言
     *
     * @see https://cloud.tencent.com/document/product/269/4229
     *
     * @param string|int $getAccount 查询禁言信息的帐号
     *
     * @return Collection
     *
     * @throws InvalidConfigException
     * @throws GuzzleException
     */
    public function getNoSpeaking(string|int $getAccount): Collection
    {
        return $this->httpPostJson(
            'v4/openconfigsvr/getnospeaking',
            [
                'Get_Account' => (string)$getAccount,
            ]);
    }
}