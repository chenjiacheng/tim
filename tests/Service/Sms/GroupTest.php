<?php

declare(strict_types=1);

namespace Chenjiacheng\Tim\Tests\Service\Sms;

use Chenjiacheng\Tim\Tests\TimTest;
use Chenjiacheng\Tim\Tim;

class GroupTest extends TimTest
{
    /**
     * @throws \Chenjiacheng\Tim\Exception\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testAdd()
    {
        $tim = new Tim($this->config);

        $result = $tim->sms->group('101')->add(['group1', 'group2']);
        $this->assertSame('OK', $result['ActionStatus']);

        $result = $tim->sms->group('101')->add('group3');
        $this->assertSame('OK', $result['ActionStatus']);
    }

    /**
     * @throws \Chenjiacheng\Tim\Exception\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testGet()
    {
        $tim = new Tim($this->config);

        $result = $tim->sms->group('101')->get();
        $this->assertSame('OK', $result['ActionStatus']);

        $result = $tim->sms->group('101')->get(['group1', 'group2']);
        $this->assertSame('OK', $result['ActionStatus']);

        $result = $tim->sms->group('101')->get('group3', true);
        $this->assertSame('OK', $result['ActionStatus']);
    }

    /**
     * @throws \Chenjiacheng\Tim\Exception\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testDelete()
    {
        $tim = new Tim($this->config);

        $result = $tim->sms->group('101')->delete(['group1', 'group2']);
        $this->assertSame('OK', $result['ActionStatus']);

        $result = $tim->sms->group('101')->delete('group3');
        $this->assertSame('OK', $result['ActionStatus']);
    }
}
