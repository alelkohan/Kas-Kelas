<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_Auth');
    }

    public function index()
    {
        $this->load->view('login');
    }

    public function submit()
    {
        $username = $this->input->post('username');
        $password = $this->input->post('password');

        $user = $this->M_Auth->check_login($username, $password);

        if ($user) {
            $this->session->set_userdata('logged_in', $username);
            $this->session->set_userdata('username', $user->username);
            $this->session->set_userdata('email', $user->email);
            $this->session->set_userdata('nama', $user->nama);
            $this->session->set_userdata('last_login', $user->last_login);
            $this->session->set_userdata('role', $user->peran);

            $this->db->where('username', $username);
            $this->db->update('tb_user', ['last_login' => date('Y-m-d H:i:s')]);

            redirect('dashboard');
        } else {
            $this->session->set_flashdata('error', 'Username atau password salah');
            redirect('auth');
        }
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect('auth');
    }
}
