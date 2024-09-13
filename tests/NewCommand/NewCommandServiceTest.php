<?php

namespace Tempest\Cli\Tests\NewCommand;

use PHPUnit\Framework\TestCase;
use Tempest\Cli\NewCommand\NewCommandService;
use UnexpectedValueException;

final class NewCommandServiceTest extends TestCase
{
    public function test_make_factory_method()
    {
        $service = NewCommandService::make(__DIR__);

        $this->assertEquals(__DIR__, $service->getProjectPath());
    }

    public function test_setting_project_name_strips_special_characters()
    {
        $service = new NewCommandService();

        $service->setProjectName('Jim\'s Testing');

        $this->assertEquals('JimsTesting', $service->getProjectName());
    }

    public function test_relative_paths_remain_relative()
    {
        $service = new NewCommandService('./my-project');

        $this->assertEquals(getcwd() . DIRECTORY_SEPARATOR . './my-project', $service->getProjectPath());
    }

    public function test_existing_file_cannot_be_passed()
    {
        $this->expectExceptionObject(
            new UnexpectedValueException('Please specify a directory.')
        );

        new NewCommandService(__DIR__ . '/NewCommandServiceTest.php');
    }

    public function test_existing_project_returns_false_for_projects_missing_a_composer_file()
    {
        $this->assertFalse(
            NewCommandService::make(__DIR__)->isExistingProject()
        );
    }

    public function test_existing_project_returns_true_for_projects_with_a_composer_file()
    {
        $this->assertTrue(
            NewCommandService::make(__DIR__ . '/../../')->isExistingProject()
        );
    }
}