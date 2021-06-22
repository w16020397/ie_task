<?php

namespace App\Tests\Command;

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Tester\CommandTester;

class OutputDirectoryTest extends KernelTestCase
{
    protected function setUp(): void
    {
        $kernel = static::createKernel();

        $this->application = new Application($kernel);
    }

    public function testFileSuccessfullyCreated()
    {
        $command = $this->application->find('app:generate-csv');
        $commandTester = new CommandTester($command);
        $commandTester->execute([
            'output_directory' => '/tmp'
        ]);

        $output = $commandTester->getDisplay();

        $this->assertStringContainsString('CSV file created', $output);
    }

    public function testFileFailed()
    {
        $command = $this->application->find('app:generate-csv');
        $commandTester = new CommandTester($command);
        $commandTester->execute([
            'output_directory' => '/directory_that_does_not_exist'
        ]);

        $output = $commandTester->getDisplay();

        $this->assertStringContainsString('does not exist', $output);
    }
}