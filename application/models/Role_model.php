<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Role_model extends CI_Model {

    private $_table = 'm_role';

    public function getAll() {
        $data = $this->db->get($this->_table)->result_array();

        return $data;
    }

    public function getById($id) {
        $data = $this->db->get_where($this->_table, array('id' => $id))->row();

        return $data;
    }

    public function save($data) {
        $arr = array(
            'name' => $data['name']
        );
        return $this->db->insert($this->_table, $arr);
    }

    public function update($data) {
        $arr = array(
            'name' => $data['name']
        );

        return $this->db->update($this->_table, $arr, array('id' => $data['id']));
    }

    function delete($id) {
        $this->db->trans_begin();

        $this->db->where('id', $id);
        $this->db->delete($this->_table);

        if ($this->db->trans_status() === false) {
            $this->db->rollback();
            return false;
        } else {
            $this->db->trans_complete();
            return true;
        }
    }

    public function getPrivilege($id) {
        $data = $this->db->get_where('rolehasmenu', array('role_id' => $id))->result_array();

        return $data;
    }

    public function cekPrivilege($role_id, $menu_id) {
        $data = $this->db->get_where('rolehasmenu', array('role_id' => $role_id, 'menu_id' => $menu_id))->row_array();

        return $data;
    }

    public function updatePrivilege($idUpdate, $dataUpdate) {
        return $this->db->update('rolehasmenu', $dataUpdate, $idUpdate);
    }

    public function createPrivilege($data) {
        return $this->db->insert('rolehasmenu', $data);
    }

}
