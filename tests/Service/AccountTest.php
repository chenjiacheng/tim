<?php

declare(strict_types=1);

namespace Chenjiacheng\Tim\Tests\Service;

use Chenjiacheng\Tim\Tests\TimTest;
use Chenjiacheng\Tim\Tim;

class AccountTest extends TimTest
{
    /**
     * @throws \Chenjiacheng\Tim\Exception\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testImport()
    {
        $tim = new Tim($this->config);

        $result = $tim->account->import('101');
        $this->assertSame('OK', $result['ActionStatus']);

        $result = $tim->account->import(102, 'haha');
        $this->assertSame('OK', $result['ActionStatus']);
    }

    /**
     * @throws \Chenjiacheng\Tim\Exception\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testMultiImport()
    {
        $tim = new Tim($this->config);

        $result = $tim->account->multiImport(['103', '104']);
        $this->assertSame('OK', $result['ActionStatus']);

        $result = $tim->account->multiImport(['105', 106]);
        $this->assertSame('OK', $result['ActionStatus']);
    }

    /**
     * @throws \Chenjiacheng\Tim\Exception\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testDelete()
    {
        $tim = new Tim($this->config);

        $result = $tim->account->delete(['101', 102]);
        $this->assertSame('OK', $result['ActionStatus']);

        $result = $tim->account->delete('103');
        $this->assertSame('OK', $result['ActionStatus']);

        $result = $tim->account->delete(104);
        $this->assertSame('OK', $result['ActionStatus']);
    }

    /**
     * @throws \Chenjiacheng\Tim\Exception\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testCheck()
    {
        $tim = new Tim($this->config);

        $result = $tim->account->check(['105', '106']);
        $this->assertSame('OK', $result['ActionStatus']);

        $result = $tim->account->check(['105', 106]);
        $this->assertSame('OK', $result['ActionStatus']);

        $result = $tim->account->check([105, 106]);
        $this->assertSame('OK', $result['ActionStatus']);

        $result = $tim->account->check('105');
        $this->assertSame('OK', $result['ActionStatus']);

        $result = $tim->account->check(106);
        $this->assertSame('OK', $result['ActionStatus']);
    }

    /**
     * @throws \Chenjiacheng\Tim\Exception\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testKick()
    {
        $tim = new Tim($this->config);

        $result = $tim->account->kick('105');
        $this->assertSame('OK', $result['ActionStatus']);

        $result = $tim->account->kick(106);
        $this->assertSame('OK', $result['ActionStatus']);
    }

    /**
     * @throws \Chenjiacheng\Tim\Exception\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testQueryStatus()
    {
        $tim = new Tim($this->config);

        $result = $tim->account->queryStatus(['105', '106']);
        $this->assertSame('OK', $result['ActionStatus']);

        $result = $tim->account->queryStatus(['105', 106]);
        $this->assertSame('OK', $result['ActionStatus']);

        $result = $tim->account->queryStatus('105');
        $this->assertSame('OK', $result['ActionStatus']);

        $result = $tim->account->queryStatus(106);
        $this->assertSame('OK', $result['ActionStatus']);
    }
}
