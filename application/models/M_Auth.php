<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_Auth extends CI_Model
{
    public function check_login($username, $password)
    {
        $this->db->where('username', $username);
        $this->db->where('password', $password);
        $query = $this->db->get('tb_user');

        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }
    }
}
