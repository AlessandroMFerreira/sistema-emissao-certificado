<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitace1a157ee50d06cb575f13b60da3402
{
    public static $prefixLengthsPsr4 = array (
        'F' => 
        array (
            'Fpdf\\' => 5,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Fpdf\\' => 
        array (
            0 => __DIR__ . '/..' . '/fpdf/fpdf/src/Fpdf',
        ),
    );

    public static $classMap = array (
        'certificado' => __DIR__ . '/../..' . '/classes/certificado.class.php',
        'conexao' => __DIR__ . '/../..' . '/classes/conexao.class.php',
        'evento' => __DIR__ . '/../..' . '/classes/evento.class.php',
        'usuario' => __DIR__ . '/../..' . '/classes/usuario.class.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitace1a157ee50d06cb575f13b60da3402::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitace1a157ee50d06cb575f13b60da3402::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitace1a157ee50d06cb575f13b60da3402::$classMap;

        }, null, ClassLoader::class);
    }
}
