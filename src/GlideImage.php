<?php

namespace Spatie\Glide;

use League\Glide\ServerFactory;
use Spatie\Glide\Exceptions\SourceFileDoesNotExist;

class GlideImage
{
    protected $sourceFile;

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

        $glideServer = ServerFactory::create([
            'source' => dirname($this->sourceFile),
            'cache' => $cacheDir,
            'driver' => config('laravel-glide.driver'),
        ]);

        $conversionResult = $cacheDir.'/'.$glideServer->makeImage($sourceFileName, $this->modificationParameters);

        rename($conversionResult, $outputFile);

        return $outputFile;
    }
}
