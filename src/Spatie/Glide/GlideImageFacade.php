<?php namespace Spatie\Services\MediaLibrary\Facades;

use Illuminate\Support\Facades\Facade;

class GlideImageFacade extends Facade {

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'laraval-glide-image';
    }

}
