<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->isLoggedIn();
		$this->load->model('M_Laporan');
	}

	public function isLoggedIn()
	{
		if (!$this->session->userdata('logged_in')) {
			redirect('auth');
		}
	}

	public function index()
	{
		$filter = $this->input->post('filter') ?: 'today';
		$periode = null;
		$tahun = null;

		// Tentukan periode dan tahun berdasarkan filter
		switch ($filter) {
			case 'today':
				$periode = [
					'bulan' => date('m'),
					'tahun' => date('Y')
				];
				break;
			case 'this_month':
				$periode = [
					'bulan' => date('m'),
					'tahun' => date('Y')
				];
				break;
			case 'this_year':
				$tahun = date('Y');
				break;
		}

		$data['saldo'] = $this->M_Laporan->get_current_saldo();
		$data['total_kas_masuk'] = $this->M_Laporan->get_total_kas_masuk($periode);
		$data['total_siswa'] = $this->M_Laporan->get_total_siswa($tahun);
		$data['filter'] = $filter;

		$this->load->view('dashboard', $data);
	}
}
