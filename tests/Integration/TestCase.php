<?php

namespace Spatie\Glide\Test\Integration;

use File;
use Orchestra\Testbench\TestCase as Orchestra;
use Spatie\Glide\GlideServiceProvider;

abstract class TestCase extends Orchestra
{
    public function setUp(): void
    {
        parent::setUp();

        $this->setUpTempTestFiles();
    }

    protected function getPackageProviders($app): array
    {
        return [
            GlideServiceProvider::class,
        ];
    }

    protected function setUpTempTestFiles()
    {
        $this->initializeDirectory($this->getTempDirectory());
    }

    protected function initializeDirectory($directory)
    {
        if (File::isDirectory($directory)) {
            File::deleteDirectory($directory);
        }
        File::makeDirectory($directory);
    }

    public function getTempDirectory(string $suffix = ''): string
    {
        return __DIR__.'/temp'.($suffix == '' ? '' : '/'.$suffix);
    }

    public function getTestJpg(): string
    {
        return __DIR__.'/testfiles/test.jpg';
    }
}
