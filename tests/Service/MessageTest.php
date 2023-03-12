<?php

declare(strict_types=1);

namespace Chenjiacheng\Tim\Tests\Service;

use Chenjiacheng\Tim\Service\Message\OfflinePushInfo;
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

        $result = $tim->message->setTIMTextElem('你好')->sendMsg('101');
        $this->assertSame('OK', $result['ActionStatus']);

        $result = $tim->message
            ->setTIMTextElem('在吗')
            ->setTIMLocationElem('深圳', 114.05, 22.55)
            ->setCloudCustomData('云端保存消息')
            ->beforeCallback(false)
            ->afterCallback(false)
            ->noUnread(true)
            ->noLastMsg(true)
            ->withMuteNotifications(true)
            ->setOfflinePushInfo(new OfflinePushInfo(0, '这是推送标题', '这是离线推送内容', '这是透传的内容'))
            ->sendMsg(101, '102', false, 86400);
        $this->assertSame('OK', $result['ActionStatus']);
    }

    /**
     * @throws \Chenjiacheng\Tim\Exception\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testBatchSendMsg()
    {
        $tim = new Tim($this->config);

        $result = $tim->message->setTIMTextElem('你好')->batchSendMsg(['101', '102']);
        $this->assertSame('OK', $result['ActionStatus']);

        $result = $tim->message
            ->setTIMTextElem('在吗')
            ->setTIMLocationElem('深圳', 114.05, 22.55)
            ->setCloudCustomData('云端保存消息')
            ->noUnread(true)
            ->noLastMsg(true)
            ->withMuteNotifications(true)
            ->setOfflinePushInfo(new OfflinePushInfo(0, '这是推送标题', '这是离线推送内容', '这是透传的内容'))
            ->batchSendMsg(['101', 103], '102', false, 86400);
        $this->assertSame('OK', $result['ActionStatus']);
    }

    /**
     * @throws \Chenjiacheng\Tim\Exception\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testImportMsg()
    {
        $tim = new Tim($this->config);

        $result = $tim->message->setTIMTextElem('你好')->importMsg('101', '102');
        $this->assertSame('OK', $result['ActionStatus']);

        $result = $tim->message
            ->setTIMTextElem('在吗')
            ->setTIMLocationElem('深圳', 114.05, 22.55)
            ->setCloudCustomData('云端保存消息')
            ->noUnread(true)
            ->noLastMsg(true)
            ->withMuteNotifications(true)
            ->setOfflinePushInfo(new OfflinePushInfo(0, '这是推送标题', '这是离线推送内容', '这是透传的内容'))
            ->importMsg('101', 102, time(), false);
        $this->assertSame('OK', $result['ActionStatus']);
    }

    /**
     * @throws \Chenjiacheng\Tim\Exception\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testGetRoamMsg()
    {
        $tim = new Tim($this->config);

        $result = $tim->message->getRoamMsg('101', 102, 100, time() - 86400, time());
        $this->assertSame('OK', $result['ActionStatus']);
    }

    /**
     * @throws \Chenjiacheng\Tim\Exception\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testWithdraw()
    {
        $tim = new Tim($this->config);

        $result = $tim->message->getRoamMsg('101', 102, 100, time() - 86400, time());
        $this->assertSame('OK', $result['ActionStatus']);

        $result = $tim->message->msgWithdraw('101', 102, $result['LastMsgKey']);
        $this->assertSame('OK', $result['ActionStatus']);
    }

    /**
     * @throws \Chenjiacheng\Tim\Exception\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testSetMsgRead()
    {
        $tim = new Tim($this->config);

        $result = $tim->message->setMsgRead('101', 102);
        $this->assertSame('OK', $result['ActionStatus']);
    }

    /**
     * @throws \Chenjiacheng\Tim\Exception\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testGetUnreadMsgNum()
    {
        $tim = new Tim($this->config);

        $result = $tim->message->getUnreadMsgNum('101', [102, '103']);
        $this->assertSame('OK', $result['ActionStatus']);

        $result = $tim->message->getUnreadMsgNum('101', 102);
        $this->assertSame('OK', $result['ActionStatus']);
    }

    /**
     * @throws \Chenjiacheng\Tim\Exception\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testModifyMsg()
    {
        $tim = new Tim($this->config);

        $result = $tim->message->getRoamMsg(101, '102', 100, time() - 86400, time());
        $this->assertSame('OK', $result['ActionStatus']);

        $result = $tim->message
            ->setTIMTextElem('哈哈')
            ->setCloudCustomData('云端保存消息')
            ->modifyMsg('101', 102, $result['LastMsgKey']);
        $this->assertSame('OK', $result['ActionStatus']);
    }
}
