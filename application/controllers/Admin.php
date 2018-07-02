<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

    function __construct() {
        parent::__construct();
        if (!$this->session->userdata('is_login')) {
            redirect('login');
        }
        $this->session->set_userdata('menu', 'Home');
        $this->session->set_userdata('sub_menu', '');
    }

    public function index() {
        $data = array();
        $this->template->view('dashboard', $data);
    }

}
