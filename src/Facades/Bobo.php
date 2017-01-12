<?php

namespace Antron\Bobo\Facades;

use Illuminate\Support\Facades\Facade;

class Bobo extends Facade
{

    public static function getFacadeAccessor()
    {
        return 'bobo';
    }

}
