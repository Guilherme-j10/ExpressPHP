<?php
    require_once "vendor/autoload.php";

    use elevenstack\expressphp\Express as ExpressPHP;

    $app = new ExpressPHP();

    $app->type_aplication('api');

    $users = [
        "Guilherme" => 'campos',
        "Diego" => 'Rodrigues',
        "Rodrigo" => 'Melo',
        "Felipe" => 'Françoso'
    ];

    $app->get('/arquivos', function($request, $response){
        $response['send']('
            <h1>Clique aqui para fazer o download do index html</h1>
            <a href="downloads/index"> Bixar arquivo index </a><br>
            <a href="downloads/texto"> Bixar texto </a>
        ');
    });

    $app->get('/downloads/:nome_arv', function($request, $response){
        $arv = $request['params']['nome_arv'];

        switch ($arv) {
            case 'index':
                $response['sendFile']('downloads/', 'index.html');
            break;
            case 'texto':
                $response['sendFile']('downloads/', 'text_test.txt');
            break;
            default:
                echo 'file name invalid.';
            break;
        }
    });

    $app->get('/home/:nome', function($request, $response){
        $response['json']($request['params']['nome']);
    });

    $app->get('/queries', function($request, $response) {
        $response['json']($request['queries']['sobrenome']);
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