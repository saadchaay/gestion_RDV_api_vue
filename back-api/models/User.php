<?php

class User
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function register($data)
    {
        //create a query
        $this->db->query("INSERT INTO `users` VALUES (:ref, :fName, :lName, :email, :phone)");

        // bind the values
        $this->db->bind(":ref", $data["reference"]);
        $this->db->bind(":fName", $data["firstName"]);
        $this->db->bind(":lName", $data["lastName"]);
        $this->db->bind(":email", $data["email"]);
        $this->db->bind(":phone", $data["phone"]);

        // check execution the query
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function login($ref)
    {
        $this->db->query("SELECT * FROM `users`");

        if ($this->db->execute()) {
            $result = $this->db->resultSet();
            foreach ($result as $row) {
                if (password_verify($ref, $row->ref_user)) {
                    $user = $row;
                    break;
                }
            }
        }

        if (!empty($user)) {
            return $user;
        } else {
            return false;
        }
    }

    public function check_ref_user($ref)
    {
        $status = false;
        $this->db->query("SELECT * FROM `users`");

        if ($this->db->execute()) {
            $result = $this->db->resultSet();
            foreach ($result as $row) {
                if (password_verify($ref, $row->ref_user)) {
                    $status = true;
                    break;
                }
            }
        }
        return $status;
    }
}
