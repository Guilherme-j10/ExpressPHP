<?php

    //vamos trabalahar com parametros agora
    //  /contatos/empresa/:tel
    // :tel -> paremtro telefone

    // /users/:nome -> http://localhost/express/users/Guilherme
    //                                               /:nome
    //tem que retornar todos os usuarios com o nome guilherme
    /*

        $app->get('/contatos/:id', function($req, $res){
            echo $res.param["id"];
        });

        dentro do method get vai ser tratado os parametros de rota
        e serão armazenados dentro do array param

        :id tem o valor 23
         
        $param = [
            "id" => 12
        ]
    */
            //array search
    //  contatos/:id/:email
    //  contatos/23/gui@gmail.com

    
    
    // 

    // $string = 'users/:id';
    // $string_array = explode('/', $string);

    // $verify = str_split($string);
    // if(in_array(':', $verify)){
    //     for ($i=0; $i <= count($string_array); $i++) { 
    //         if(preg_match('/:/', $string_array[$i])){
    //             unset($string_array[$i]);
    //         }
    //     }

    //     $route = implode('/', $string_array).'/';

    //     echo $route;
    // }else{
    //     echo $string;
    // }

    

    

    // $string = 'contatos/2/';
    // $string_array = array_filter(explode('/', $string));

    // $text = implode('/', $string_array);

    // print_r($text);

    // $route = 'contatos/:id';
    // $array = str_split($route);
    // if(in_array(':', $array)){  
    //     echo "tem";
    // }else{
    //     echo "nao tem";
    // }
    
    
    // function tratamento_de_rota($route, $request){


    //     if($route == '/'){
    //         $route = '/';
    //     }else{
    //         $r_explode = array_filter(explode('/', $route));
    //         $splash = explode('/:/', $route);
    //         $s_arr = str_split($splash[0]);
    //         if($s_arr[0].$s_arr[1] == '/:'){
    //             $root = true;
    //         }else{
    //             $root = false;
    //         }

    //         if(count($r_explode) > 1){
    //             $verification = str_split($route);
    //             $term = ':';

    //             if(in_array($term, $verification)){
    //                 $array_route = str_split($route);
    //                 $array_route[0] = '';
    //                 $unified = implode('', $array_route);
    //                 $route = rtrim($unified);

    //                 $params_response = $this->treat_param($route, $request);
    //                 $implode = ''; //preciso das chaves
    //                 for($i = 0; $i < count($params_response); $i++){
    //                     $implode .= key($params_response);
    //                     next($params_response);
    //                 }
                    
    //                 $verify = str_split($implode);

    //                 if(in_array(':', $verify)){
    //                     $route_without_param = $this->takeOf_param($route);

    //                     foreach($params_response as $key){
    //                         $route_without_param .= $key.'/';
    //                     }

    //                     $r_array = array_filter(explode('/', $route_without_param));
    //                     $text = implode('/', $r_array);
    //                     $route = $text;
    //                 }else{
    //                     $route = $this->takeOf_param($route);
    //                 }
    //             }else{
    //                 $array_route = str_split($route);
    //                 $array_route[0] = '';
    //                 $unified = implode('', $array_route);
    //                 $route = rtrim($unified);
    //             }
    //         }else{
    //             $route = $r_explode[1];
    //         }
    //     }
    // }

    // $param = 'contatos/:nome/:sobrenome/:email';
    // $request_param = 'contatos/Guilherme/Campos/campos@gmail.com';

    // $param_array = str_split($param);
    // if($param_array[0] == '/'){
    //     $param_array[0] = '';

    //     $param = implode('', $param_array);
    // }

    // $string = $param;
    // $string_array = explode('/', $string);

    // $request = $request_param;
    // $request_array = explode('/', $request);

    // if(count($string_array) == count($request_array)){
    //     $param = '';
    //     $valor = '';
    
    //     foreach($string_array as $key => $value){
    //         if(preg_match('/:/', $value)){
    //             $valor = $value;
    //         }
            
    //         $param .= array_search($valor, $string_array);
    //         $param_array = str_split($param);
    //     }
    
    //     $parametros = [];
    
    //     for($i = 0; $i < count($param_array); $i++){
    //         $parametros[$string_array[$param_array[$i]]] = $request_array[$param_array[$i]];
    //     }

    //     for($j = 0; $j < count($parametros); $j++){
    //         $new_key = preg_replace('/:/', '', key($parametros));
    //         next($parametros);

    //         $values = array_values($parametros);
    //         $parametros[$new_key] = $values[$j];
    //     }

    //     foreach($parametros as $chave => $valor){
    //         if(preg_match('/:/', $chave)){
    //             unset($parametros[$chave]);
    //         }
    //     }

    //     print_r($parametros);

    // }else{
    //     return false;
    // }


    // $parametros = [
    //     ":nome" => "Guilherme",
    //     ":sobrenome" => "Campos"
    // ];

    // function takeof_doubleDotos($parametros){
    //     for($j = 0; $j < count($parametros); $j++){
    //         $new_key = preg_replace('/:/', '', key($parametros));
    //         next($parametros);

    //         $values = array_values($parametros);
    //         $parametros[$new_key] = $values[$j];
    //     }

    //     foreach($parametros as $chave => $valor){
    //         if(preg_match('/:/', $chave)){
    //             unset($parametros[$chave]);
    //         }
    //     }

    //     print_r($parametros);
    // }

    // takeof_doubleDotos($parametros);