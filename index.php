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

    use src\Express;

    $app = new Express();

    $users = [
        "Guilherme" => 'campos',
        "Diego" => 'Rodrigues',
        "Rodrigo" => 'Melo',
        "Felipe" => 'Françoso'
    ];

    $app->get('/', function($request, $response) {
        $response['redirect']('recebe_redirect');
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

    $app->post('/postagem', function($request, $response) use($users) {
        $users[$request['body']['nome']] = $request['body']['sobrenome'];
        $response['json']($users);
    });
    
  
