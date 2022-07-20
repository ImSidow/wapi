<?php

// autoload_real.php @generated by Composer

class ComposerAutoloaderInitec181ded3461d6ba255ad4f100a425ac
{
    private static $loader;

    public static function loadClassLoader($class)
    {
        if ('Composer\Autoload\ClassLoader' === $class) {
            require __DIR__ . '/ClassLoader.php';
        }
    }

    /**
     * @return \Composer\Autoload\ClassLoader
     */
    public static function getLoader()
    {
        if (null !== self::$loader) {
            return self::$loader;
        }

        spl_autoload_register(array('ComposerAutoloaderInitec181ded3461d6ba255ad4f100a425ac', 'loadClassLoader'), true, true);
        self::$loader = $loader = new \Composer\Autoload\ClassLoader(\dirname(__DIR__));
        spl_autoload_unregister(array('ComposerAutoloaderInitec181ded3461d6ba255ad4f100a425ac', 'loadClassLoader'));

        require __DIR__ . '/autoload_static.php';
        call_user_func(\Composer\Autoload\ComposerStaticInitec181ded3461d6ba255ad4f100a425ac::getInitializer($loader));

        $loader->register(true);

        return $loader;
    }
}
