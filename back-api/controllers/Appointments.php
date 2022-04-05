<?php

    class Appointments {

        private $appointment ;
        private $schedule ;
        private $user ;

        public function __construct()
        {
            header('Access-Control-Allow-Origin: *');
            header('Content-Type: application/json');
            header('Access-Control-Allow-Methods: POST,GET,DELETE,PUT');
            header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');           
            $this->appointment = new Appointment();
            $this->schedule = new Schedule();
            $this->user = new User();
        }

        public function all()
        {
            $data = json_decode(file_get_contents("php://input"));

            $msg = [
                "success" => "",
                "error" => ""
            ];

            if($_SERVER["REQUEST_METHOD"] == "GET"){
                $appointments = $this->appointment->get_appointments(); 
                if(!empty($appointments)){
                    $msg["success"] = "Here's Your all Appointments.";
                    echo json_encode($appointments);
                } else {
                    $msg["error"] = "Doesn't exists any Appointment!";
                    echo json_encode(array("Error" => $msg["error"]));
                }
            }elseif($_SERVER["REQUEST_METHOD"] == "POST"){

                if($this->Ref_hashed($data->reference)){
                    $appointments = $this->appointment->get_all_appointments($this->Ref_hashed($data->reference));
                    if(!empty($appointments)){
                        $msg["success"] = "Here's Your all Appointments.";
                        echo json_encode(array("Success" => $msg["success"], "Appointments" => $appointments));
                    } else {
                        $msg["error"] = "Doesn't exists any Appointment!";
                        echo json_encode(array("Error" => $msg["error"]));
                    }
                } else {
                    $msg["error"] = "The user doesn't exists!";
                    echo json_encode(array("Error" => $msg["error"]));
                }
                
            }else {
                $msg["error"] = "Request Error!";
                echo json_encode(array("Error" => $msg["error"]));
            }
        }

        public function single()
        {
            $data = json_decode(file_get_contents("php://input"));

            if($_SERVER["REQUEST_METHOD"] == "GET"){
                $appointment = $this->appointment->get_appointment_by_ID($data->id);
                if(!empty($appointment)){
                    echo json_encode($appointment);
                } else {
                    echo json_encode(array("Error" => "This Appointment doesn't exists!"));
                }
            }else {
                echo json_encode(array("Error" => "Request Error!"));
            }
        }

        public function create()
        {
            $data = json_decode(file_get_contents("php://input"));

            $msg = [
                "success" => "",
                "error" => ""
            ];

            if($_SERVER["REQUEST_METHOD"] == "POST"){

                if(empty($data->sjtApt) || empty($data->dateApt) || empty($data->ref_user) || empty($data->schedule))
                {
                    $msg["error"] = "Some field is empty, try again!";
                    echo json_encode(array("Error" => $msg["error"]));
                } else {

                    //check schedule
                    if($this->schedule->check_schedule($data->dateApt)){
                        $msg["error"] = "This schedules isn't available!";
                        echo json_encode(array("Error" => $msg["error"]));
                    } else {
                        $ref_hashed = $this->user->login($data->ref_user)->ref_user ;
                        // save appointment
                        $apt = [
                            "sjtApt" => $data->sjtApt,
                            "dateApt" => $data->dateApt,
                            "refUser" => $ref_hashed,
                            "schedule" => $data->schedule
                        ];

                        if($this->appointment->create_apt($apt)){
                            $msg["success"] = "Create appointment has been successfully.";
                            echo json_encode(array("Success" => $msg["success"]));
                        }
                    }
                } 
            }
        }

        public function edit()
        {
            $data = json_decode(file_get_contents("php://input"));

            if($_SERVER["REQUEST_METHOD"] == "PATCH"){

                $appointment = [
                    "id_apt" => $data->id_apt,
                    "schedule" => $data->schedule,
                    "sjtApt" => $data->sjtApt,
                    "dateApt" => $data->dateApt,
                    "success" => "",
                    "error" => ""
                ];

                // check this appointment is already exists to update it
                if(($this->appointment->get_appointment_by_ID($data->id_apt))){

                    if(empty($data->sjtApt) || empty($data->dateApt)  || empty($data->schedule)){
                        $appointment["error"] = "Some field is empty, try again!";
                        echo json_encode(array("Error" => $appointment["error"]));
                    }else {
                        // check the new schedule
                        if($this->schedule->check_schedule($data->dateApt)){
                            $appointment["error"] = "This schedules isn't available!";
                            echo json_encode(array("Error" => $appointment["error"]));
                        } elseif($this->appointment->update_apt($appointment)) {
                            $appointment["success"] = "Your appointment has been updated successfully.";
                            echo json_encode(array("Success" => $appointment["success"]));
                        }
                    }
                } else {
                    $appointment["error"] = "This appointment doesn't exists!";
                    echo json_encode(array("Error" => $appointment["error"]));
                }
            }
        }
        public function cancel()
        {
            $data = json_decode(file_get_contents("php://input"));
            
            if($_SERVER["REQUEST_METHOD"] == "DELETE"){

                if(($this->appointment->get_appointment_by_ID($data->id_apt))){
                    if($this->appointment->delete_apt($data->id_apt)){
                        $success = "Your appointment has been deleted successfully.";
                        echo json_encode(array("Success" => $success));
                    } else {
                        $error = "Failed delete your appointment!";
                        echo json_encode(array("Error" => $error));
                    }
                } else {
                    $error = "This appointment doesn't exists!";
                    echo json_encode(array("Error" => $error));
                }
            }

        }

        // Insertion schedules 
        public function save_schedule()
        {
            $start = date("H:i", strtotime("18:00"));
            $end = date("H:i", strtotime("20:00"));

            $schedule = [
                "starting" => $start,
                "finished" => $this->next_schedule($start),
                "duration" => 30
            ];
            while ($schedule["starting"] != $end) {
                $this->schedule->create_schedule($schedule);
                $schedule["starting"] = $this->next_schedule($schedule["starting"]);
                $schedule["finished"] = $this->next_schedule($schedule["finished"]);
            }
            echo "Done";
        }

        public function next_schedule($start)
        {
            $arr_time = explode(":",$start);
            $string_time = ($arr_time[0]*3600) + ($arr_time[1]*60) + (30*60);
            $schedule = gmdate("H:i", $string_time);
            return $schedule;
        }

        public function Ref_hashed($ref)
        {
            $user = $this->user->login($ref);
            if(!empty($user)){
                return $user->ref_user ;
            } else {
                return false ;
            }
        }
    }