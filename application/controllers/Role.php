<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Role extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('is_login')) {
            redirect('login');
        }
        $this->session->set_userdata('menu', 'Privilege Management');
        $this->session->set_userdata('sub_menu', '');
        $this->load->model('role_model');
        $this->load->model('menu_model');
    }

    public function index() {
        if (!$this->general->privilege_check('role', 'read')) {
            $this->general->no_access();
        }
        $data = array('title' => 'Role');
        $this->template->view('role', $data);
    }

    public function get_data() {
        if (!$this->general->privilege_check('role', 'read')) {
            $this->general->no_access();
        }
        $data = $this->role_model->getAll();
        $arr["data"] = array();
        $no = 1;
        foreach ($data as $value) {
            $action = '';
            if ($this->general->privilege_check('role', 'update')) {
                $action .= "<a class='btn btn-sm btn-success' href='role/privilege/" . $value['id'] . "' id='privilege' title='Privilege' ><i class='glyphicon glyphicon-pencil'></i> Privilege</a>&nbsp;";
                $action .= "<a class='btn btn-sm btn-primary' href='javascript:void(0)' id='edit' title='Edit' onclick='edit(\"" . $value['id'] . "\")'><i class='glyphicon glyphicon-pencil'></i> Ubah</a>&nbsp;";
            }
            if ($this->general->privilege_check('role', 'delete')) {
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
        if (!$this->general->privilege_check('role', 'create')) {
            $this->general->no_access();
        }
        $data = $this->input->post(null, true);

        $insert = $this->role_model->save($data);
        echo json_encode(array("status" => TRUE));
    }

    public function detail($id) {
        if (!$this->general->privilege_check('role', 'read')) {
            $this->general->no_access();
        }
        $data = $this->role_model->getById($id);

        echo json_encode($data);
    }

    public function update() {
        if (!$this->general->privilege_check('role', 'update')) {
            $this->general->no_access();
        }
        $data = $this->input->post(null, true);
        $update = $this->role_model->update($data);
        if ($update) {
            echo json_encode(array("status" => true));
        }
    }

    function delete($id) {
        if (!$this->general->privilege_check('role', 'delete')) {
            $this->general->no_access();
        }
        $send = $this->role_model->delete($id);
        if ($send) {
            echo json_encode(array("status" => TRUE));
        }
    }

    public function privilege($id) {
        if (!$this->general->privilege_check('role', 'update')) {
            $this->general->no_access();
        }
        $table = '';
        $role = $this->role_model->getById($id);
        $menu = $this->getMenu();
        foreach ($menu as $key => $value) {
            $table .= '<tr>';
            $table .= '<td><b>' . $value['name'] . '</b></td>';
            if (count($value['child']) > 0) {
                $table .= '<td><input id="' . $value['id'] . '-read" class="set-privilege" type="checkbox"></td>';
                $table .= '<td></td><td></td><td></td>';
            } else {
                $table .= '<td><input id="' . $value['id'] . '-read" class="set-privilege" type="checkbox"></td>';
                $table .= '<td><input id="' . $value['id'] . '-create" class="set-privilege" type="checkbox"></td>';
                $table .= '<td><input id="' . $value['id'] . '-update" class="set-privilege" type="checkbox"></td>';
                $table .= '<td><input id="' . $value['id'] . '-delete" class="set-privilege" type="checkbox"></td>';
            }

            $table .= '</tr>';
            foreach ($value['child'] as $k => $v) {
                $table .= '<tr>';
                $table .= '<td>' . $v['name'] . '</td>';
                $table .= '<td><input id="' . $v['id'] . '-read" class="set-privilege" type="checkbox"></td>';
                $table .= '<td><input id="' . $v['id'] . '-create" class="set-privilege" type="checkbox"></td>';
                $table .= '<td><input id="' . $v['id'] . '-update" class="set-privilege" type="checkbox"></td>';
                $table .= '<td><input id="' . $v['id'] . '-delete" class="set-privilege" type="checkbox"></td>';
                $table .= '</tr>';
            }
        }

        $data = array('id' => $id, 'role' => $role, 'title' => 'Role Privilege', 'table' => $table);
        $this->template->view('privilege', $data);
    }

    function getMenu() {
        $parent = $this->menu_model->getParent();
        $child = $this->menu_model->getChild();
        foreach ($parent as $key => $value) {
            $parent[$key]['child'] = array();
            foreach ($child as $k => $v) {
                if ($value['id'] == $v['parent']) {
                    array_push($parent[$key]['child'], $v);
                }
            }
        }
        return $parent;
    }

    function getPrivilege($id) {
        $data = $this->role_model->getPrivilege($id);

        echo json_encode($data);
    }

    function setPrivilege() {
        /*
         * id role
         * id menu
         */
        if (!$this->general->privilege_check('role', 'update')) {
            $this->general->no_access();
        }
        $data = $this->input->post(null, true);
        $exp_privilege = explode('-', $data['privilege']);

        $role_id = $data['role'];
        $menu_id = $exp_privilege[0];
        $crud = $exp_privilege[1];
        $nilai = $data['status'];

        $dataUpdate = array(
            $crud => $nilai
        );

        $idUpdate = array(
            'role_id' => $role_id,
            'menu_id' => $menu_id
        );
        $dataCreate = array(
            $crud => $nilai,
            'role_id' => $role_id,
            'menu_id' => $menu_id
        );

        if (count($this->role_model->cekPrivilege($role_id, $menu_id)) > 0) {
            $update = $this->role_model->updatePrivilege($idUpdate, $dataUpdate);
            if ($update) {
                echo json_encode(array("status" => true));
            }
        } else {
            $create = $this->role_model->createPrivilege($dataCreate);
            if ($create) {
                echo json_encode(array("status" => true));
            }
        }
    }

}
