<?php

namespace Antron\Bobo;

/**
 * Arana.
 */
class Bobo
{

    public static function flushLog()
    {
        $filename = storage_path('log/laravel.log');

        if (file_exists($filename)) {
            print "<pre>";

            print file_get_contents($filename);

            print "</pre>";

            unlink($filename);

            exit;
        }
    }
}
