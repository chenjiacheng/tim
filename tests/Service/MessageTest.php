<?php

declare(strict_types=1);

namespace Chenjiacheng\Tim\Tests\Service;

use Chenjiacheng\Tim\Tests\TimTest;
use Chenjiacheng\Tim\Tim;

class MessageTest extends TimTest
{
    /**
     * @throws \Chenjiacheng\Tim\Exception\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testSendMsg()
    {
        $tim = new Tim($this->config);

        $result = $tim->message->setTIMTextElem('haha')->sendMsg('105');
        $this->assertSame('OK', $result['ActionStatus']);

        $result = $tim->message->setTIMTextElem('haha')
            ->setTIMLocationElem('深圳', 114.05, 22.55)->sendMsg(106);
        $this->assertSame('OK', $result['ActionStatus']);

        $result = $tim->message->setTIMTextElem('haha')
            ->setTIMLocationElem('深圳', 114.05, 22.55)
            ->setTIMFaceElem(1, 'haha')
            ->beforeCallback(false)
            ->afterCallback(false)
            ->noUnread(true)
            ->noLastMsg(true)
            ->withMuteNotifications(true)
            ->sendMsg(106, '105', 2, time() - 86400);
        $this->assertSame('OK', $result['ActionStatus']);
    }

    /**
     * @throws \Chenjiacheng\Tim\Exception\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testBatchSendMsg()
    {
        $tim = new Tim($this->config);

        $result = $tim->message->setTIMTextElem('haha')->batchSendMsg(['105', '106']);
        $this->assertSame('OK', $result['ActionStatus']);

        $result = $tim->message->setTIMTextElem('haha')
            ->setTIMLocationElem('深圳', 114.05, 22.55)->batchSendMsg(['105', 106]);
        $this->assertSame('OK', $result['ActionStatus']);

        $result = $tim->message->setTIMTextElem('haha')
            ->setTIMLocationElem('深圳', 114.05, 22.55)
            ->setTIMFaceElem(1, 'haha')
            ->noUnread(true)
            ->noLastMsg(true)
            ->withMuteNotifications(true)
            ->batchSendMsg([106], '105', 2, time() - 86400);
        $this->assertSame('OK', $result['ActionStatus']);
    }

    /**
     * @throws \Chenjiacheng\Tim\Exception\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testImportMsg()
    {
        $tim = new Tim($this->config);

        $result = $tim->message->setTIMTextElem('haha')->importMsg('105', 106);
        $this->assertSame('OK', $result['ActionStatus']);

        $result = $tim->message->setTIMTextElem('haha')
            ->setTIMLocationElem('深圳', 114.05, 22.55)->importMsg(106, 105);
        $this->assertSame('OK', $result['ActionStatus']);

        $result = $tim->message->setTIMTextElem('haha')
            ->setTIMLocationElem('深圳', 114.05, 22.55)
            ->setTIMFaceElem(1, 'haha')
            ->beforeCallback(false)
            ->afterCallback(false)
            ->noUnread(true)
            ->noLastMsg(true)
            ->withMuteNotifications(true)
            ->importMsg(106, '105', time() - 86400, 2);
        $this->assertSame('OK', $result['ActionStatus']);
    }

    /**
     * @throws \Chenjiacheng\Tim\Exception\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testGetRoamMsg()
    {
        $tim = new Tim($this->config);

        $result = $tim->message->getRoamMsg('105', 106, 100, time() - 86400, time());
        $this->assertSame('OK', $result['ActionStatus']);
    }

    /**
     * @throws \Chenjiacheng\Tim\Exception\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testWithdraw()
    {
        $tim = new Tim($this->config);

        $result = $tim->message->getRoamMsg(106, '105', 100, time() - 86400, time());
        $this->assertSame('OK', $result['ActionStatus']);

        $result = $tim->message->msgWithdraw('105', 106, $result['LastMsgKey']);
        $this->assertSame('OK', $result['ActionStatus']);
    }

    /**
     * @throws \Chenjiacheng\Tim\Exception\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testSetMsgRead()
    {
        $tim = new Tim($this->config);

        $result = $tim->message->setMsgRead('105', 106);
        $this->assertSame('OK', $result['ActionStatus']);
    }

    /**
     * @throws \Chenjiacheng\Tim\Exception\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testGetUnreadMsgNum()
    {
        $tim = new Tim($this->config);

        $result = $tim->message->getUnreadMsgNum('105', 106);
        $this->assertSame('OK', $result['ActionStatus']);
    }

    /**
     * @throws \Chenjiacheng\Tim\Exception\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testModifyMsg()
    {
        $tim = new Tim($this->config);

        $result = $tim->message->getRoamMsg(106, '105', 100, time() - 86400, time());
        $this->assertSame('OK', $result['ActionStatus']);

        $result = $tim->message->setCloudCustomData('haha')->modifyMsg('105', 106, $result['LastMsgKey']);
        $this->assertSame('OK', $result['ActionStatus']);
    }
}
