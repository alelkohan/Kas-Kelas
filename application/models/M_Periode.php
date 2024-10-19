<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_Periode extends CI_Model
{
    public function get_all_periode()
    {
        return $this->db->get('tb_periode')->result();
    }
    public function get_periode($id_periode)
    {
        $this->db->where('id_periode', $id_periode);
        return $this->db->get('tb_periode')->row(); // pastikan ada data yang dikembalikan
    }

    public function get_siswa_status($id_periode)
    {
        // Menggunakan JOIN untuk menggabungkan tb_siswa, tb_kasmasuk, dan tb_hutang
        $this->db->select('s.id_siswa, s.nama_siswa, IFNULL(k.status, "Belum Bayar") as status, IFNULL(h.hutang, 0) as hutang');
        $this->db->from('tb_siswa s');

        // LEFT JOIN dengan tb_kasmasuk untuk mendapatkan status bayar
        $this->db->join(
            '(SELECT nama_siswa, "Sudah Bayar" as status FROM tb_kasmasuk WHERE id_periode = ' . $this->db->escape($id_periode) . ') k',
            's.nama_siswa = k.nama_siswa',
            'left'
        );

        // LEFT JOIN dengan tb_hutang untuk mendapatkan jumlah hutang
        $this->db->join(
            'tb_hutang h',
            's.nama_siswa = h.nama_siswa AND h.id_periode = ' . $this->db->escape($id_periode),
            'left'
        );

        $query = $this->db->get();
        return $query->result();
    }

    public function get_periode_by_id($id)
    {
        return $this->db->get_where('tb_periode', ['id_periode' => $id])->row();
    }

    public function insert_periode($data)
    {
        return $this->db->insert('tb_periode', $data);
    }

    public function update_periode($id, $data)
    {
        return $this->db->where('id_periode', $id)->update('tb_periode', $data);
    }

    public function delete_periode($id)
    {
        // Mulai transaksi
        $this->db->trans_start();

        $this->db->where('id_periode', $id)->delete('tb_kasmasuk');

        $this->db->where('id_periode', $id)->delete('tb_kaskeluar');

        $this->db->where('id_periode', $id)->delete('tb_hutang');

        $this->db->where('id_periode', $id)->delete('tb_kasmasuk_histori');

        $this->db->where('id_periode', $id)->delete('tb_periode');

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    public function search_periode($query)
    {
        $months = [
            'Januari' => '01',
            'Februari' => '02',
            'Maret' => '03',
            'April' => '04',
            'Mei' => '05',
            'Juni' => '06',
            'Juli' => '07',
            'Agustus' => '08',
            'September' => '09',
            'Oktober' => '10',
            'November' => '11',
            'Desember' => '12',
        ];

        list($month, $year) = explode(' ', $query);

        if (in_array($month, array_keys($months))) {
            $this->db->select('*');
            $this->db->from('tb_periode');
            $this->db->where('bulan', ucfirst(strtolower($month)));
            $this->db->where('tahun', $year); // Tahun dalam format teks
            $result = $this->db->get()->row();

            return $result;

            var_dump($result);
            die();
        }

        return null; // Jika bulan tidak valid
    }
}
