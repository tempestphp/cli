<?php

namespace Tempest\Cli\NewCommand;

use Symfony\Component\Console\Input\InputArgument;
use Tempest\Console\Console;
use Tempest\Console\ConsoleArgument;
use Tempest\Console\ConsoleCommand;
use Tempest\Console\InputBuffer;
use Tempest\Console\OutputBuffer;

final class NewCommand
{
    public function __construct(private Console $console)
    {}

    #[ConsoleCommand('new')]
    public function __invoke(
        #[ConsoleArgument('path', InputArgument::OPTIONAL)]
        ?string $projectPath = null
    ): void {
        $projectName = $this->console->ask('What is the name of your application?');

        NewCommandService::make($projectPath)
            ->setProjectName($projectName)
            ->create();
    }
}