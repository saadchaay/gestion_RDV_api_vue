<?php

    class Appointment {

        private $db ;

        public function __construct()
        {
            $this->db = new Database();
        }

        public function get_appointments()
        {
            $this->db->query("SELECT * FROM `appointments`");

            if($this->db->execute()){
                return $this->db->resultSet();
            } else {
                return false ;
            }
        }

        public function get_all_appointments($ref)
        {
            $this->db->query("SELECT * FROM `appointments` INNER JOIN `schedules` WHERE ref_user_fk = :ref AND `appointments`.`id_sch_fk` = `schedules`.`id_crn` ORDER BY id_apt DESC");
            $this->db->bind(":ref", $ref);

            if($this->db->execute()){
                return $this->db->resultSet();
            } else {
                return false ;
            }
        }

        public function get_appointment_by_ID($id)
        {
            $this->db->query("SELECT * FROM `appointments` WHERE id_apt = :id");

            $this->db->bind(":id", $id);

            if($this->db->execute()){
                return $this->db->single();
            } else {
                return false ;
            }
        }

        public function create_apt($apt) 
        {
            //create a query
            $this->db->query("INSERT INTO `appointments` VALUES ('', :sjtApt, :dateApt, :ref_user, :schedule)");
            
            // bind the values
            $this->db->bind(":sjtApt", $apt["sjtApt"]);
            $this->db->bind(":dateApt", $apt["dateApt"]);
            $this->db->bind(":ref_user", $apt["refUser"]); 
            $this->db->bind(":schedule", $apt["schedule"]); 

            // check execution the query
            if($this->db->execute()){
                return true;
            } else {
                return false;
            }
        }

        public function update_apt($apt)
        {
            $this->db->query("UPDATE `appointments` SET `sujetApt`=:sjtApt, `dateApt`=:dateApt, `id_sch_fk`=:schedule WHERE `id_apt` = :ID");
            
            // bind the values
            $this->db->bind(":sjtApt", $apt["sjtApt"]);
            $this->db->bind(":dateApt", $apt["dateApt"]);
            $this->db->bind(":schedule", $apt["schedule"]);
            $this->db->bind(":ID", $apt["id_apt"]);

            // check execution the query
            if($this->db->execute()){
                return true;
            } else {
                return false;
            }
        }

        public function delete_apt($id_apt)
        {
            $this->db->query("DELETE FROM `appointments` WHERE `id_apt` = :ID");

            $this->db->bind(":ID", $id_apt);

            if($this->db->execute()){
                return true ;
            } else {
                return false ;
            }
        }

        public function getLast_apt()
        {
            $this->db->query("SELECT id_apt FROM appointments ORDER BY id_apt DESC LIMIT 1");
            if($this->db->execute()){
                return $this->db->single();
            } else {
                return false;
            }
        }
    }