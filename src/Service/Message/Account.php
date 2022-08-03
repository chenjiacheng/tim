<?php

declare(strict_types=1);

namespace Chenjiacheng\Tim\Service\Message;

use Chenjiacheng\Tim\Contract\MessageElemInterface;
use Chenjiacheng\Tim\Contract\MessageInterface;
use Chenjiacheng\Tim\Service\AbstractService;
use Chenjiacheng\Tim\Support\Arr;
use Chenjiacheng\Tim\Support\Collection;
use Chenjiacheng\Tim\Tim;
use Chenjiacheng\Tim\Traits\MessageTrait;

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
     * Account constructor.
     * @param \Chenjiacheng\Tim\Tim $app
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
        $this->fromAccount = $fromAccount;
        return $this;
    }

    /**
     * @param \Chenjiacheng\Tim\Contract\MessageElemInterface $elem
     * @return \Chenjiacheng\Tim\Support\Collection
     * @throws \Chenjiacheng\Tim\Exception\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function sendMsg(MessageElemInterface $elem): Collection
    {
        $data = [
            'SyncOtherMachine' => $this->syncOtherMachine,
            'To_Account'       => $this->toAccount,
            'MsgLifeTime'      => $this->msgLifeTime,
            'MsgSeq'           => $this->getMsgSeq(),
            'MsgRandom'        => $this->getMsgRandom(),
            'MsgBody'          => [
                $elem->output()
            ]
        ];

        if (!empty($this->fromAccount)) {
            $data['From_Account'] = $this->fromAccount;
        }

        if (!empty($this->forbidCallbackControl)) {
            $data['ForbidCallbackControl'] = $this->forbidCallbackControl;
        }

        if (!empty($this->sendMsgControl)) {
            $data['SendMsgControl'] = $this->sendMsgControl;
        }

        if (!empty($this->cloudCustomData)) {
            $data['CloudCustomData'] = $this->cloudCustomData;
        }

        if (!empty($this->offlinePushInfo)) {
            $data['OfflinePushInfo'] = $this->offlinePushInfo;
        }

        return $this->httpPostJson($this->uri, $data);
    }
}