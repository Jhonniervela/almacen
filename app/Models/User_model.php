<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

    private $users = array();

    public function __construct() {
        parent::__construct();
        // Datos simulados en memoria
        $this->users = array(
            1 => array('id' => 1, 'name' => 'John Doe', 'email' => 'john.doe@example.com'),
            2 => array('id' => 2, 'name' => 'Jane Doe', 'email' => 'jane.doe@example.com')
        );
    }

    public function get_users() {
        return array_values($this->users);
    }

    public function get_user($id) {
        return isset($this->users[$id]) ? $this->users[$id] : null;
    }

    public function create_user($data) {
        $id = count($this->users) + 1;
        $data['id'] = $id;
        $this->users[$id] = $data;
        return $data;
    }

    public function update_user($id, $data) {
        if (isset($this->users[$id])) {
            $this->users[$id] = array_merge($this->users[$id], $data);
            return $this->users[$id];
        }
        return null;
    }

    public function delete_user($id) {
        if (isset($this->users[$id])) {
            unset($this->users[$id]);
            return true;
        }
        return false;
    }
}
