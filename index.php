<?php

require 'vendor/autoload.php';

$app = new \Slim\App();

$app->get('/hello', function() {
    return 'Hello World !';
});
$app->get('/diga-oi/{nome}[/{apelido}]', function($request, $response) {
    $nome = $request->getAttribute('nome');
    $apelido = $request->getAttribute('apelido') ?? "Sem Nome";
    $response->getbody()->write("Hello, {$nome}, tambem conhecido com, {$apelido}");

    return $response;
});

$app->get('/diga-ola[/{nome}]', function($request, $response) {
    $nome = $request->getAttribute('nome') ?? "Goku";
    $response->getbody()->write("Olá, {$nome}");
});



$app->run();
