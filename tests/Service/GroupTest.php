<?php

declare(strict_types=1);

namespace Chenjiacheng\Tim\Tests\Service;

use Chenjiacheng\Tim\Constant\GroupMemberRole;
use Chenjiacheng\Tim\Constant\GroupMsgFlag;
use Chenjiacheng\Tim\Constant\GroupMsgPriority;
use Chenjiacheng\Tim\Constant\GroupMuteAllMember;
use Chenjiacheng\Tim\Constant\GroupType;
use Chenjiacheng\Tim\Service\Group\GroupInfo;
use Chenjiacheng\Tim\Service\Group\GroupInfoResponseFilter;
use Chenjiacheng\Tim\Service\Group\GroupMemberItem;
use Chenjiacheng\Tim\Service\Group\GroupMemberList;
use Chenjiacheng\Tim\Service\Group\GroupMemberResponseFilter;
use Chenjiacheng\Tim\Service\Group\GroupMsgItem;
use Chenjiacheng\Tim\Service\Group\GroupMsgList;
use Chenjiacheng\Tim\Service\Group\TopicInfo;
use Chenjiacheng\Tim\Service\Message\OfflinePushInfo;
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

        $result = $tim->group->getAll();
        $this->assertSame('OK', $result['ActionStatus']);

        $result = $tim->group->getAll(100, 0, GroupType::CHAT_ROOM);
        $this->assertSame('OK', $result['ActionStatus']);
    }

    /**
     * @throws \Chenjiacheng\Tim\Exception\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testCreate()
    {
        $tim = new Tim($this->config);

        $result = $tim->group->create('group1');
        $this->assertSame('OK', $result['ActionStatus']);

        $result = $tim->group->create('group2', GroupType::PRIVATE);
        $this->assertSame('OK', $result['ActionStatus']);

        $result = $tim->group->create('group3', GroupType::CHAT_ROOM, '101');
        $this->assertSame('OK', $result['ActionStatus']);

        $result = $tim->group->create('group4', GroupType::COMMUNITY, 101, '@100001',
            [
                [
                    'Member_Account' => $this->config['identifier'],
                ],
                [
                    'Member_Account' => '101',
                ],
                [
                    'Member_Account' => '102',
                ],
                [
                    'Member_Account' => '103',
                ],
                [
                    'Member_Account' => '104',
                    /*'AppMemberDefinedData' => [
                        ['Key' => 'MemberDefined3', 'Value' => 'MemberData3'],
                        ['Key' => 'MemberDefined4', 'Value' => 'MemberData4'],
                    ]*/
                ]
            ], new GroupInfo('简介', '公告'));
        $this->assertSame('OK', $result['ActionStatus']);

        /*$result = $tim->group->create('group5', GroupType::AV_CHAT_ROOM, '101');
        $this->assertSame('OK', $result['ActionStatus']);

        $result = $tim->group->create('group6', GroupType::B_CHAT_ROOM, '101');
        $this->assertSame('OK', $result['ActionStatus']);

        $result = $tim->group->create('group7', GroupType::COMMUNITY, '101');
        $this->assertSame('OK', $result['ActionStatus']);*/
    }

    /**
     * @throws \Chenjiacheng\Tim\Exception\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testGet()
    {
        $tim = new Tim($this->config);

        $result = $tim->group->get(['@100001']);
        $this->assertSame('OK', $result['ActionStatus']);

        $result = $tim->group->get(['@100001'],
            new GroupInfoResponseFilter(
                [
                    'Type',
                    'Name',
                    'Introduction',
                    'Notification'
                ],
                [
                    'Account',
                    'Role',
                ],
            ));
        $this->assertSame('OK', $result['ActionStatus']);
    }

    /**
     * @throws \Chenjiacheng\Tim\Exception\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testGetMember()
    {
        $tim = new Tim($this->config);

        $result = $tim->group->getMember('@100001');
        $this->assertSame('OK', $result['ActionStatus']);

        $result = $tim->group->getMember('@100001', 200, 0, '',
            new GroupMemberResponseFilter(
                [
                    'Role',
                    'JoinTime',
                    'MsgSeq',
                    'MsgFlag',
                    'LastSendMsgTime',
                    'MuteUntil',
                    'NameCard'
                ],
                [
                    'Owner',
                    'Member'
                ],
                [
                    'MemberDefined1',
                    'MemberDefined2'
                ]
            ));
        $this->assertSame('OK', $result['ActionStatus']);
    }

    /**
     * @throws \Chenjiacheng\Tim\Exception\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testModify()
    {
        $tim = new Tim($this->config);

        $result = $tim->group->modify('@100001');
        $this->assertSame('OK', $result['ActionStatus']);

        $result = $tim->group->modify('@100001', 'group100001', GroupMuteAllMember::OFF, new GroupInfo('简介', '公告'));
        $this->assertSame('OK', $result['ActionStatus']);
    }

    /**
     * @throws \Chenjiacheng\Tim\Exception\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testAddMember()
    {
        $tim = new Tim($this->config);

        $result = $tim->group->addMember('@100001', ['103', 104]);
        $this->assertSame('OK', $result['ActionStatus']);

        $result = $tim->group->addMember('@100001', ['105', 106], true);
        $this->assertSame('OK', $result['ActionStatus']);
    }

    /**
     * @throws \Chenjiacheng\Tim\Exception\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testDeleteMember()
    {
        $tim = new Tim($this->config);

        $result = $tim->group->deleteMember('@100001', ['103', 104]);
        $this->assertSame('OK', $result['ActionStatus']);

        $result = $tim->group->deleteMember('@100001', ['105', 106], '违规删除', true);
        $this->assertSame('OK', $result['ActionStatus']);
    }

    /**
     * @throws \Chenjiacheng\Tim\Exception\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testModifyMember()
    {
        $tim = new Tim($this->config);

        $result = $tim->group->modifyMember('@100001', '101', GroupMemberRole::MEMBER);
        $this->assertSame('OK', $result['ActionStatus']);

        $result = $tim->group->modifyMember('@100001', '101',
            GroupMemberRole::MEMBER,
            GroupMsgFlag::ACCEPT_AND_NOTIFY,
            '群名片昵称',
            [
                "Key"   => "MemberDefined",
                "Value" => "ModifyData"
            ], 86400);
        $this->assertSame('OK', $result['ActionStatus']);
    }

    /**
     * @throws \Chenjiacheng\Tim\Exception\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testGetJoinedGroupList()
    {
        $tim = new Tim($this->config);

        $result = $tim->group->getJoinedGroupList('101');
        $this->assertSame('OK', $result['ActionStatus']);
    }

    /**
     * @throws \Chenjiacheng\Tim\Exception\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testGetRoleInGroup()
    {
        $tim = new Tim($this->config);

        $result = $tim->group->getRoleInGroup('@100001', ['101', 102]);
        $this->assertSame('OK', $result['ActionStatus']);

        $result = $tim->group->getRoleInGroup('@100001', '101');
        $this->assertSame('OK', $result['ActionStatus']);

        $result = $tim->group->getRoleInGroup('@100001', 102);
        $this->assertSame('OK', $result['ActionStatus']);
    }

    /**
     * @throws \Chenjiacheng\Tim\Exception\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testForbidSendMsg()
    {
        $tim = new Tim($this->config);

        $result = $tim->group->forbidSendMsg('@100001', ['101', 102], 86400);
        $this->assertSame('OK', $result['ActionStatus']);

        $result = $tim->group->forbidSendMsg('@100001', '101', 0);
        $this->assertSame('OK', $result['ActionStatus']);

        $result = $tim->group->forbidSendMsg('@100001', 102, 0);
        $this->assertSame('OK', $result['ActionStatus']);
    }

    /**
     * @throws \Chenjiacheng\Tim\Exception\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testGetMutedAccount()
    {
        $tim = new Tim($this->config);

        $result = $tim->group->getMutedAccount('@100001');
        $this->assertSame('OK', $result['ActionStatus']);
    }

    /**
     * @throws \Chenjiacheng\Tim\Exception\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testSendMsg()
    {
        $tim = new Tim($this->config);

        $result = $tim->group->setTIMTextElem('大家好啊')->sendMsg('@100001', '101', GroupMsgPriority::Normal, false);
        $this->assertSame('OK', $result['ActionStatus']);

        $result = $tim->group
            ->setTIMTextElem('大家好啊')
            ->setTIMLocationElem('深圳', 114.05, 22.55)
            ->setCloudCustomData('云端保存消息')
            ->beforeCallback(false)
            ->afterCallback(false)
            ->noUnread(true)
            ->noLastMsg(true)
            ->withMuteNotifications(true)
            ->setOfflinePushInfo(new OfflinePushInfo(0, '这是推送标题', '这是离线推送内容', '这是透传的内容'))
            ->sendMsg('@100001', '101', GroupMsgPriority::Normal, false);
        $this->assertSame('OK', $result['ActionStatus']);
    }

    /**
     * @throws \Chenjiacheng\Tim\Exception\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testSendSystemNotification()
    {
        $tim = new Tim($this->config);

        $result = $tim->group->sendSystemNotification('@100001', '系统通知');
        $this->assertSame('OK', $result['ActionStatus']);

        $result = $tim->group->sendSystemNotification('@100001', '系统通知', ['101', 102]);
        $this->assertSame('OK', $result['ActionStatus']);
    }

    /**
     * @throws \Chenjiacheng\Tim\Exception\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testChangeOwner()
    {
        $tim = new Tim($this->config);

        $result = $tim->group->changeOwner('@100001', '102');
        $this->assertSame('OK', $result['ActionStatus']);

        $result = $tim->group->changeOwner('@100001', 101);
        $this->assertSame('OK', $result['ActionStatus']);
    }

    /**
     * @throws \Chenjiacheng\Tim\Exception\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testGroupMsgRecall()
    {
        $tim = new Tim($this->config);

        $result = $tim->group->groupMsgRecall('@100001', ['xx']);
        $this->assertSame('OK', $result['ActionStatus']);

        $result = $tim->group->groupMsgRecall('@100001', 'xx');
        $this->assertSame('OK', $result['ActionStatus']);
    }

    /**
     * @throws \Chenjiacheng\Tim\Exception\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testImport()
    {
        $tim = new Tim($this->config);

        $result = $tim->group->import('group11');
        $this->assertSame('OK', $result['ActionStatus']);

        $result = $tim->group->import('group12', GroupType::PRIVATE);
        $this->assertSame('OK', $result['ActionStatus']);

        $result = $tim->group->import('group13', GroupType::CHAT_ROOM, '101');
        $this->assertSame('OK', $result['ActionStatus']);

        $result = $tim->group->import('group14', GroupType::CHAT_ROOM, 101, '@100002', time(), new GroupInfo('简介', '公告'));
        $this->assertSame('OK', $result['ActionStatus']);
    }

    /**
     * @throws \Chenjiacheng\Tim\Exception\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testImportMsg()
    {
        $tim = new Tim($this->config);

        $result = $tim->group->importMsg('@100001', new GroupMsgList(
            (new GroupMsgItem('101', time() - 86400))->setTIMTextElem('hello'),
            (new GroupMsgItem('101', time() - 86400))->setTIMLocationElem('深圳', 114.05, 22.55),
        ));
        $this->assertSame('OK', $result['ActionStatus']);
    }

    /**
     * @throws \Chenjiacheng\Tim\Exception\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testImportMember()
    {
        $tim = new Tim($this->config);

        $result = $tim->group->importMember('@100001', new GroupMemberList(
            (new GroupMemberItem('101')),
            (new GroupMemberItem('102', 'Admin', time(), 10)),
        ));
        $this->assertSame('OK', $result['ActionStatus']);
    }

    /**
     * @throws \Chenjiacheng\Tim\Exception\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testSetUnreadMsgNum()
    {
        $tim = new Tim($this->config);

        $result = $tim->group->setUnreadMsgNum('@100001', '101', 10);
        $this->assertSame('OK', $result['ActionStatus']);

        $result = $tim->group->setUnreadMsgNum('@100001', 102, 10);
        $this->assertSame('OK', $result['ActionStatus']);
    }

    /**
     * @throws \Chenjiacheng\Tim\Exception\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testDeleteMsgBySender()
    {
        $tim = new Tim($this->config);

        $result = $tim->group->deleteMsgBySender('@100001', '101');
        $this->assertSame('OK', $result['ActionStatus']);

        $result = $tim->group->deleteMsgBySender('@100001', 102);
        $this->assertSame('OK', $result['ActionStatus']);
    }

    /**
     * @throws \Chenjiacheng\Tim\Exception\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testGetHistory()
    {
        $tim = new Tim($this->config);

        $result = $tim->group->getHistory('@100001');
        $this->assertSame('OK', $result['ActionStatus']);

        $result = $tim->group->getHistory('@100001', 10);
        $this->assertSame('OK', $result['ActionStatus']);
    }

    /**
     * @throws \Chenjiacheng\Tim\Exception\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testGetOnlineMemberNum()
    {
        $tim = new Tim($this->config);

        $result = $tim->group->getOnlineMemberNum('@100001');
        $this->assertSame('OK', $result['ActionStatus']);
    }

    /**
     * @throws \Chenjiacheng\Tim\Exception\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testGetMembers()
    {
        $tim = new Tim($this->config);

        $result = $tim->group->getMembers('@100001');
        $this->assertSame('OK', $result['ActionStatus']);
    }

    /**
     * @throws \Chenjiacheng\Tim\Exception\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testGetAttr()
    {
        $tim = new Tim($this->config);

        $result = $tim->group->getAttr('@100001');
        $this->assertSame('OK', $result['ActionStatus']);
    }

    /**
     * @throws \Chenjiacheng\Tim\Exception\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testModifyAttr()
    {
        $tim = new Tim($this->config);

        $result = $tim->group->modifyAttr('@100001', [
            'attr_key1' => 'attr_val1',
            'attr_key2' => 'attr_val2',
        ]);
        $this->assertSame('OK', $result['ActionStatus']);
    }

    /**
     * @throws \Chenjiacheng\Tim\Exception\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testClearAttr()
    {
        $tim = new Tim($this->config);

        $result = $tim->group->clearAttr('@100001');
        $this->assertSame('OK', $result['ActionStatus']);
    }

    /**
     * @throws \Chenjiacheng\Tim\Exception\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testSetAttr()
    {
        $tim = new Tim($this->config);

        $result = $tim->group->setAttr('@100001', [
            'attr_key1' => 'attr_val1',
            'attr_key2' => 'attr_val2',
        ]);
        $this->assertSame('OK', $result['ActionStatus']);
    }

    /**
     * @throws \Chenjiacheng\Tim\Exception\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testModifyMsg()
    {
        $tim = new Tim($this->config);

        $result = $tim->group->setTIMTextElem('hello')->modifyMsg('@100001', 23);
        $this->assertSame('OK', $result['ActionStatus']);
    }

    /**
     * @throws \Chenjiacheng\Tim\Exception\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testGetGroupMsgReceiptDetail()
    {
        $tim = new Tim($this->config);

        $result = $tim->group->getGroupMsgReceiptDetail('@100001');
        $this->assertSame('OK', $result['ActionStatus']);
    }

    /**
     * @throws \Chenjiacheng\Tim\Exception\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testGetGroupMsgReceipt()
    {
        $tim = new Tim($this->config);

        $result = $tim->group->getGroupMsgReceipt('@100001', [1, 2, 3]);
        $this->assertSame('OK', $result['ActionStatus']);
    }

    /**
     * @throws \Chenjiacheng\Tim\Exception\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testSendBroadcastMsg()
    {
        $tim = new Tim($this->config);

        $result = $tim->group->setTIMTextElem('hello')->sendBroadcastMsg('101');
        $this->assertSame('OK', $result['ActionStatus']);
    }

    /**
     * @throws \Chenjiacheng\Tim\Exception\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testDestroy()
    {
        $tim = new Tim($this->config);

        $result = $tim->group->getJoinedGroupList('101');
        foreach ($result['GroupIdList'] as $item) {
            $result = $tim->group->destroy($item['GroupId']);
            $this->assertSame('OK', $result['ActionStatus']);
        }
    }

    /**
     * @throws \Chenjiacheng\Tim\Exception\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testCreateTopic()
    {
        $tim = new Tim($this->config);

        $result = $tim->group->createTopic('@100001', 'topic1');
        $this->assertSame('OK', $result['ActionStatus']);

        $result = $tim->group->createTopic('@100001', 'topic2',
            '@TGS#_@TGS#cQVLVHIM62CJ@TOPIC#_TestTopic',
            '101', 'This is a custom string',
            new TopicInfo('http://this.is.face.url',
                'This is topic Notification',
                'This is topic Introduction', [
                    'TopicTestData1' => 'xxxxx',
                    'TopicTestData2' => 'abc\u0000\u0001'
                ]));
        $this->assertSame('OK', $result['ActionStatus']);
    }

    /**
     * @throws \Chenjiacheng\Tim\Exception\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testDestroyTopic()
    {
        $tim = new Tim($this->config);

        $result = $tim->group->destroyTopic('@100001', ['aaa', 'bbb']);
        $this->assertSame('OK', $result['ActionStatus']);

        $result = $tim->group->destroyTopic('@100001', 'ccc');
        $this->assertSame('OK', $result['ActionStatus']);
    }

    /**
     * @throws \Chenjiacheng\Tim\Exception\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testGetTopic()
    {
        $tim = new Tim($this->config);

        $result = $tim->group->getTopic('@100001', '101');
        $this->assertSame('OK', $result['ActionStatus']);

        $result = $tim->group->getTopic('@100001', '101', ['aaa', 'bbb']);
        $this->assertSame('OK', $result['ActionStatus']);
    }

    /**
     * @throws \Chenjiacheng\Tim\Exception\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testModifyTopic()
    {
        $tim = new Tim($this->config);

        $result = $tim->group->modifyTopic('@100001', '@TGS#_@TGS#cQVLVHIM62CJ@TOPIC#_TestTopic', 'topicName');
        $this->assertSame('OK', $result['ActionStatus']);

        $result = $tim->group->modifyTopic('@100001', '@TGS#_@TGS#cQVLVHIM62CJ@TOPIC#_TestTopic', 'topicName',
            '101', 'This is a custom string', true,
            new TopicInfo('http://this.is.face.url',
                'This is topic Notification',
                'This is topic Introduction', [
                    'TopicTestData1' => 'xxxxx',
                    'TopicTestData2' => 'abc\u0000\u0001'
                ]));
        $this->assertSame('OK', $result['ActionStatus']);
    }
}
