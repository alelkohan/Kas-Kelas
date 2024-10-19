<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_Siswa extends CI_Model
{
    public function get_all_siswa()
    {
        return $this->db->get('tb_siswa')->result();
    }

    public function get_siswa_by_id($id)
    {
        return $this->db->get_where('tb_siswa', ['id' => $id])->row();
    }

    public function insert_siswa($data)
    {
        return $this->db->insert('tb_siswa', $data);
    }

    public function update_siswa($data)
    {
        $this->db->where('id_siswa', $data['id_siswa']);
        $this->db->update('tb_siswa', $data);
    }

    public function update_status($nama_siswa, $status)
    {
        $this->db->where('nama_siswa', $nama_siswa);
        $this->db->update('tb_siswa', ['status' => $status]);
    }

    public function delete_siswa($id)
    {
        return $this->db->where('id', $id)->delete('tb_siswa');
    }
}
