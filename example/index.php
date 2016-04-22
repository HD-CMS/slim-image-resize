<?php

require "../vendor/autoload.php";



$app = new \Slim\App();

// Get container
$container = $app->getContainer();

// Register component on container
$container['view'] = function ($container) {
    $view = new \Slim\Views\Twig('templates', [
        'cache' => false
    ]);
    $view->addExtension(new \Slim\Views\TwigExtension(
                            $container['router'],
                            $container['request']->getUri()
                        ));

    return $view;
};

$app->add(new Slim\Middleware\ImageResize());

// Render Twig template in route
$app->get('/', function ($request, $response, $args) {
    return $this->view->render($response, 'index.html');
})->setName('Index');

// Run app
$app->run();