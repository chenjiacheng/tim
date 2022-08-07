<?php

declare(strict_types=1);

namespace Chenjiacheng\Tim\Tests\Service;

use Chenjiacheng\Tim\Constant\ChatType;
use Chenjiacheng\Tim\Constant\OperateField;
use Chenjiacheng\Tim\Tests\TimTest;
use Chenjiacheng\Tim\Tim;

class OperateTest extends TimTest
{
    /**
     * @throws \Chenjiacheng\Tim\Exception\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testGetAppInfo()
    {
        $tim = new Tim($this->config);

        $result = $tim->operate->getAppInfo();
        $this->assertSame('OK', $result['ErrorInfo']);

        $result = $tim->operate->getAppInfo([
            OperateField::APP_NAME,
            OperateField::APP_ID,
            OperateField::COMPANY,
            OperateField::ACTIVE_USER_NUM,
            OperateField::REGIST_USER_NUM_ONE_DAY,
            OperateField::REGIST_USER_NUM_TOTAL,
            OperateField::LOGIN_TIMES,
            OperateField::LOGIN_USER_NUM,
            OperateField::UP_MSG_NUM,
            OperateField::SEND_MSG_USER_NUM,
            OperateField::APNS_MSG_NUM,
            OperateField::C2C_UP_MSG_NUM,
            OperateField::C2C_DOWN_MSG_NUM,
            OperateField::C2C_SEND_MSG_USER_NUM,
            OperateField::C2C_APNS_MSG_NUM,
            OperateField::MAX_ONLINE_NUM,
            OperateField::DOWN_MSG_NUM,
            OperateField::CHAIN_INCREASE,
            OperateField::CHAIN_DECREASE,
            OperateField::GROUP_UP_MSG_NUM,
            OperateField::GROUP_DOWN_MSG_NUM,
            OperateField::GROUP_SEND_MSG_USER_NUM,
            OperateField::GROUP_APNS_MSG_NUM,
            OperateField::GROUP_SEND_MSG_GROUP_NUM,
            OperateField::GROUP_JOIN_GROUP_TIMES,
            OperateField::GROUP_QUIT_GROUP_TIMES,
            OperateField::GROUP_NEW_GROUP_NUM,
            OperateField::GROUP_ALL_GROUP_NUM,
            OperateField::GROUP_DESTROY_GROUP_NUM,
            OperateField::CALL_BACK_REQ,
            OperateField::CALL_BACK_RSP,
            OperateField::DATE,
        ]);
        $this->assertSame('OK', $result['ErrorInfo']);
    }

    /**
     * @throws \Chenjiacheng\Tim\Exception\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testGetHistory()
    {
        $tim = new Tim($this->config);

        $result = $tim->operate->getHistory(date('YmdH', time() - 86400));
        $this->assertSame('OK', $result['ActionStatus']);

        $result = $tim->operate->getHistory(date('YmdH', time() - 86400), ChatType::GROUP);
        $this->assertSame('OK', $result['ActionStatus']);
    }

    /**
     * @throws \Chenjiacheng\Tim\Exception\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testGetIPList()
    {
        $tim = new Tim($this->config);

        $result = $tim->operate->getIPList();
        $this->assertSame('OK', $result['ActionStatus']);
    }
}
