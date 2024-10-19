<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Periode extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->isLoggedIn();
        $this->load->model('M_Periode');
        $this->load->model('M_Siswa');
        $this->load->model('M_Kasmasuk');
        $this->load->model('M_Kaskeluar');
        $this->load->model('M_Laporan');
        $this->load->model('M_Hutang');
    }

    public function isLoggedIn()
    {
        if (!$this->session->userdata('logged_in')) {
            redirect('auth');
        }
    }

    public function index()
    {
        $data['periode'] = $this->M_Periode->get_all_periode();
        $data['saldo'] = $this->M_Laporan->get_current_saldo();
        $data['kasmasuk'] = $this->M_Kasmasuk->get_all_kasmasuk();
        $this->load->view('periode', $data);
    }

    public function detail($id_periode)
    {
        $periode = $this->M_Periode->get_periode($id_periode);
        $tanggal_saat_ini = new DateTime();

        $bulan_mapping = [
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
            'Desember' => '12'
        ];

        $bulan_periode = $bulan_mapping[$periode->bulan];
        $tahun_periode = $periode->tahun;

        $tanggal_awal_periode = new DateTime("{$tahun_periode}-{$bulan_periode}-01");
        $tanggal_akhir_periode = (clone $tanggal_awal_periode)->modify('last day of this month');
        $tenggat = $periode->tenggat;

        if ($tanggal_saat_ini < $tanggal_awal_periode) {
            $status_periode = 'Belum Mulai';
        } elseif ($tanggal_saat_ini >= $tanggal_awal_periode && $tanggal_saat_ini <= $tanggal_akhir_periode) {
            $status_periode = 'Aktif';
        } else {
            $status_periode = 'Kedaluwarsa';
        }

        if ($status_periode == 'Aktif') {
            $interval = new DateInterval("P{$tenggat}D");
            $tanggal_tenggat_terakhir = clone $tanggal_awal_periode;


            while ($tanggal_tenggat_terakhir < $tanggal_saat_ini) {
                $tanggal_tenggat_terakhir->add($interval);

                // Proses hanya jika tanggal tenggat terakhir terlewat
                $siswa_belum_bayar = $this->M_Hutang->get_siswa_belum_bayar($id_periode, $tanggal_tenggat_terakhir);

                foreach ($siswa_belum_bayar as $siswa) {
                    $hutang = $this->M_Hutang->get_hutang($id_periode, $siswa->nama_siswa);

                    if ($hutang) {

                        $tanggal_hutang_terakhir = new DateTime($hutang->tanggal_hutang_terakhir);

                        if ($tanggal_tenggat_terakhir > $tanggal_hutang_terakhir) {

                            $data_update = [
                                'hutang' => $hutang->hutang + $periode->jumlah_hutang,
                                'tanggal_hutang_terakhir' => $tanggal_tenggat_terakhir->format('Y-m-d')
                            ];

                            $this->M_Hutang->update_hutang($hutang->id_hutang, $data_update);

                            $this->session->set_flashdata('alert_reset', 'Status pembayaran sudah melewati tenggat waktu. Silakan tekan tombol Reset Status.');
                        }
                    } else {
                        $data_insert = [
                            'id_periode' => $id_periode,
                            'nama_siswa' => $siswa->nama_siswa,
                            'hutang' => $periode->jumlah_hutang,
                            'tanggal_hutang_terakhir' => $tanggal_tenggat_terakhir->format('Y-m-d')
                        ];
                        $this->M_Hutang->insert_hutang($data_insert);
                    }
                }
            }
        }

        // Ambil data hutang untuk ditampilkan di view
        $hutang_siswa = $this->M_Hutang->get_all_hutang_by_periode($id_periode);

        $data = [
            'periode' => $periode,
            'hutang_siswa' => $hutang_siswa,
            'status_periode' => $status_periode
        ];

        $data['periode'] = $this->M_Periode->get_periode_by_id($id_periode);
        $data['siswa'] = $this->M_Periode->get_siswa_status($id_periode);
        $data['kasmasuk'] = $this->M_Kasmasuk->get_kasmasuk_by_periode($id_periode);
        $data['kaskeluar'] = $this->M_Kaskeluar->get_kaskeluar_by_periode($id_periode);
        $data['saldo'] = $this->M_Laporan->get_current_saldo();
        $data['detail'] = $this->M_Kasmasuk->get_all_histori($id_periode);
        $this->load->view('detail_periode', $data);
    }

    public function bayar_kas()
    {
        $id_periode = $this->input->post('id_periode');
        $nama_siswa = $this->input->post('nama_siswa');
        $tanggal = $this->input->post('tanggal');
        $jumlah = $this->input->post('jumlah');
        $keterangan = $this->input->post('keterangan');

        $current_time = date('H:i:s');
        $datetime = $tanggal . ' ' . $current_time;

        $sudah_ada = $this->M_Kasmasuk->get_kas_by_siswa($id_periode, $nama_siswa);

        if ($sudah_ada) {
            $data_update = [
                'jumlah' => $sudah_ada->jumlah + $jumlah,
                'tanggal' => $datetime,
                'keterangan' => $keterangan
            ];
            $this->M_Kasmasuk->update($sudah_ada->id_kasmasuk, $data_update);
        } else {
            $data = [
                'id_periode' => $id_periode,
                'nama_siswa' => $nama_siswa,
                'tanggal' => $datetime,
                'jumlah' => $jumlah,
                'keterangan' => $keterangan
            ];
            $this->M_Kasmasuk->insert($data);
        }

        $periode = $this->M_Periode->get_periode($id_periode);
        $tanggal_saat_ini = new DateTime();

        $bulan_mapping = [
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
            'Desember' => '12'
        ];
        $bulan_periode = $bulan_mapping[$periode->bulan];
        $tahun_periode = $periode->tahun;

        $tanggal_awal_periode = new DateTime("{$tahun_periode}-{$bulan_periode}-01");
        $interval = new DateInterval("P{$periode->tenggat}D");
        $tanggal_tenggat_terakhir = clone $tanggal_awal_periode;
        $hutang = $this->M_Hutang->get_hutang($id_periode, $nama_siswa);

        if ($hutang) {
            if ($jumlah >= $hutang->hutang) {
                $this->M_Hutang->delete_hutang($id_periode, $nama_siswa);
            } else {
                while ($tanggal_tenggat_terakhir < $tanggal_saat_ini) {
                    $tanggal_tenggat_terakhir->add($interval);

                    $data_update = [
                        'hutang' => $hutang->hutang - $jumlah,
                        'tanggal_hutang_terakhir' => $tanggal_tenggat_terakhir->format('Y-m-d')
                    ];
                    $this->M_Hutang->update_hutang($hutang->id_hutang, $data_update);
                }
            }
        }

        $this->M_Laporan->update_saldo();

        $this->session->set_flashdata('message', $nama_siswa . ' membayar kas.');

        redirect('periode/detail/' . $this->input->post('id_periode'));
    }

    public function reset_status($id_periode)
    {
        $siswa_sudah_bayar = $this->M_Kasmasuk->get_kasmasuk_by_periode($id_periode);

        foreach ($siswa_sudah_bayar as $siswa) {
            $data_histori = [
                'id_periode' => $id_periode,
                'nama_siswa' => $siswa->nama_siswa,
                'jumlah' => $siswa->jumlah,
                'tanggal_bayar' => $siswa->tanggal
            ];
            $this->M_Kasmasuk->insert_kasmasuk_histori($data_histori);
            $this->M_Kasmasuk->delete_kas($siswa->id_kasmasuk);
        }

        $this->session->set_flashdata('message', 'Status berhasil direset.');
        redirect('periode/detail/' . $id_periode);
    }

    public function tambah_kaskeluar()
    {
        $data = [
            'id_periode' => $this->input->post('id_periode'),
            'tanggal' => $this->input->post('tanggal'),
            'nominal' => $this->input->post('nominal'),
            'keterangan' => $this->input->post('keterangan')
        ];

        $this->M_Kaskeluar->insert_kaskeluar($data);

        $this->M_Laporan->update_saldo();

        $this->session->set_flashdata('message', 'Kas Keluar berhasil ditambahkan!');

        redirect('periode/detail/' . $this->input->post('id_periode'));
    }

    public function edit_kaskeluar($id_kaskeluar)
    {
        $data = [
            'tanggal' => $this->input->post('tanggal'),
            'nominal' => $this->input->post('nominal'),
            'keterangan' => $this->input->post('keterangan')
        ];

        $this->M_Laporan->update_saldo();

        $this->M_Kaskeluar->update_kaskeluar($id_kaskeluar, $data);

        $this->session->set_flashdata('message', 'Kas Keluar berhasil diedit!');

        redirect('periode/detail/' . $this->input->post('id_periode'));
    }

    public function hapus_kaskeluar($id_kaskeluar, $id_periode)
    {
        $this->M_Kaskeluar->delete_kaskeluar($id_kaskeluar);

        $this->session->set_flashdata('message', 'Kas Keluar berhasil dihapus!');

        redirect('periode/detail/' . $id_periode);
    }

    public function tambah()
    {
        $data = [
            'bulan' => $this->input->post('bulan'),
            'tahun' => $this->input->post('tahun'),
            'tenggat' => $this->input->post('tenggat'),
            'jumlah_hutang' => $this->input->post('jumlah_hutang')
        ];

        $this->M_Periode->insert_periode($data);

        $this->session->set_flashdata('success', 'Periode berhasil ditambahkan!');

        redirect('periode');
    }

    public function edit($id)
    {
        $data = [
            'bulan' => $this->input->post('bulan'),
            'tahun' => $this->input->post('tahun'),
            'tenggat' => $this->input->post('tenggat'),
            'jumlah_hutang' => $this->input->post('jumlah_hutang')
        ];

        $this->M_Periode->update_periode($id, $data);

        $this->session->set_flashdata('success', 'Periode berhasil diedit!');

        redirect('periode');
    }

    public function hapus($id)
    {
        $this->M_Periode->delete_periode($id);

        $this->M_Laporan->update_saldo();

        $this->session->set_flashdata('success', 'Periode berhasil hapus!');

        redirect('periode');
    }
}
