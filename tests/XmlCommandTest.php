<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Tester\CommandTester;

class XmlCommandTest extends KernelTestCase
{
    public function testCorrectFilePath(): void
    {
        self::bootKernel();
        $application = new Application(self::$kernel);

        $command = $application->find('app:processXmlFile');
        $commandTester = new CommandTester($command);
        $commandTester->execute([
            'filePath' => './feed.xml'
        ]);

        $commandTester->assertCommandIsSuccessful();
        $output = $commandTester->getDisplay();

        $this->assertStringContainsString('Your xml data has successfully been stored to the database.', $output);
    }

    public function testCorrectUriPath(): void
    {
        self::bootKernel();
        $application = new Application(self::$kernel);

        $command = $application->find('app:processXmlFile');
        $commandTester = new CommandTester($command);
        $commandTester->execute([
            'filePath' => 'https://xmluploader.ddev.site/feed.xml'
        ]);

        $commandTester->assertCommandIsSuccessful();
        $output = $commandTester->getDisplay();

        $this->assertStringContainsString('Your xml data has successfully been stored to the database.', $output);
    }

    public function testWrongFilePath(): void
    {
        self::bootKernel();
        $application = new Application(self::$kernel);

        $command = $application->find('app:processXmlFile');
        $commandTester = new CommandTester($command);
        $commandTester->execute([
            'filePath' => './test/feed.xml'
        ]);

        $output = $commandTester->getDisplay();

        $this->assertStringContainsString('The xml file could not be downloaded. The requested file was not found.', $output);
    }

    public function testWrongUriPath(): void
    {
        self::bootKernel();
        $application = new Application(self::$kernel);

        $command = $application->find('app:processXmlFile');
        $commandTester = new CommandTester($command);
        $commandTester->execute([
            'filePath' => 'https://xmluploader.ddev.site/test/feed.xml'
        ]);

        $commandTester->assertCommandIsSuccessful();
        $output = $commandTester->getDisplay();

        $this->assertStringContainsString('The xml file could not be downloaded. The requested file was not found.', $output);
    }
}