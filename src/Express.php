<?php

    namespace src;
    error_reporting(0);

    use src\TreatmentRoute as Router;

    class Express extends Router
    {

        protected $method_request;
        protected $route_aplication_separete;
        protected $simple_route_aplication;
        protected $get_request;

        protected $response_params = [];
        protected $request_params = [];
        protected $all_routes = [];

        public function __construct()
        {   
            $this->get_request = $_GET['aplication'];

            $this->method_request = $_SERVER["REQUEST_METHOD"];
            $this->simple_route_aplication = $_GET["aplication"] ?? '/';
            $this->route_aplication_separete = explode('/', $this->simple_route_aplication);

            $this->request_params["METHOD_TYPE"] = $this->method_request;

            $this->response_params["send"] = function($infotmation){
                echo $infotmation;
            };
            $this->response_params["json"] = function($infotmation){
                echo json_encode($infotmation);
            };
            $this->response_params["redirect"] = function($link){
                header('Location: '.$link);
            };
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
        }

        public function request_body(){
            $body_request = file_get_contents("php://input");
            $this->request_params["body"] = json_decode($body_request, true);
        }

        public function type_aplication($type){
            if($type == 'web' OR $type == 'api'){
                return $type;
            }else{
                echo 'type aplication invalid, web or api';
            }
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
            if($route_request !== $this->verify_route($route_request)){
                $func($this->response_params);
            }
        }
    }