<?php
class Search extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_Periode');
    }

    public function index()
    {
        $query = $this->input->post('query');

        $pages = [
            'dashboard' => site_url('dashboard'),
            'siswa' => site_url('siswa'),
            'user' => site_url('user'),
            'kas' => site_url('periode'),
            'setting' => site_url('user/setting'),
        ];

        $best_match = null;
        $highest_similarity = 0;

        foreach ($pages as $key => $url) {
            similar_text(strtolower($query), strtolower($key), $percent);
            if ($percent > $highest_similarity) {
                $highest_similarity = $percent;
                $best_match = $url;
            }
        }

        if ($highest_similarity > 50) {
            redirect($best_match);
        } else {
            $periode = $this->M_Periode->search_periode($query);
            if ($periode) {
                redirect('periode/detail/' . $periode->id_periode);
            } else {
                $this->session->set_flashdata('error', 'Halaman atau periode tidak ditemukan, untuh periode harap perhatikan huruf kapital');
                redirect($_SERVER['HTTP_REFERER']);
            }
        }
    }
}
