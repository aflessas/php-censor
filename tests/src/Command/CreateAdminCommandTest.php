<?php

declare(strict_types=1);

namespace Tests\PHPCensor\Command;

use PHPCensor\Command\CreateAdminCommand;
use PHPUnit\Framework\TestCase;
use PHPUnit_Framework_MockObject_MockObject;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Tester\CommandTester;

class CreateAdminCommandTest extends TestCase
{
    /**
     * @var CreateAdminCommand|PHPUnit_Framework_MockObject_MockObject
     */
    protected $command;

    /**
     * @var Application|PHPUnit_Framework_MockObject_MockObject
     */
    protected $application;

    /**
     * @var QuestionHelper|PHPUnit_Framework_MockObject_MockObject
     */
    protected $helper;

    public function setUp()
    {
        parent::setUp();

        $userStoreMock = $this->getMockBuilder('PHPCensor\\Store\\UserStore')->getMock();

        $this->command = new CreateAdminCommand($userStoreMock);

        $this->helper = $this
            ->getMockBuilder('Symfony\\Component\\Console\\Helper\\QuestionHelper')
            ->setMethods(['ask'])
            ->getMock();

        $this->application = new Application();
    }

    /**
     * @return CommandTester
     */
    protected function getCommandTester()
    {
        $this->application->getHelperSet()->set($this->helper, 'question');
        $this->application->add($this->command);
        $commandTester = new CommandTester($this->command);

        return $commandTester;
    }

    public function testExecute()
    {
        $this->helper->expects($this->at(0))->method('ask')->will($this->returnValue('test@example.com'));
        $this->helper->expects($this->at(1))->method('ask')->will($this->returnValue('A name'));
        $this->helper->expects($this->at(2))->method('ask')->will($this->returnValue('foobar123'));

        $commandTester = $this->getCommandTester();
        $commandTester->execute([]);

        self::assertEquals('User account created!' . PHP_EOL, $commandTester->getDisplay());
    }
}
