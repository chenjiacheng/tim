<?php

declare(strict_types=1);

namespace Chenjiacheng\Tim\Tests\Service;

use Chenjiacheng\Tim\Constant\GroupType;
use Chenjiacheng\Tim\Service\Group\GroupInfo;
use Chenjiacheng\Tim\Tests\TimTest;
use Chenjiacheng\Tim\Tim;

class GroupTest extends TimTest
{
    /**
     * @throws \Chenjiacheng\Tim\Exception\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testGetAll()
    {
        $tim = new Tim($this->config);

        $result = $tim->group->getAll(1, 2, GroupType::CHAT_ROOM);
        $this->assertSame('OK', $result['ActionStatus']);
    }

    public function testCreate()
    {
        $tim = new Tim($this->config);

        $groupInfo = new GroupInfo();
        $groupInfo->setFaceUrl('1');
    }
}
