<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit22aad6c0a3e0aad2f5d98255d1af0a74
{
    public static $files = array (
        '0e6d7bf4a5811bfa5cf40c5ccd6fae6a' => __DIR__ . '/..' . '/symfony/polyfill-mbstring/bootstrap.php',
        'a4a119a56e50fbb293281d9a48007e0e' => __DIR__ . '/..' . '/symfony/polyfill-php80/bootstrap.php',
        '667aeda72477189d0494fecd327c3641' => __DIR__ . '/..' . '/symfony/var-dumper/Resources/functions/dump.php',
    );

    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'Symfony\\Polyfill\\Php80\\' => 23,
            'Symfony\\Polyfill\\Mbstring\\' => 26,
            'Symfony\\Component\\VarDumper\\' => 28,
        ),
        'M' => 
        array (
            'Mrzkit\\WppCustomPermalinks\\' => 27,
            'Mrzkit\\SimpleDatabase\\' => 22,
            'Mrzkit\\SimpleDatabaseTest\\' => 26,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Symfony\\Polyfill\\Php80\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/polyfill-php80',
        ),
        'Symfony\\Polyfill\\Mbstring\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/polyfill-mbstring',
        ),
        'Symfony\\Component\\VarDumper\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/var-dumper',
        ),
        'Mrzkit\\WppCustomPermalinks\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
        'Mrzkit\\SimpleDatabase\\' => 
        array (
            0 => __DIR__ . '/..' . '/mrzkit/simple-database/src',
        ),
        'Mrzkit\\SimpleDatabaseTest\\' => 
        array (
            0 => __DIR__ . '/..' . '/mrzkit/simple-database/test',
        ),
    );

    public static $classMap = array (
        'Attribute' => __DIR__ . '/..' . '/symfony/polyfill-php80/Resources/stubs/Attribute.php',
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
        'PhpToken' => __DIR__ . '/..' . '/symfony/polyfill-php80/Resources/stubs/PhpToken.php',
        'Stringable' => __DIR__ . '/..' . '/symfony/polyfill-php80/Resources/stubs/Stringable.php',
        'UnhandledMatchError' => __DIR__ . '/..' . '/symfony/polyfill-php80/Resources/stubs/UnhandledMatchError.php',
        'ValueError' => __DIR__ . '/..' . '/symfony/polyfill-php80/Resources/stubs/ValueError.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit22aad6c0a3e0aad2f5d98255d1af0a74::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit22aad6c0a3e0aad2f5d98255d1af0a74::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit22aad6c0a3e0aad2f5d98255d1af0a74::$classMap;

        }, null, ClassLoader::class);
    }
}
