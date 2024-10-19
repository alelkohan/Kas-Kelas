<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_Kaskeluar extends CI_Model
{
    public function get_kaskeluar_by_periode($id_periode)
    {
        $this->db->where('id_periode', $id_periode);
        return $this->db->get('tb_kaskeluar')->result();
    }

    public function get_kaskeluar_by_id($id_kaskeluar)
    {
        $this->db->select('*');
        $this->db->from('tb_kaskeluar');

        $this->db->where('id_kaskeluar', $id_kaskeluar);

        $query = $this->db->get();

        return $query->row();
    }

    public function insert_kaskeluar($data)
    {
        return $this->db->insert('tb_kaskeluar', $data);
    }

    public function update_kaskeluar($id_kaskeluar, $data)
    {
        $this->db->where('id_kaskeluar', $id_kaskeluar);
        return $this->db->update('tb_kaskeluar', $data);
    }

    public function delete_kaskeluar($id_kaskeluar)
    {
        $this->db->where('id_kaskeluar', $id_kaskeluar);
        return $this->db->delete('tb_kaskeluar');
    }
}
