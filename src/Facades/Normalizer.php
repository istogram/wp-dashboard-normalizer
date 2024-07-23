<?php

namespace istogram\WpDashboardNormalizer\Facades;

use Illuminate\Support\Facades\Facade;

class Normalizer extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'Normalizer';
    }
}
