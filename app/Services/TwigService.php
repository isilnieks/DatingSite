<?php

namespace App\Services;

use Twig\Environment;
use Twig\Extension\DebugExtension;
use Twig\Loader\FilesystemLoader;

class TwigService
{
    private Environment $twig;

    public function __construct()
    {
        $loader = new FilesystemLoader('../app/Views');
        $this->twig = new Environment($loader, [
            'debug' => true,
        ]);
        $this->twig->addExtension(new DebugExtension());
    }

    public function environment(): Environment
    {
        return $this->twig;
    }



}