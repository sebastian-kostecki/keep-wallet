<?php

namespace Core;

class View
{
    public static function render($view, $arguments = [])
    {
        extract($arguments, EXTR_SKIP);
        $file = "../App/Views/$view";

        if (is_readable($file)) {
            require $file;
        } else {
            throw new \Exception("$file not found");
        }
    }

    public static function renderTemplate($template, $args = [])
    {
        echo static::getTemplate($template, $args);
    }

    public static function getTemplate($template, $args = [])
    {
        static $twig = null;

        if ($twig === null) {
            $loader = new \Twig\Loader\FilesystemLoader(dirname(__DIR__) . '/App/Views');
            $twig = new \Twig\Environment($loader);
            $twig->addGlobal('flash_messages', \App\Flash::getMessage());
            $twig->addGlobal('currentUser', \App\Authentication::getUser());
        }
        return $twig->render($template, $args);
    }
}
