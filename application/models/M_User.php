<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_User extends CI_Model
{
    public function get_all_user()
    {
        return $this->db->get('tb_user')->result();
    }

    public function get_user_by_id($id)
    {
        return $this->db->get_where('tb_user', ['id' => $id])->row();
    }

    public function get_all_bendahara()
    {
        $this->db->where('peran', 'bendahara');

        $query = $this->db->get('tb_user');
        return $query->result();
    }

    public function insert_user($data)
    {
        return $this->db->insert('tb_user', $data);
    }

    public function update_user($data)
    {
        $this->db->where('id_user', $data['id_user']);
        $this->db->update('tb_user', $data);
    }

    public function delete_user($id)
    {
        $this->db->where('id_user', $id);
        $this->db->delete('tb_user');
    }

    public function update_password($username, $new_password)
    {
        $this->db->where('username', $username);
        return $this->db->update('tb_user', ['password' => $new_password]);
    }
}
