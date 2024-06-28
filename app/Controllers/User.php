<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->helper('url');
        $this->load->library('form_validation');
    }

    public function index() {
        $users = $this->User_model->get_users();
        echo json_encode($users);
    }

    public function view($id) {
        $user = $this->User_model->get_user($id);
        if (empty($user)) {
            show_404();
        }
        echo json_encode($user);
    }

    public function create() {
        $data = json_decode(file_get_contents('php://input'), true);
        $new_user = $this->User_model->create_user($data);
        echo json_encode($new_user);
    }

    public function update($id) {
        $data = json_decode(file_get_contents('php://input'), true);
        $updated_user = $this->User_model->update_user($id, $data);
        if ($updated_user) {
            echo json_encode($updated_user);
        } else {
            show_404();
        }
    }

    public function delete($id) {
        if ($this->User_model->delete_user($id)) {
            echo json_encode(['status' => 'success']);
        } else {
            show_404();
        }
    }
}
