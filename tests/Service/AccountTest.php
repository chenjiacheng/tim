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

        $result = $tim->account->import('102', 'user102');
        $this->assertSame('OK', $result['ActionStatus']);

        $result = $tim->account->import('103', 'user103', 'https://avatars.githubusercontent.com/u/15870542');
        $this->assertSame('OK', $result['ActionStatus']);

        $result = $tim->account->import(104);
        $this->assertSame('OK', $result['ActionStatus']);

        $result = $tim->account->import(105, 'user105');
        $this->assertSame('OK', $result['ActionStatus']);

        $result = $tim->account->import(106, 'user106', 'https://avatars.githubusercontent.com/u/15870542');
        $this->assertSame('OK', $result['ActionStatus']);
    }

    /**
     * @throws \Chenjiacheng\Tim\Exception\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testMultiImport()
    {
        $tim = new Tim($this->config);

        $result = $tim->account->multiImport(['107', '108']);
        $this->assertSame('OK', $result['ActionStatus']);

        $result = $tim->account->multiImport(['109', 110]);
        $this->assertSame('OK', $result['ActionStatus']);

        $result = $tim->account->multiImport([111, 112]);
        $this->assertSame('OK', $result['ActionStatus']);
    }

    /**
     * @throws \Chenjiacheng\Tim\Exception\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testDelete()
    {
        $tim = new Tim($this->config);

        $result = $tim->account->delete(['107', '108']);
        $this->assertSame('OK', $result['ActionStatus']);

        $result = $tim->account->delete(['109', 110]);
        $this->assertSame('OK', $result['ActionStatus']);

        $result = $tim->account->delete('111');
        $this->assertSame('OK', $result['ActionStatus']);

        $result = $tim->account->delete(112);
        $this->assertSame('OK', $result['ActionStatus']);
    }

    /**
     * @throws \Chenjiacheng\Tim\Exception\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testCheck()
    {
        $tim = new Tim($this->config);

        $result = $tim->account->check(['101', '102']);
        $this->assertSame('OK', $result['ActionStatus']);

        $result = $tim->account->check(['101', 102]);
        $this->assertSame('OK', $result['ActionStatus']);

        $result = $tim->account->check([101, 102]);
        $this->assertSame('OK', $result['ActionStatus']);

        $result = $tim->account->check('101');
        $this->assertSame('OK', $result['ActionStatus']);

        $result = $tim->account->check(102);
        $this->assertSame('OK', $result['ActionStatus']);
    }

    /**
     * @throws \Chenjiacheng\Tim\Exception\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testKick()
    {
        $tim = new Tim($this->config);

        $result = $tim->account->kick('101');
        $this->assertSame('OK', $result['ActionStatus']);

        $result = $tim->account->kick(102);
        $this->assertSame('OK', $result['ActionStatus']);
    }

    /**
     * @throws \Chenjiacheng\Tim\Exception\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testQueryStatus()
    {
        $tim = new Tim($this->config);

        $result = $tim->account->queryStatus(['101', '102']);
        $this->assertSame('OK', $result['ActionStatus']);

        $result = $tim->account->queryStatus(['101', 102], true);
        $this->assertSame('OK', $result['ActionStatus']);

        $result = $tim->account->queryStatus([101, 102]);
        $this->assertSame('OK', $result['ActionStatus']);

        $result = $tim->account->queryStatus('101', true);
        $this->assertSame('OK', $result['ActionStatus']);

        $result = $tim->account->queryStatus(102);
        $this->assertSame('OK', $result['ActionStatus']);
    }
}
