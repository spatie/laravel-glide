<?php

namespace Spatie\Glide\Test\Integration;

use Spatie\Glide\Exceptions\SourceFileDoesNotExist;
use Spatie\Glide\GlideImage;

class GlideImageTest extends TestCase
{
    /**
     * @test
     */
    public function it_can_modify_an_image()
    {
        $targetFile = __DIR__.'/temp/conversion.jpg';

        GlideImage::create($this->getTestJpg())
            ->modify(['w' => '50'])
             ->save($targetFile);

        $this->assertFileExists($targetFile);
    }

    /**
     * @test
     */
    public function it_can_copy_a_file()
    {
        $targetFile = __DIR__.'/temp/conversion.jpg';

        GlideImage::create($this->getTestJpg())
            ->save($targetFile);

        $this->assertFileExists($targetFile);
    }

    /**
     * @test
     */
    public function it_will_throw_an_exception_if_the_source_file_does_not_exist()
    {
        $this->setExpectedException(SourceFileDoesNotExist::class);

        GlideImage::create('blabla');
    }
}
