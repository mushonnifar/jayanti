<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class User_model extends CI_Model {

    private $_table = 'm_user';

    public function save($data) {
        $cek = $this->db->select('id')->where('username', $data['username'])->get($this->_table)->num_rows();

        $nilai = array(
            'name' => $data['nama'],
            'username' => $data['username'],
            'password' => hash('sha512', $data['password']),
            'role_id' => $data['role_id']
        );
        return $this->db->insert($this->_table, $nilai);
    }

    public function update($data) {
        $arr = array(
            'name' => $data['nama'],
            'username' => $data['username'],
            'role_id' => $data['role_id']
        );

        if ($data['password'] != '') {
            $arr['password'] = hash('sha512', $data['password']);
        }

        return $this->db->update($this->_table, $arr, array('id' => $data['id_user']));
    }

    function get_all() {
        $this->db->select('master_user.id, master_user.name as nama_user, master_user.username, master_role.name as nama_role');
        $this->db->from($this->_table);
        $this->db->join('master_role', 'master_role.id = master_user.role_id', 'left');
//        $this->db->where('master_user.id !=', 1);
        return $this->db->get()->result_array();
    }

    function get_detail($id) {
        $this->db->where('id', $id);
        return $this->db->get($this->_table)->row_array();
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

    function cekLogin($username, $password) {
        $data = $this->db->get_where($this->_table, array(
                    'username' => $username,
                    'password' => $password
                ))->row();
        return $data;
    }

}
