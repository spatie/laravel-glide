<?php

namespace Spatie\Glide\Test\Integration;

use Spatie\Glide\GlideImage;

class GlideImageTest extends TestCase
{
    /**
     * @test
     */
    public function it_can_save_a_manipulated_file()
    {
        $targetFile = __DIR__.'/temp/conversion.jpg';

        GlideImage::create($this->getTestJpg())
            ->modify(['w' => 200])
             ->save($targetFile);

        $this->assertTrue(false);
    }
}
