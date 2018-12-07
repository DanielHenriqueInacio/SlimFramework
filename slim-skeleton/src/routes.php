<?php

use Slim\Http\Request;
use Slim\Http\Response;

// Routes

/*$app->get('/[{name}]', function (Request $request, Response $response, array $args) {
    // Sample log message
    $this->logger->info("Slim-Skeleton '/' route");

    // Render index view
    return $this->renderer->render($response, 'index.phtml', $args);
});*/

$app->get('/formulario', function($request, $response) {
    return $this->renderer->render($response, 'form.phtml');
});

$app->post('/receber-dados', function($request, $response) {
    $params = $request->getBody()->getContents();
    parse_str($params, $dados);
    return $this->renderer->render($response, 'mostrar.phtml', $dados);
});

