<?php

    namespace elevenstack\expressphp;

    class TreatmentRoute
    {   
        public function Route($route, $request)
        {
            $params = [];

            if($route == '/' OR $route == ''){
                return $route = '/';
            }else{
                $r_explode = array_filter(explode('/', $route));
                $splash = explode('/:/', $route);
                $s_arr = str_split($splash[0]);
                if($s_arr[0].$s_arr[1] == '/:'){
                    $root = true;
                }else{
                    $root = false;
                }

                if(count($r_explode) > 1){
                    $verification = str_split($route);
                    $term = ':';

                    if(in_array($term, $verification)){
                        $array_route = str_split($route);
                        $array_route[0] = '';
                        $unified = implode('', $array_route);
                        $route = rtrim($unified);

                        $params = $this->treat_param($route, $request);
                        $implode = ''; //preciso das chaves
                        for($i = 0; $i < count($params); $i++){
                            $implode .= key($params);
                            next($params);
                        }
                        
                        $verify = str_split($implode);

                        if(in_array(':', $verify)){
                            $route_without_param = $this->takeOf_param($route);

                            foreach($params as $key){
                                $route_without_param .= $key.'/';
                            }

                            $r_array = array_filter(explode('/', $route_without_param));
                            $text = implode('/', $r_array);
                            return $route = $text;
                        }else{
                            return $route = $this->takeOf_param($route);
                        }
                    }else{
                        $array_route = str_split($route);
                        $array_route[0] = '';
                        $unified = implode('', $array_route);
                        return $route = rtrim($unified);
                    }
                }else{
                    return $route = $r_explode[1];
                }
            }
        }

        public function takeof_doubleDotos($parametros)
        {
            for($j = 0; $j < count($parametros); $j++){
                $new_key = preg_replace('/:/', '', key($parametros));
                next($parametros);
    
                $values = array_values($parametros);
                $parametros[$new_key] = $values[$j];
            }
    
            foreach($parametros as $chave => $valor){
                if(preg_match('/:/', $chave)){
                    unset($parametros[$chave]);
                }
            }

            return $parametros;
        }

        public function treat_param($param, $request_param)
        {
            $param_array = str_split($param);
            if($param_array[0] == '/'){
                $param_array[0] = '';

                $param = implode('', $param_array);
            }

            $string = $param;
            $string_array = explode('/', $string);

            $request = $request_param;
            $request_array = explode('/', $request);

            if(count($string_array) == count($request_array)){
                $param = '';
                $valor = '';
            
                foreach($string_array as $key => $value){
                    if(preg_match('/:/', $value)){
                        $valor = $value;
                    }
                    
                    $param .= array_search($valor, $string_array);
                    $param_array = str_split($param);
                }
            
                $parametros = [];
            
                for($i = 0; $i < count($param_array); $i++){
                    $parametros[$string_array[$param_array[$i]]] = $request_array[$param_array[$i]];
                }
            
                return $parametros;
            }else{
                return false;
            }
        }

        public function takeOf_param($route)
        {
            $string = $route;
            $string_array = explode('/', $string);

            $count = count(array_filter($string_array));

            $verify = str_split($string);
            if(in_array(':', $verify)){
                for ($i=0; $i <= $count; $i++) { 
                    if(preg_match('/:/', $string_array[$i])){
                        unset($string_array[$i]);
                    }
                }

                $route = implode('/', $string_array).'/';

                return $route;
            }else{
                return $string;
            }
        }

        public function get_q($queries)
        {
            $explode = explode('&', $queries);
            $implode = implode(' ', $explode);
            $explode_bar = explode('/?', $implode);
            $implode_string = implode(' ', $explode_bar);
            $queries_array = explode(' ', $implode_string);

            $queries_string = [];

            foreach($queries_array as $chave){
                $separete = explode('=', $chave);
                $queries_string[$separete[0]] = $separete[1];
            }

            return $queries_string;
        }
    }