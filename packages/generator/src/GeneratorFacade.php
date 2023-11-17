<?php

namespace Rahel\Generator;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Rahel\Generator\Skeleton\SkeletonClass
 */
class GeneratorFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'generator';
    }
}
