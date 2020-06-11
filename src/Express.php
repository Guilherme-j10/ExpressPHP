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

        protected $response_params = [];
        protected $request_params = [];
        protected $all_routes = [];

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

        public function get($route, $func)
        { 
            $this->params($route, $this->get_request); //tem que vir antes do route ser reescrevido pelo método Route

            $route = $this->Route($route, $this->get_request);

            if($this->method_request == 'GET' AND $route == $this->simple_route_aplication){
                $this->all_routes[] = $route;

                $func($this->request_params, $this->response_params);
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
                
                $func($this->request_params, $this->response_params);
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

                $func($this->request_params, $this->response_params);
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

                $func($this->request_params, $this->response_params);
            }else{
                $this->all_routes[] = $route;
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
                $func($this->response_params);
            }
        }

        public function methods_response()
        {
            $this->response_params["send"] = function($infotmation){
                echo $infotmation;
            };

            $this->response_params["json"] = function($infotmation){
                echo json_encode($infotmation);
            };

            $this->response_params["redirect"] = function($link){
                header('Location: '.$link);
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