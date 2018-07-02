<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    function __construct() {
        parent::__construct();
        if ($this->session->userdata('is_login')) {
            redirect('Admin');
        }
        $this->load->model('user_model');
        $this->load->model('role_model');
    }

    public function index($param = '') {
        if ($param == 'error') {
            $param = 'Username atau password salah!';
        }
        $data = array("title" => "Login", "message" => $param, "base_url" => base_url());
        $this->load->view('login', $data);
    }

    public function do_login() {
        $data = $this->input->post(null, true);
        $is_login = $this->user_model->cekLogin($data['username'], hash('sha512',$data['password']));
        $role = $this->role_model->getById($is_login->role_id);
        if ($is_login) {
            $session_set = array(
                'is_login' => true,
                'nama' => $is_login->name,
                'id_user' => $is_login->id,
                'username' => $is_login->username,
                'role_id' => $is_login->role_id,
                'role_name' => $role->name
            );
            $this->session->set_userdata($session_set);
            redirect('admin');
        } else {
            redirect('login/index/error');
        }
    }

}
