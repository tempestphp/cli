<?php

namespace Tempest\Cli\NewCommand;

use UnexpectedValueException;
use const DIRECTORY_SEPARATOR;

final class NewCommandService
{
    private string $projectName;
    private string $projectPath;

    public static function make(string $projectPath): self
    {
        return new self($projectPath);
    }

    public function __construct(?string $projectPath = null)
    {
        $this->setProjectPath($projectPath ?? getcwd());
    }

    public function create(): void
    {
        // TODO: Implement
    }

    public function getProjectName(): string
    {
        return $this->projectName;
    }

    public function setProjectName(string $projectName): self
    {
        $this->projectName = preg_replace('/[^a-zA-Z0-9_]/', '', $projectName);

        return $this;
    }

    public function getProjectPath(): string
    {
        return $this->projectPath;
    }

    public function setProjectPath(string $projectPath): self
    {
        if (! $this->isAbsolutePath($projectPath)) {
            // TODO: Clean this up. Tempest needs path helpers.
            $projectPath = getcwd() . DIRECTORY_SEPARATOR . ltrim($projectPath, '\\/');
        }

        if (file_exists($projectPath) && ! is_dir($projectPath)) {
            // TODO: Clean this up.
            throw new UnexpectedValueException('Please specify a directory.');
        }

        $this->projectPath = $projectPath;

        return $this;
    }

    public function isExistingProject(): bool
    {
        return file_exists($this->projectPath . DIRECTORY_SEPARATOR . 'composer.json');
    }

    private function isAbsolutePath(string $path): bool
    {
        return preg_match('/^(\/.*|[a-zA-Z]:\\\\(?:([^<>:"\/\\\\|?*]*[^<>:"\/\\\\|?*.]\\\\|..\\\\)*([^<>:"\/\\\\|?*]*[^<>:"\/\\\\|?*.]\\\\?|..\\\\))?)$/', $path);
    }
}