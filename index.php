<?php

    /**
     * Restrictions:
     *      The route ('root') '/' don't accept parameters
     *      não pode haver barra no final das rotas
     *      don't can gave bar in the final of routes
     *      Exemple:
     *          Wrong: 'contatos/empresa/'
     *          Right: 'contatos/empresa'
     */

    require_once "vendor/autoload.php";

    use src\Express as ExpressPHP;

    $app = new ExpressPHP();

    $app->type_aplication('api');

    $users = [
        "Guilherme" => 'campos',
        "Diego" => 'Rodrigues',
        "Rodrigo" => 'Melo',
        "Felipe" => 'Françoso'
    ];

    $app->get('/', function($request, $response){
        $response['json']('root');
    });

    $app->get('/home/:nome', function($request, $response){
        $response['json']($request['params']['nome']);
    });

    $app->get('/queries', function($request, $response) {
        $response['json']($request['queries']['nome']);
    });

    $app->get('/listagem', function($request, $response) use($users){
        $data = [
            'Dados' => $users,
            'METHOD_TYPE' => $request['METHOD_TYPE']
        ];

        $response['json']($data);
    });

    //usar o curl para fazer o envio dos dados
    $app->post('/postagem', function($request, $response) use($users) {
        $users[$request['body']['nome']] = $request['body']['sobrenome'];
        $response['json']($users);
    });

    $app->put('/users', function($request, $response) use($users){
        $users[$request['body']['nome']] = $request['body']['sobrenome'];

        $response['json']($users);
    });

    $app->delete('/users', function($request, $response) use($users) {
        unset($users[$request['body']['nome']]);

        $response['json']($users);
    });

    //rota de erro
    $app->error($app->getRoute_request(), function($response) {
        $response['json']('url nao econtrada');
    });

    
    
  
