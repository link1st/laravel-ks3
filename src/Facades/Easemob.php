<?php namespace link1st\Ks3\Facades;

use Illuminate\Support\Facades\Facade;

class Ks3 extends Facade
{

    /**
     *
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'Ks3';
    }
}
