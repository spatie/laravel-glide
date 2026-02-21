<?php

namespace Spatie\Glide\Test\Integration;

use PHPUnit\Framework\Attributes\Test;
use Spatie\Glide\Exceptions\SourceFileDoesNotExist;
use Spatie\Glide\GlideImage;

class GlideImageTest extends TestCase
{
    #[Test]
    public function it_can_modify_an_image()
    {
        $targetFile = __DIR__.'/temp/conversion.jpg';

        GlideImage::create($this->getTestJpg())
            ->modify(['w' => '50'])
            ->save($targetFile);

        $this->assertFileExists($targetFile);
    }

    #[Test]
    public function it_can_copy_a_file()
    {
        $targetFile = __DIR__.'/temp/conversion.jpg';

        GlideImage::create($this->getTestJpg())
            ->save($targetFile);

        $this->assertFileExists($targetFile);
    }

    #[Test]
    public function it_will_throw_an_exception_if_the_source_file_does_not_exist()
    {
        $this->expectException(SourceFileDoesNotExist::class);

        GlideImage::create('blabla');
    }

    #[Test]
    public function it_can_add_a_watermark_to_an_image()
    {
        $watermark = __DIR__.'/stubs/watermark.png';
        $targetFile = __DIR__.'/temp/watermarked.jpg';

        GlideImage::create($this->getTestJpg())
            ->modify([
                'mark' => $watermark,
                'markw' => '40',
                'markh' => '40',
                'markpad' => '15',
                'markpos' => 'top-right',
            ])
            ->save($targetFile);

        $this->assertFileNotEquals($this->getTestJpg(), $targetFile);
        $this->assertFileExists($targetFile);
    }
}
