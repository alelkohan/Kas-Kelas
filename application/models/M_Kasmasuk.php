<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_Kasmasuk extends CI_Model
{
    public function insert($data)
    {
        $this->db->insert('tb_kasmasuk', $data);
    }

    public function get_kasmasuk_by_periode($id_periode)
    {
        $this->db->where('id_periode', $id_periode);
        return $this->db->get('tb_kasmasuk')->result();
    }

    public function get_all_kasmasuk()
    {
        return $this->db->get('tb_kasmasuk_luar')->result();
    }

    public function get_kas_by_siswa($id_periode, $nama_siswa)
    {
        return $this->db->get_where('tb_kasmasuk', ['id_periode' => $id_periode, 'nama_siswa' => $nama_siswa])->row();
    }

    public function update($id_kasmasuk, $data)
    {
        $this->db->where('id_kasmasuk', $id_kasmasuk);
        $this->db->update('tb_kasmasuk', $data);
    }

    public function get_all_histori($id_periode)
    {
        $this->db->where('id_periode', $id_periode);
        return $this->db->get('tb_kasmasuk_histori')->result();
    }

    public function insert_kasmasuk_histori($data)
    {
        $this->db->insert('tb_kasmasuk_histori', $data);
    }

    public function delete_kas($id_kasmasuk)
    {
        $this->db->where('id_kasmasuk', $id_kasmasuk);
        $this->db->delete('tb_kasmasuk');
    }

    public function insert_kasmasuk($data)
    {
        return $this->db->insert('tb_kasmasuk_luar', $data);
    }

    public function update_kasmasuk($id, $data)
    {
        return $this->db->where('id_kasmasuk_luar', $id)->update('tb_kasmasuk_luar', $data);
    }

    public function delete_kasmasuk($id)
    {
        return $this->db->where('id_kasmasuk_luar', $id)->delete('tb_kasmasuk_luar');
    }
}
