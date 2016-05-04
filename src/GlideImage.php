<?php

namespace Spatie\Glide;

use League\Glide\ServerFactory;
use Spatie\Glide\Exceptions\SourceFileDoesNotExist;
use League\Flysystem\Filesystem;
use League\Flysystem\Adapter\Local;

class GlideImage
{
    /**
     * @var string The path to the input image.
     */
    protected $sourceFile;

    /**
     * @var array The modification the need to be made on the image.
     *            Take a look at Glide's image API to see which parameters are possible.
     *            http://glide.thephpleague.com/1.0/api/quick-reference/
     */
    protected $modificationParameters = [];

    public static function create(string $sourceFile) : GlideImage
    {
        return (new static())->setSourceFile($sourceFile);
    }

    public function setSourceFile(string $sourceFile) : GlideImage
    {
        if (!file_exists($sourceFile)) {
            throw new SourceFileDoesNotExist();
        }

        $this->sourceFile = $sourceFile;

        return $this;
    }

    public function modify(array $modificationParameters) : GlideImage
    {
        $this->modificationParameters = $modificationParameters;

        return $this;
    }

    public function save(string $outputFile) : string
    {
        $sourceFileName = pathinfo($this->sourceFile, PATHINFO_BASENAME);

        $cacheDir = sys_get_temp_dir();

        if (array_has($this->modificationParameters, 'mark')) {
            list($watermarksFolder, $modificationParameters) = $this->getWatermarkParameters();
        }

        $glideServer = ServerFactory::create([
            'source' => dirname($this->sourceFile),
            'cache' => $cacheDir,
            'driver' => config('laravel-glide.driver'),
            'watermarks' => !empty($watermarksFolder) ? new Filesystem(new Local($watermarksFolder)) : null,
        ]);

        $conversionResult = $cacheDir.'/'.$glideServer->makeImage($sourceFileName, $modificationParameters ?? $this->modificationParameters);

        rename($conversionResult, $outputFile);

        return $outputFile;
    }

    protected function getWatermarkParameters() : array
    {
        $pathParts = pathinfo($this->modificationParameters['mark']);

        $modificationParameters = collect($this->modificationParameters)->map(function ($item, $key) use ($pathParts) {

            if ($key === 'mark') {
                $item = $pathParts['basename'];
            }
            return $item;

        })->toArray();

        return [$pathParts['dirname'], $modificationParameters];
    }
}
