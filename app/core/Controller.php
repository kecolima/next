<?php

namespace app\core;

class Controller
{
    protected function load(string $view, $params = [])
    {       
        $twig = new \Twig\Environment(
            new \Twig\Loader\FilesystemLoader('../app/view/')
        );

        $twig->addGlobal('BASE', BASE);
        if (isset($_SESSION['id'])) {            
            echo $twig->render($view . '.twig.php', $params);
        } else {
            echo $twig->render('login/login.twig.php', $params);
        }       
    }

    public function showMessage(string $titulo, string $descricao, string $link = null, int $httpCode = 200)
    {
        http_response_code($httpCode);

        $this->load('partials/message', [
            'titulo'    => $titulo,
            'descricao' => $descricao,
            'link'      => $link
        ]);
    }
}
