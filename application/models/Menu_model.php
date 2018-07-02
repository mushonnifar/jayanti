<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Menu_model extends CI_Model {

    private $_table = 'm_menu';

    public function save($data) {
        $arr = array(
            'name' => $data['name'],
            'parent' => $data['parent'],
            'link' => $data['link'],
            'icon' => $data['icon']
        );
        return $this->db->insert($this->_table, $arr);
    }

    public function update($data) {
        $arr = array(
            'name' => $data['name'],
            'parent' => $data['parent'],
            'link' => $data['link'],
            'icon' => $data['icon']
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

    public function getAll() {
        $data = $this->db->get($this->_table)->result_array();

        return $data;
    }

    public function getById($id) {
        $data = $this->db->get_where($this->_table, array('id' => $id))->row();

        return $data;
    }

    public function getByRoleId($id) {

        $data = $this->db->get_where($this->_table, array('id' => $id))->result_array();

        return $data;
    }

    public function getParent() {
        $data = $this->db->get_where($this->_table, array('parent' => 0))->result_array();
        return $data;
    }

    public function getChild() {
        $data = $this->db->get_where($this->_table, array('parent !=' => 0))->result_array();
        return $data;
    }

    public function getParentByRole($role_id) {
        $this->db->select('tb1.*');
        $this->db->from($this->_table . ' tb1');
        $this->db->join('m_rolehasmenu tb2', 'tb1.id = tb2.menu_id');
        $this->db->where('tb1.parent', 0);
        $this->db->where('tb2.`read`', 'y');
        $this->db->where('tb2.role_id', $role_id);
        return $this->db->get()->result_array();
    }

    public function getChildByRole($role_id) {
        $this->db->select('tb1.*');
        $this->db->from($this->_table . ' tb1');
        $this->db->join('m_rolehasmenu tb2', 'tb1.id = tb2.menu_id');
        $this->db->where('tb1.parent !=', 0);
        $this->db->where('tb2.`read`', 'y');
        $this->db->where('tb2.role_id', $role_id);
        return $this->db->get()->result_array();
    }

}
