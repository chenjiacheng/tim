<?php

declare(strict_types=1);

namespace Chenjiacheng\Tim\Service\Message;

use Chenjiacheng\Tim\Contract\MessageElemInterface;
use Chenjiacheng\Tim\Contract\MessageInterface;
use Chenjiacheng\Tim\Exception\InvalidConfigException;
use Chenjiacheng\Tim\Service\AbstractService;
use Chenjiacheng\Tim\Support\Collection;
use Chenjiacheng\Tim\Tim;
use Chenjiacheng\Tim\Traits\MessageTrait;
use GuzzleHttp\Exception\GuzzleException;

class Account extends AbstractService implements MessageInterface
{
    use MessageTrait;

    /**
     * @var string
     */
    protected string $uri;

    /**
     * 消息接收方 UserID
     *
     * @var array|string
     */
    protected array|string $toAccount;

    /**
     * 消息发送方 UserID（用于指定发送消息方帐号）
     *
     * @var string
     */
    public string $fromAccount;

    /**
     * @param Tim $app
     * @param array|string|int $toAccount
     */
    public function __construct(Tim $app, array|string|int $toAccount)
    {
        parent::__construct($app);

        if (is_array($toAccount)) {
            $this->uri = 'v4/openim/batchsendmsg';
            $this->toAccount = array_map('strval', $toAccount);
        } else {
            $this->uri = 'v4/openim/sendmsg';
            $this->toAccount = (string)$toAccount;
        }
    }

    /**
     * @param string|int $fromAccount
     *
     * @return $this
     */
    public function setFromAccount(string|int $fromAccount): static
    {
        $this->fromAccount = (string)$fromAccount;
        return $this;
    }

    /**
     * @param MessageElemInterface $elem
     *
     * @return Collection
     *
     * @throws InvalidConfigException
     * @throws GuzzleException
     */
    public function sendMsg(MessageElemInterface $elem): Collection
    {
        $data = [
            'To_Account' => $this->toAccount,
            'MsgRandom'  => $this->getMsgRandom(),
            'MsgBody'    => [
                $elem->output()
            ]
        ];

        !empty($this->syncOtherMachine) && $data['SyncOtherMachine'] = $this->syncOtherMachine;
        !empty($this->syncFromOldSystem) && $data['SyncFromOldSystem'] = $this->syncFromOldSystem;
        !empty($this->fromAccount) && $data['From_Account'] = $this->fromAccount;
        !empty($this->msgLifeTime) && $data['MsgLifeTime'] = $this->msgLifeTime;
        !empty($this->msgSeq) && $data['MsgSeq'] = $this->msgSeq;
        !empty($this->forbidCallbackControl) && $data['ForbidCallbackControl'] = $this->forbidCallbackControl;
        !empty($this->sendMsgControl) && $data['SendMsgControl'] = $this->sendMsgControl;
        !empty($this->cloudCustomData) && $data['CloudCustomData'] = $this->cloudCustomData;
        !empty($this->offlinePushInfo) && $data['OfflinePushInfo'] = $this->offlinePushInfo;

        return $this->httpPostJson($this->uri, $data);
    }
}