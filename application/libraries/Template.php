<?php

if (!defined('BASEPATH')) {
    exit('No Direct Script access allowed');
}

class Template {

    private $_obj = null;

    function __construct() {
        $this->_obj = &get_instance();
        $this->_obj->load->model('menu_model');
    }

    function view($view, $data = array()) {
        $menu = array('menu' => $this->getMenu());
        $this->_obj->load->view('header', $data);
        $this->_obj->load->view('navigation', $menu);
        $this->_obj->load->view($view, $data);
        $this->_obj->load->view('footer');
    }

    function getMenu() {
        $role_id = $this->_obj->session->userdata('role_id');
        $parent = $this->_obj->menu_model->getParentByRole($role_id);
        $child = $this->_obj->menu_model->getChildByRole($role_id);
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

}
