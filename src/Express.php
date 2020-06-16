<?php

    namespace elevenstack\expressphp;
    error_reporting(0);

    use elevenstack\expressphp\TreatmentRoute as Router;

    class Express extends Router
    {
        protected $method_request;
        protected $route_aplication_separete;
        protected $simple_route_aplication;
        protected $get_request;
        protected $type_aplication;
        protected $global_route;
        protected $namespace;

        protected $response_params = [];
        protected $request_params = [];
        protected $all_routes = [];
        protected $http_code = [100,101,200,201,202,203,204,205,206,300,301,302,303,304,305,307,400,401,402,403,404,405,406,407,408,409,410,411,412,413,414,415,416,417,501,502,503,504,505];

        public function __construct()
        {   
            $split_route = str_split($_GET['aplication']);

            if(count($split_route) > 1){
                $split_route[0] = '';
                $this->global_route = implode('', $split_route);
            }

            $this->get_request = $this->global_route;

            $this->method_request = $_SERVER["REQUEST_METHOD"];
            $this->simple_route_aplication = $this->global_route ?? '/';
            $this->route_aplication_separete = explode('/', $this->simple_route_aplication);

            $this->request_params["METHOD_TYPE"] = $this->method_request;

            $this->methods_response();
        }

        public function namespace($spacename)
        {
            $this->namespace = $spacename;
        }   

        public function get($route, $func)
        { 
            $this->params($route, $this->get_request); //tem que vir antes do route ser reescrevido pelo método Route

            $route = $this->Route($route, $this->get_request);

            if($this->method_request == 'GET' AND $route == $this->simple_route_aplication){
                $this->all_routes[] = $route;

                $this->call_func_methods($func);
            }else{
                $this->all_routes[] = $route;
            }
        }

        public function post($route, $func)
        { 
            $this->params($route, $this->get_request);

            $route = $this->Route($route, $this->get_request);

            if($this->method_request == 'POST' AND $route == $this->simple_route_aplication){
                $this->request_body();
                $this->all_routes[] = $route;
                
                $this->call_func_methods($func);
            }else{
                $this->all_routes[] = $route;
            }
        }

        public function put($route, $func)
        {
            $this->params($route, $this->get_request);

            $route = $this->Route($route, $this->get_request);

            if($this->method_request == 'PUT' AND $route == $this->simple_route_aplication){
                $this->request_body();
                $this->all_routes[] = $route;

                $this->call_func_methods($func);
            }else{
                $this->all_routes[] = $route;
            }
        }

        public function delete($route, $func)
        {
            $this->params($route, $this->get_request);

            $route = $this->Route($route, $this->get_request);

            if($this->method_request == 'DELETE' AND $route == $this->simple_route_aplication){
                $this->request_body();
                $this->all_routes[] = $route;

                $this->call_func_methods($func);
            }else{
                $this->all_routes[] = $route;
            }
        }

        public function call_func_methods($func)
        {
            if(is_callable($func)){
                $func($this->request_params, $this->response_params);
            }else{
                $explode_in_dots = explode(':', $func);
                $controller = $explode_in_dots[0];
                $method = $explode_in_dots[1];

                $formate = explode('/', $this->namespace);
                $formate_use = implode('\\', $formate);

                $controller = $formate_use.$controller;
                $controller = new $controller;

                call_user_func_array([$controller, $method], [$this->request_params, $this->response_params]);
            }
        }

        public function params($route, $request)
        {
            $this->request_params["params"] = $this->treat_param($route, $request); 
            $this->request_params["params"] = $this->takeof_doubleDotos($this->request_params["params"]);
            $this->request_params['queries'] = $this->get_q($_SERVER['QUERY_STRING']);
        }

        public function request_body()
        {
            $body_request = file_get_contents("php://input");
            $this->request_params["body"] = json_decode($body_request, true);
        }

        public function type_aplication($type)
        {
            if($type == 'web' OR $type == 'api'){
                $this->type_aplication = $type;
            }else{
                echo 'type aplication invalid, web or api';
            }
        }

        public function getRoute_request()
        {
            return $this->global_route;
        }

        public function verify_route($route_request)
        {
            $valor = '';

            foreach ($this->all_routes as $key => $value) {
                if($route_request == $this->all_routes[$key]){
                    $valor = $this->all_routes[$key];
                }
            }

            return $valor;
        }

        public function error($route_request, $func)
        {
            if($this->type_aplication == 'web') {
                $this->response_params['return_arv'] = function($arv){
                    include($arv);
                };
            }
            
            if($route_request == ''){
                $route_request = '/';
            }

            if($route_request !== $this->verify_route($route_request)){
                if(is_callable($func)){
                    $func($this->response_params);
                }else{
                    $explode_in_dots = explode(':', $func);
                    $controller = $explode_in_dots[0];
                    $method = $explode_in_dots[1];
    
                    $formate = explode('/', $this->namespace);
                    $formate_use = implode('\\', $formate);
    
                    $controller = $formate_use.$controller;
                    $controller = new $controller;
    
                    call_user_func_array([$controller, $method], [$this->request_params]);
                }
            }
        }

        public function methods_response()
        {
            $this->response_params["send"] = function($information, $code = '200'){
                if(in_array($code, $this->http_code)){
                    header("HTTP/1.0 {$code}", true, $code);
                    echo $information;
                }else{
                    echo "http code invalid";
                }
            }; 

            $this->response_params["json"] = function($information, $code = '200'){
                if(in_array($code, $this->http_code)){
                    header("HTTP/1.0 {$code}", true, $code);
                    echo json_encode($information);
                }else{
                    echo json_encode("http code invalid");
                }
            }; 

            $this->response_params["redirect"] = function($link){
                header('Location: '.$link);
            };

            $this->response_params["status_code"] = function(){
                echo http_response_code();
            };

            $this->response_params["sendFile"] = function($dirname, $filename){
                $arquivo = filter_var($filename, FILTER_SANITIZE_STRING);
                $arquivo = basename($arquivo);

                $caminho = $dirname.$filename;

                if(!file_exists($caminho))
                    die('Not found');

                header('Content-type: octet/stream');
                header('Content-disposition: attachment; filename="'.$arquivo.'";'); 
                header('Content-Length: '.filesize($caminho));

                readfile($caminho);
                exit;
            };
        }
    }