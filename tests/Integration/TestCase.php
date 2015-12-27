<?php

namespace Spatie\Glide\Test\Integration;

use File;
use Orchestra\Testbench\TestCase as Orchestra;

abstract class TestCase extends Orchestra
{
    public function setUp()
    {
        parent::setUp();

        $this->setUpTempTestFiles();
    }

    /**
     * @param \Illuminate\Foundation\Application $app
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            \Spatie\Glide\GlideServiceProvider::class,
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

    public function getTempDirectory($suffix = '')
    {
        return __DIR__.'/temp'.($suffix == '' ? '' : '/'.$suffix);
    }

    public function getTestJpg()
    {
        return __DIR__.'/testfiles/test.jpg';
    }
}
