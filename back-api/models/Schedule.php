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

        public function check_schedule($date,$sch)
        {
            //SELECT * FROM users INNER JOIN clients WHERE `users`.id_user = `clients`.id_user_fk AND `users`.id_user = :id
            $this->db->query("SELECT * FROM `schedules`, `appointments` WHERE dateApt = :dateApt AND `appointments`.id_sch_fk = `schedules`.`id_crn` AND `appointments`.id_sch_fk = :sch AND `appointments`.id_sch_fk IN(SELECT id_crn FROM `schedules`)");

            $this->db->bind(":dateApt", $date);
            $this->db->bind(":sch", $sch);
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

        public function get_schedules_available($data)
        {
            $this->db->query("SELECT DISTINCT(id_crn) as id, start_time as start, finish_time as end FROM `schedules`,`appointments` WHERE id_crn NOT IN (SELECT id_sch_fk from `appointments` WHERE dateApt = :date_app)");
            
            // bind the values
            $this->db->bind(":date_app", $data);
            $results = $this->db->resultSet();
            if($results){
                // for($i = 0; $i < count($results); $i++){
                //     if(date("H:i",$results[$i]['start']) < date("H:i")){
                //         unset($results[$i]);
                //     } 
                // }
                return false;
            } else {
                return false ;
            }
        }

        
    }