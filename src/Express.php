<?php

    namespace src;
    error_reporting(0);

    use src\TreatmentRoute;

    class Express extends TreatmentRoute
    {

        protected $method_request;
        protected $route_aplication_separete;
        protected $simple_route_aplication;

        protected $response_params = [];
        protected $request_params = [];

        public function __construct()
        {
            $this->method_request = $_SERVER["REQUEST_METHOD"];
            $this->simple_route_aplication = $_GET["aplication"] ?? '/';
            $this->route_aplication_separete = explode('/', $this->simple_route_aplication);

            $this->request_params["METHOD_TYPE"] = $this->method_request;
        }

        public function get($route, $func)
        { 
            $this->request_params["body"] = $this->treat_param($route, $_GET["aplication"]); //tem que vir antes do route ser reescrevido pelo método Route
            $route = $this->Route($route, $_GET["aplication"]);

            if($this->method_request == 'GET' AND $route == $this->simple_route_aplication){
                $func($this->request_params, $this->response_params);
            }
        }

        public function post($route, $func)
        { 

            if($this->method_request == 'POST' AND $route == $this->simple_route_aplication){
                $func($this->request_params, $this->response_params);
            }
        }

        public function put()
        {
            if($this->method_request == 'PUT'){
                return json_encode('PUT');
            }
        }

        public function delete()
        {
            if($this->method_request == 'DELETE'){
                return json_encode('DELETE');
            }
        }
    }