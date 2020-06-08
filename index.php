<?php

    /**
     * Restrictions:
     *      a rota ('root') '/' não aceita parametros
     *      não pode haver barra no final das rotas
     *      Exemplo:
     *          Errado: 'contatos/empresa/'
     *          Certo: 'contatos/empresa'
     */

    require_once "vendor/autoload.php";

    use src\Express as App;

    $app = new App();

    $app->type_aplication('api');

    $users = [
        "Guilherme" => 'campos',
        "Diego" => 'Rodrigues',
        "Rodrigo" => 'Melo',
        "Felipe" => 'Françoso'
    ];

    $app->get('/', function($request, $response) {
        $response['redirect']('recebe_redirect');
    });

    $app->get('/contatos/empresa', function($request, $response) {
        $response['send']('composto');
    });

    $app->get('/recebe_redirect', function($request, $response) {
        $response['send']('redirecionamento do root "/" recebido');
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

    $app->error($_GET['aplication'], function($response) {
        $response['send']('
            <h1>Página nao encontrada</h1>
            <a href="listagem">voltar para a listagem</a>
        ');
    });

    
    
  
