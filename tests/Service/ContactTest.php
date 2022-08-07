<?php

declare(strict_types=1);

namespace Chenjiacheng\Tim\Tests\Service;

use Chenjiacheng\Tim\Tests\TimTest;
use Chenjiacheng\Tim\Tim;

class ContactTest extends TimTest
{
    /**
     * @throws \Chenjiacheng\Tim\Exception\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testGetList()
    {
        $tim = new Tim($this->config);

        $result = $tim->contact->getList('101');
        $this->assertSame('OK', $result['ActionStatus']);
    }

    /**
     * @throws \Chenjiacheng\Tim\Exception\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testDeleteC2C()
    {
        $tim = new Tim($this->config);

        $result = $tim->contact->deleteC2C('101', '102');
        $this->assertSame('OK', $result['ActionStatus']);
    }

    /**
     * @throws \Chenjiacheng\Tim\Exception\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testDeleteG2C()
    {
        $tim = new Tim($this->config);

        $result = $tim->contact->deleteG2C('101', '@#123456');
        $this->assertSame('OK', $result['ActionStatus']);
    }
}
