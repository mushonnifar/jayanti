<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/* ---------------------------------------------------------------------
  Class privilege ,generate all request linked to the access controll
  ---------------------------------------------------------------------- */

class General {

    private $obj = NULL;

    function __construct() {
        $this->obj = & get_instance();
    }

    function privilege_check($menu, $action) {
        $sql = "SELECT
                            *
                    FROM
                            m_user tb1
                    JOIN m_rolehasmenu tb3 ON tb1.role_id = tb3.role_id
                    JOIN m_menu tb4 ON tb3.menu_id = tb4.id
                    WHERE
                            tb1.id =" . $this->obj->session->userdata('id_user') . "
                    AND tb4.`link` = '" . $menu . "'
                    AND tb3.`" . $action . "` = 'y'";
        $q = $this->obj->db->query($sql);
        if ($q->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function no_access() {
        redirect('no_access');
    }

}
