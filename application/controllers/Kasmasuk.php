<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kasmasuk extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->isLoggedIn();
        $this->load->model('M_Kasmasuk');
        $this->load->model('M_Laporan');
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
            'nominal' => $this->input->post('nominal'),
            'keterangan' => $this->input->post('keterangan'),
        ];

        $this->M_Kasmasuk->insert_kasmasuk($data);

        $this->M_Laporan->update_saldo();

        $this->session->set_flashdata('success', 'Kas masuk berhasil ditambahkan!');

        redirect('periode');
    }

    public function edit($id)
    {
        $data = [
            'nominal' => $this->input->post('nominal'),
            'keterangan' => $this->input->post('keterangan'),
        ];

        $this->M_Kasmasuk->update_kasmasuk($id, $data);

        $this->M_Laporan->update_saldo();

        $this->session->set_flashdata('success', 'Kas masuk berhasil diedit!');

        redirect('periode');
    }

    public function hapus($id)
    {
        $this->M_Kasmasuk->delete_kasmasuk($id);

        $this->M_Laporan->update_saldo();

        $this->session->set_flashdata('success', 'Kas masuk berhasil dihapus!');

        redirect('periode');
    }
}
