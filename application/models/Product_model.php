<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Product_model extends CI_Model {

    private $_table = 'm_product';

    public function save($data) {
        $arr = array(
            'name' => $data['name'],
            'created_by' => $data['id_user']
        );
        return $this->db->insert($this->_table, $arr);
    }

    public function update($data) {
        $arr = array(
            'name' => $data['name'],
            'updated_by' => $data['id_user']
        );

        return $this->db->update($this->_table, $arr, array('id' => $data['id']));
    }

    function delete($id, $id_user) {
        $arr = array(
            'isactive' => 0,
            'updated_by' => $id_user
        );

        return $this->db->update($this->_table, $arr, array('id' => $id));
    }

    public function getAll() {
        $data = $this->db->get_where($this->_table, array('isactive' => 1))->result_array();

        return $data;
    }

    public function getById($id) {
        $data = $this->db->get_where($this->_table, array('id' => $id, 'isactive' => 1))->row();

        return $data;
    }

}
