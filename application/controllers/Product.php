<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Product extends CI_Controller {
    private $id_user;

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('is_login')) {
            redirect('login');
        }
        $this->session->set_userdata('menu', 'Master Data');
        $this->session->set_userdata('sub_menu', 'Product');
        $this->load->model('product_model');
        
        $this->id_user = $this->session->userdata('id_user');
    }

    public function index() {
        if (!$this->general->privilege_check('product', 'read')) {
            $this->general->no_access();
        }
        $data = array('title' => 'Product');
        $this->template->view('product', $data);
    }

    public function get_data() {
        if (!$this->general->privilege_check('product', 'read')) {
            $this->general->no_access();
        }
        $data = $this->product_model->getAll();
        $arr["data"] = array();
        $no = 1;
        foreach ($data as $value) {
            $action = '';
            if ($this->general->privilege_check('product', 'update')) {
                $action .= "<a class='btn btn-sm btn-primary' href='javascript:void(0)' id='edit' title='Edit' onclick='edit(\"" . $value['id'] . "\")'><i class='glyphicon glyphicon-pencil'></i> Ubah</a>&nbsp;";
            }
            if ($this->general->privilege_check('product', 'delete')) {
                $action .= "<a class='btn btn-sm btn-danger' href='javascript:void(0)' id='hapus' title='Hapus' onclick='hapus(\"" . $value['id'] . "\")'><i class='glyphicon glyphicon-trash'></i> Hapus</a>";
            }
            array_push($arr["data"], array(
                "no" => $no,
                "name" => $value["name"],
                "action" => $action
            ));
            $no++;
        }
        echo json_encode($arr);
    }

    public function add() {
        if (!$this->general->privilege_check('product', 'create')) {
            $this->general->no_access();
        }
        
        $data = $this->input->post(null, true);
        $data['id_user'] = $this->id_user;

        $insert = $this->product_model->save($data);
        
        if($insert){
            echo json_encode(array("status" => TRUE));
        }        
    }

    public function detail($id) {
        if (!$this->general->privilege_check('product', 'read')) {
            $this->general->no_access();
        }
        $data = $this->product_model->getById($id);

        echo json_encode($data);
    }

    public function update() {
        if (!$this->general->privilege_check('product', 'update')) {
            $this->general->no_access();
        }
        
        $data = $this->input->post(null, true);
        $data['id_user'] = $this->id_user;
        
        $update = $this->product_model->update($data);
        if ($update) {
            echo json_encode(array("status" => true));
        }
    }

    function delete($id) {
        if (!$this->general->privilege_check('product', 'delete')) {
            $this->general->no_access();
        }
        
        $send = $this->product_model->delete($id, $this->id_user);
        if ($send) {
            echo json_encode(array("status" => TRUE));
        }
    }

}
