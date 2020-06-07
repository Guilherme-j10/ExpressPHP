<?php

    namespace src;

    class Functions{
        public function return_response($value, $json = true){
            switch ($json) {
                case true:
                    echo json_encode($value);
                break;
                case false:
                    echo $value;
                break;
                default:
                    echo 'invalid value';
                break;
            }
        }
    }