<?php

    class Schedule {

        private $db;

        public function __construct()
        {
            $this->db = new Database() ;
        }

        public function get_all_CRN()
        {
            $this->db->query("SELECT * FROM `schedules`");

            if($this->db->execute()){
                return $this->db->resultSet();
            } else {
                return false ;
            }
        }

        public function check_schedule($date)
        {
            //SELECT * FROM users INNER JOIN clients WHERE `users`.id_user = `clients`.id_user_fk AND `users`.id_user = :id
            $this->db->query("SELECT * FROM `schedules` INNER JOIN `appointments` 
                            WHERE `appointments`.id_sch_fk = `schedules`.id_crn AND dateApt = :dateApt");

            $this->db->bind(":dateApt", $date);
            $this->db->execute();
            
            if($this->db->rowCount() > 0){
                return true ;
            } else {
                return false ;
            }
        }

        public function create_schedule($data)
        {
            $this->db->query("INSERT INTO `schedules` VALUES ('', :starting, :finished, :duration)");
            
            // bind the values
            $this->db->bind(":starting", $data["starting"]);
            $this->db->bind(":finished", $data["finished"]);
            $this->db->bind(":duration", $data["duration"]); 
            
            if($this->db->execute()){
                return true ;
            } else {
                return false ;
            }
        }

        
    }