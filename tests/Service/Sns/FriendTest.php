<?php

declare(strict_types=1);

namespace Chenjiacheng\Tim\Tests\Service\Sns;

use Chenjiacheng\Tim\Constant\FriendTag;
use Chenjiacheng\Tim\Constant\ProfileTag;
use Chenjiacheng\Tim\Tests\TimTest;
use Chenjiacheng\Tim\Tim;

class FriendTest extends TimTest
{
    /**
     * @throws \Chenjiacheng\Tim\Exception\InvalidArgumentException
     * @throws \Chenjiacheng\Tim\Exception\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testAdd()
    {
        $tim = new Tim($this->config);

        $result = $tim->sns->friend('101')->add([
            [
                'To_Account' => '102',
            ],
            [
                'To_Account' => '103',
                'Remark'     => 'remark1',
                'GroupName'  => '同学',
                'AddSource'  => 'AddSource_Type_XXXXXXXX',
                'AddWording' => 'Im Test1'
            ],
        ]);
        $this->assertSame('OK', $result['ActionStatus']);
    }

    /**
     * @throws \Chenjiacheng\Tim\Exception\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testImport()
    {
        $tim = new Tim($this->config);

        $result = $tim->sns->friend('101')->import([
            [
                'To_Account' => '104',
                'AddSource'  => 'AddSource_Type_XXXXXXXX',
            ],
            [
                'To_Account' => '105',
                'Remark'     => 'remark1',
                'RemarkTime' => time(),
                'GroupName'  => ['同学'],
                'AddSource'  => 'AddSource_Type_XXXXXXXX',
                'AddWording' => 'Im Test1',
                'AddTime'    => time(),
                /*'CustomItem' => [
                    ['Tag' => 'Tag_SNS_Custom_XXXX', 'Value' => 'Test'],
                    ['Tag' => 'Tag_SNS_Custom_YYYY', 'Value' => 0],
                ]*/
            ],
        ]);
        $this->assertSame('OK', $result['ActionStatus']);
    }

    /**
     * @throws \Chenjiacheng\Tim\Exception\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testUpdate()
    {
        $tim = new Tim($this->config);

        $result = $tim->sns->friend('101')->update([
            [
                'To_Account' => '102',
                'SnsItem'    => [
                    ['Tag' => FriendTag::GROUP, 'Value' => 'Test'],
                    ['Tag' => FriendTag::REMARK, 'Value' => 'Test'],
                ]
            ],
            [
                'To_Account' => '103',
                'SnsItem'    => [
                    ['Tag' => FriendTag::GROUP, 'Value' => ['Test']],
                    ['Tag' => FriendTag::REMARK, 'Value' => 'Test'],
                ]
            ],
        ]);
        $this->assertSame('OK', $result['ActionStatus']);
    }

    /**
     * @throws \Chenjiacheng\Tim\Exception\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testCheck()
    {
        $tim = new Tim($this->config);

        $result = $tim->sns->friend('101')->check(['102', 103]);
        $this->assertSame('OK', $result['ActionStatus']);

        $result = $tim->sns->friend('101')->check('104');
        $this->assertSame('OK', $result['ActionStatus']);

        $result = $tim->sns->friend('101')->check(105);
        $this->assertSame('OK', $result['ActionStatus']);
    }

    /**
     * @throws \Chenjiacheng\Tim\Exception\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testGet()
    {
        $tim = new Tim($this->config);

        $result = $tim->sns->friend('101')->get();
        $this->assertSame('OK', $result['ActionStatus']);
    }

    /**
     * @throws \Chenjiacheng\Tim\Exception\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testGetList()
    {
        $tim = new Tim($this->config);

        $result = $tim->sns->friend('101')->getList(['102', 103], [
            ProfileTag::NICK,
            ProfileTag::GENDER,
            ProfileTag::BIRTHDAY,
            ProfileTag::LOCATION,
            ProfileTag::SIGNATURE,
            ProfileTag::ALLOW_TYPE,
            ProfileTag::LANGUAGE,
            ProfileTag::IMAGE,
            ProfileTag::ADMIN_FORBID_TYPE,
            ProfileTag::LEVEL,
            ProfileTag::ROLE,
        ]);
        $this->assertSame('OK', $result['ActionStatus']);

        $result = $tim->sns->friend('101')->getList('104', [
            ProfileTag::NICK,
            ProfileTag::GENDER,
            ProfileTag::BIRTHDAY,
            ProfileTag::LOCATION,
            ProfileTag::SIGNATURE,
        ]);
        $this->assertSame('OK', $result['ActionStatus']);

        $result = $tim->sns->friend('101')->getList(105, [
            ProfileTag::ALLOW_TYPE,
            ProfileTag::LANGUAGE,
            ProfileTag::IMAGE,
            ProfileTag::ADMIN_FORBID_TYPE,
            ProfileTag::LEVEL,
            ProfileTag::ROLE,
        ]);
        $this->assertSame('OK', $result['ActionStatus']);
    }

    /**
     * @throws \Chenjiacheng\Tim\Exception\InvalidArgumentException
     * @throws \Chenjiacheng\Tim\Exception\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testDelete()
    {
        $tim = new Tim($this->config);

        $result = $tim->sns->friend('101')->delete(['102', 103]);
        $this->assertSame('OK', $result['ActionStatus']);

        $result = $tim->sns->friend('101')->delete('104');
        $this->assertSame('OK', $result['ActionStatus']);

        $result = $tim->sns->friend('101')->delete(105);
        $this->assertSame('OK', $result['ActionStatus']);
    }

    /**
     * @throws \Chenjiacheng\Tim\Exception\InvalidArgumentException
     * @throws \Chenjiacheng\Tim\Exception\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testDeleteAll()
    {
        $tim = new Tim($this->config);

        $result = $tim->sns->friend('101')->deleteAll();
        $this->assertSame('OK', $result['ActionStatus']);
    }
}
