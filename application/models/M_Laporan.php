<?php
class M_Laporan extends CI_Model
{
    public function get_current_saldo()
    {
        $this->db->select('saldo');
        $this->db->from('tb_kas');
        $this->db->where('id_kas', 1);
        return $this->db->get()->row()->saldo;
    }

    public function get_total_kas_masuk($periode = null)
    {
        if ($periode) {
            $this->db->where('MONTH(tanggal)', $periode['bulan']);
            $this->db->where('YEAR(tanggal)', $periode['tahun']);
        }
        $this->db->select_sum('jumlah');
        $this->db->from('tb_kasmasuk');
        return $this->db->get()->row()->jumlah;
    }

    public function get_total_siswa($tahun = null)
    {
        if ($tahun) {
            $this->db->where('YEAR(tanggal_masuk)', $tahun);
        }
        $this->db->from('tb_siswa');
        return $this->db->count_all_results();
    }

    public function update_saldo()
    {
        $this->db->select_sum('jumlah');
        $this->db->from('tb_kasmasuk');
        $total_kas_masuk = $this->db->get()->row()->jumlah;

        $this->db->select_sum('jumlah');
        $this->db->from('tb_kasmasuk_histori');
        $total_kasmasuk_histori = $this->db->get()->row()->jumlah;

        $this->db->select_sum('nominal');
        $this->db->from('tb_kaskeluar');
        $total_kaskeluar = $this->db->get()->row()->nominal;

        $this->db->select_sum('nominal');
        $this->db->from('tb_kasmasuk_luar');
        $total_kasmasuk_luar = $this->db->get()->row()->nominal;

        $new_saldo = $total_kas_masuk + $total_kasmasuk_histori + $total_kasmasuk_luar - $total_kaskeluar;

        $this->db->where('id_kas', 1);
        $this->db->update('tb_kas', ['saldo' => $new_saldo]);
    }
}
