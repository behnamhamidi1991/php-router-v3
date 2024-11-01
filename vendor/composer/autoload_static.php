<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitb5da9aea8f81b231a1489dc7eaab4636
{
    public static $prefixLengthsPsr4 = array (
        'F' => 
        array (
            'Framework\\' => 10,
        ),
        'A' => 
        array (
            'App\\' => 4,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Framework\\' => 
        array (
            0 => __DIR__ . '/../..' . '/Framework',
        ),
        'App\\' => 
        array (
            0 => __DIR__ . '/../..' . '/App',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitb5da9aea8f81b231a1489dc7eaab4636::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitb5da9aea8f81b231a1489dc7eaab4636::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitb5da9aea8f81b231a1489dc7eaab4636::$classMap;

        }, null, ClassLoader::class);
    }
}