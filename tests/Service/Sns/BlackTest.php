<?php

declare(strict_types=1);

namespace Chenjiacheng\Tim\Tests\Service\Sns;

use Chenjiacheng\Tim\Constant\BlackCheckType;
use Chenjiacheng\Tim\Tests\TimTest;
use Chenjiacheng\Tim\Tim;

class BlackTest extends TimTest
{
    /**
     * @throws \Chenjiacheng\Tim\Exception\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testAdd()
    {
        $tim = new Tim($this->config);

        $result = $tim->sns->black('101')->add(['103', 104]);
        $this->assertSame('OK', $result['ActionStatus']);

        $result = $tim->sns->black('101')->add('105');
        $this->assertSame('OK', $result['ActionStatus']);

        $result = $tim->sns->black('101')->add(106);
        $this->assertSame('OK', $result['ActionStatus']);

        $result = $tim->sns->black(102)->add(['103', 104]);
        $this->assertSame('OK', $result['ActionStatus']);

        $result = $tim->sns->black(102)->add('105');
        $this->assertSame('OK', $result['ActionStatus']);

        $result = $tim->sns->black(102)->add(106);
        $this->assertSame('OK', $result['ActionStatus']);
    }

    /**
     * @throws \Chenjiacheng\Tim\Exception\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testGet()
    {
        $tim = new Tim($this->config);

        $result = $tim->sns->black('101')->get();
        $this->assertSame('OK', $result['ActionStatus']);

        // 第1页
        $result = $tim->sns->black(102)->get(0, 2);
        $this->assertSame('OK', $result['ActionStatus']);

        // 第2页
        $result = $tim->sns->black(102)->get(2, 2, $result['CurruentSequence']);
        $this->assertSame('OK', $result['ActionStatus']);

        // 第3页
        $result = $tim->sns->black(102)->get(4, 2, $result['CurruentSequence']);
        $this->assertSame('OK', $result['ActionStatus']);
    }

    /**
     * @throws \Chenjiacheng\Tim\Exception\InvalidArgumentException
     * @throws \Chenjiacheng\Tim\Exception\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testCheck()
    {
        $tim = new Tim($this->config);

        $result = $tim->sns->black('101')->check(['103', 104]);
        $this->assertSame('OK', $result['ActionStatus']);

        $result = $tim->sns->black('101')->check('105', BlackCheckType::BOTH);
        $this->assertSame('OK', $result['ActionStatus']);

        $result = $tim->sns->black('101')->check(106);
        $this->assertSame('OK', $result['ActionStatus']);

        $result = $tim->sns->black(102)->check(['103', 104], BlackCheckType::BOTH);
        $this->assertSame('OK', $result['ActionStatus']);

        $result = $tim->sns->black(102)->check('105');
        $this->assertSame('OK', $result['ActionStatus']);

        $result = $tim->sns->black(102)->check(106, BlackCheckType::BOTH);
        $this->assertSame('OK', $result['ActionStatus']);
    }

    /**
     * @throws \Chenjiacheng\Tim\Exception\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testDelete()
    {
        $tim = new Tim($this->config);

        $result = $tim->sns->black('101')->delete(['103', 104]);
        $this->assertSame('OK', $result['ActionStatus']);

        $result = $tim->sns->black('101')->delete('105');
        $this->assertSame('OK', $result['ActionStatus']);

        $result = $tim->sns->black('101')->delete(106);
        $this->assertSame('OK', $result['ActionStatus']);

        $result = $tim->sns->black(102)->delete(['103', 104]);
        $this->assertSame('OK', $result['ActionStatus']);

        $result = $tim->sns->black(102)->delete('105');
        $this->assertSame('OK', $result['ActionStatus']);

        $result = $tim->sns->black(102)->delete(106);
        $this->assertSame('OK', $result['ActionStatus']);
    }
}
