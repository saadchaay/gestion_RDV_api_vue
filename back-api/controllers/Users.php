<?php

    class Users {
        private $model;

        public function __construct()
        {
            header('Access-Control-Allow-Origin: *');
            header('Content-Type: application/json');
            header('Access-Control-Allow-Methods: POST,GET,DELETE,PUT');
            header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');           
            $this->model = new User();
        }

        public function register()
        {
            $data = json_decode(file_get_contents("php://input"));

            
            if($_SERVER["REQUEST_METHOD"] == "POST"){

                $ref = $this->generate_ref();

                while ($this->model->check_ref_user($ref)) {
                    $ref = $this->generate_ref();
                }

                $success = [
                    "ref" => $ref,
                    "message" => ""
                ];
    
                $ref_hashed = password_hash($ref, PASSWORD_DEFAULT);

                $user = [
                    "reference" => $ref_hashed,
                    "firstName" => $data->firstName,
                    "lastName" => $data->lastName,
                    "email" => $data->email,
                    "phone" => $data->phone,
                ];
                if($this->model->register($user)){
                    $success["message"] = "User has been Registration Successfully.";
                    echo json_encode(array("Success" => $success["message"], "reference" => $success["ref"]));
                } else {
                    echo json_encode(array( "Error" => "error."));
                }
            }
        }

        public function login()
        {
            $data = json_decode(file_get_contents("php://input"));

            $errors = [
                "ref" => "",
                "message" => ""
            ];

            $success = [
                "ref" => "",
                "message" => ""
            ];

            if($_SERVER["REQUEST_METHOD"] == "POST"){
                
                if(empty($data->reference)){
                    $errors["message"] = "The reference is empty, Try again!";
                }elseif(strlen($data->reference) < 10){
                    $errors["message"] = "The reference must contain at least 10 characters!";
                }

                if(empty($errors["message"])){
                    if($this->model->check_ref_user($data->reference)){
                        $user = $this->model->login($data->reference);
                        $success["message"] = "User has been Login Successfully.";
                        $success["ref"] = $data->reference;
                        echo json_encode(array("user" => $user, "success" => $success["message"], "reference" => $success["ref"]));
                    } else {
                        $errors["message"] = "This reference doesn't exists, try again!";
                        echo json_encode(array("Error" => $errors["message"]));
                    }
                } else {
                    echo json_encode(array("Error" => $errors["message"]));
                }
            }
        }

        public function generate_ref()
        {
            $characters = '0123456789qwer67tyuio23pasdfgh458jklzxcvbnm19';
            $ch_length = strlen($characters);
            $random_ref = "";
            for ($i=0; $i < 7; $i++) { 
                $random_ref .= $characters[rand(0, $ch_length - 1)];
            }
            return $random_ref ;
        }
    }
