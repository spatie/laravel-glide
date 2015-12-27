<?php

namespace Spatie\Glide;

use League\Glide\ServerFactory;

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
        $this->sourceFile = $sourceFile;

        return $this;
    }

    public function modify(array $modificationParameters) : GlideImage
    {
        $modificationParameters = $this->convertParametersToString(array_filter($modificationParameters));

        $this->modificationParameters = $modificationParameters;

        return $this;
    }

    public function save(string $outputFile) : string
    {
        $glideServer = ServerFactory::create([]);

        $glideServer->makeImage($outputFile, $this->modificationParameters);

        return $outputFile;
    }
}
