<?php

    class ErrorResponse {

        public function __construct()
        {
            header('Access-Control-Allow-Origin: *');
            header('Content-Type: application/json');
            header('Access-Control-Allow-Methods: POST,GET,DELETE,PUT');
            header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');           
        }

        public function index()
        {
            $err = "Error 404 <br> Page Not Found.";
            echo json_encode(array("Error page" => $err));
        }
    }
    