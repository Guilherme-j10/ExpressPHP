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
    use src\Functions;

    $app = new Express();
    $func = new Functions();

    $users = [
        "Guilherme" => 'campos',
        "Diego" => 'Rodrigues',
        "Rodrigo" => 'Melo',
        "Felipe" => 'Françoso'
    ];

    $app->get('/v1/key', function($request, $response) use($users, $func){
        $data = [
            $users,
            $request['METHOD_TYPE']
        ];

        $func->retorna($data);
    });

    $app->get('/v1/key/:nome', function($request, $response) use($users, $func){
        $func->retorna($users[$request["body"][":nome"]]);
    });
    
  
