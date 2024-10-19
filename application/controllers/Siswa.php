<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Siswa extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->isLoggedIn();
        $this->load->model('M_Siswa');
    }

    public function index()
    {
        $data['siswa'] = $this->M_Siswa->get_all_siswa();
        $this->load->view('siswa', $data);
    }

    public function isLoggedIn()
    {
        if (!$this->session->userdata('logged_in')) {
            redirect('auth');
        }
    }

    public function tambah()
    {
        $data = [
            'id_siswa' => uniqid(),
            'nama_siswa' => $this->input->post('nama'),
            'alamat' => $this->input->post('alamat'),
            'nomor_telfon' => $this->input->post('no_telepon'),
            'status' => "Belum Bayar"
        ];

        $this->M_Siswa->insert_siswa($data);
        redirect('siswa');
    }

    public function edit()
    {
        $data = [
            'id_siswa' => $this->input->post('id_siswa'),
            'nama_siswa' => $this->input->post('nama'),
            'alamat' => $this->input->post('alamat'),
            'nomor_telfon' => $this->input->post('no_telepon')
        ];

        $this->M_Siswa->update_siswa($data);
        redirect('siswa');
    }

    public function hapus($id)
    {
        $this->M_Siswa->delete_siswa($id);
        redirect('siswa');
    }
}
