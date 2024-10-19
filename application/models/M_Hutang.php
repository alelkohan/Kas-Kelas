<?php
class M_Hutang extends CI_Model
{
    public function get_hutang($id_periode, $nama_siswa)
    {
        $this->db->where('id_periode', $id_periode);
        $this->db->where('nama_siswa', $nama_siswa);
        return $this->db->get('tb_hutang')->row();
    }

    public function get_all_hutang_by_periode($id_periode)
    {
        $this->db->where('id_periode', $id_periode);
        return $this->db->get('tb_hutang')->result();
    }

    public function insert_hutang($data)
    {
        return $this->db->insert('tb_hutang', $data);
    }

    public function update_hutang($id_hutang, $data)
    {
        $this->db->where('id_hutang', $id_hutang);
        return $this->db->update('tb_hutang', $data);
    }

    public function delete_hutang($id_periode, $nama_siswa)
    {
        $this->db->where('id_periode', $id_periode);
        $this->db->where('nama_siswa', $nama_siswa);
        $this->db->delete('tb_hutang');
    }

    public function get_siswa_belum_bayar($id_periode, $tanggal_tenggat)
    {
        $this->db->select('nama_siswa');
        $this->db->where('id_periode', $id_periode);
        $result = $this->db->get('tb_kasmasuk')->result();

        $nama_siswa_terbayar = array_map(function ($row) {
            return $row->nama_siswa;
        }, $result);

        if (empty($nama_siswa_terbayar)) {
            $nama_siswa_terbayar = ['__NO_ONE__'];
        }

        $this->db->select('nama_siswa');
        $this->db->where_not_in('nama_siswa', $nama_siswa_terbayar);
        return $this->db->get('tb_siswa')->result();
    }
}
