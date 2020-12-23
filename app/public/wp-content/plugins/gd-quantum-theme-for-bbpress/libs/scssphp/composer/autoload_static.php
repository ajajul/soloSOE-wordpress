<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitce270e34db105891c208857062d52e05
{
    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'ScssPhp\\ScssPhp\\' => 16,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'ScssPhp\\ScssPhp\\' => 
        array (
            0 => __DIR__ . '/..' . '/scssphp/scssphp/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitce270e34db105891c208857062d52e05::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitce270e34db105891c208857062d52e05::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
