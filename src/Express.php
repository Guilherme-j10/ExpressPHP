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
            $this->params($route, $_GET["aplication"]); //tem que vir antes do route ser reescrevido pelo método Route

            $route = $this->Route($route, $_GET["aplication"]); 

            if($this->method_request == 'GET' AND $route == $this->simple_route_aplication){
                $func($this->request_params, $this->response_params);
            }
        }

        public function post($route, $func)
        { 
            $this->params($route, $_GET["aplication"]);

            $route = $this->Route($route, $_GET["aplication"]);

            if($this->method_request == 'POST' AND $route == $this->simple_route_aplication){
                $body_request = file_get_contents("php://input");
                $this->request_params["body"] = json_decode($body_request, true);
                
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

        public function params($route, $request)
        {
            $this->request_params["params"] = $this->treat_param($route, $request); 
            $this->request_params["params"] = $this->takeof_doubleDotos($this->request_params["params"]);
        }
    }