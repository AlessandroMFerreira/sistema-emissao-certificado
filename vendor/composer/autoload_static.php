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
        'C' => 
        array (
            'Classes\\' => 8,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Fpdf\\' => 
        array (
            0 => __DIR__ . '/..' . '/fpdf/fpdf/src/Fpdf',
        ),
        'Classes\\' => 
        array (
            0 => __DIR__ . '/../..' . '/classes',
        ),
    );

    public static $classMap = array (
        'Classes\\autor' => __DIR__ . '/../..' . '/classes/autor.class.php',
        'Classes\\certificado' => __DIR__ . '/../..' . '/classes/certificado.class.php',
        'Classes\\conexao' => __DIR__ . '/../..' . '/classes/conexao.class.php',
        'Classes\\evento' => __DIR__ . '/../..' . '/classes/evento.class.php',
        'Classes\\participante' => __DIR__ . '/../..' . '/classes/participanteevento.class.php',
        'Classes\\usuario' => __DIR__ . '/../..' . '/classes/usuario.class.php',
        'Fpdf\\Fpdf' => __DIR__ . '/..' . '/fpdf/fpdf/src/Fpdf/Fpdf.php',
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
