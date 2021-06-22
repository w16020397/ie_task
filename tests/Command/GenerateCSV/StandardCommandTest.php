<?php

namespace App\Tests\Command;

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Tester\CommandTester;

class StandarCommandTest extends KernelTestCase
{
    protected function setUp(): void
    {
        $kernel = static::createKernel();

        $this->application = new Application($kernel);
    }

    public function testCommand()
    {
        $command = $this->application->find('app:generate-csv');
        $commandTester = new CommandTester($command);
        $commandTester->execute([]);

        $output = $commandTester->getDisplay();

        $this->assertStringContainsString('CSV file created', $output);
    }
}