<?php

declare(strict_types=1);

namespace Chenjiacheng\Tim\Tests\Service\Message;

use Chenjiacheng\Tim\Tests\Service\MessageTest;
use Chenjiacheng\Tim\Tim;

class AccountTest extends MessageTest
{
    public function testSendText()
    {
        $tim = new Tim($this->config);

        $result = $tim->message->toAccount('105')->sendText('haha');
        $this->assertSame('OK', $result['ActionStatus']);

        $result = $tim->message->toAccount(106)->sendLocation('深圳', 114.05, 22.55);
        $this->assertSame('OK', $result['ActionStatus']);

        $result = $tim->message->toAccount(['105', 106])->sendFace(1, 'haha');
        $this->assertSame('OK', $result['ActionStatus']);

        $result = $tim->message->toAccount('105')
            ->syncOtherMachine(false)
            ->beforeCallback(false)
            ->afterCallback(false)
            ->noUnread(true)
            ->noLastMsg(true)
            ->withMuteNotifications(true)
            ->setCloudCustomData('abc')
            ->sendText('haha');
        $this->assertSame('OK', $result['ActionStatus']);
    }
}
