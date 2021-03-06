<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit0fc8b61571d3326aef3d6956b91c5173
{
    public static $prefixLengthsPsr4 = array (
        'A' => 
        array (
            'Antron\\Bobo\\' => 12,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Antron\\Bobo\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $classMap = array (
        'Antron\\Bobo\\AranaServiceProvider' => __DIR__ . '/../..' . '/src/BoboServiceProvider.php',
        'Antron\\Bobo\\Bobo' => __DIR__ . '/../..' . '/src/Bobo.php',
        'Antron\\Bobo\\Facades\\Bobo' => __DIR__ . '/../..' . '/src/Facades/Bobo.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit0fc8b61571d3326aef3d6956b91c5173::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit0fc8b61571d3326aef3d6956b91c5173::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit0fc8b61571d3326aef3d6956b91c5173::$classMap;

        }, null, ClassLoader::class);
    }
}
