<?php
defined('BASEPATH') or exit('No direct script access allowed');

class user extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_User');
        $this->load->model('M_Auth');
    }

    public function index()
    {
        $data['user'] = $this->M_User->get_all_bendahara();
        $this->isLoggedIn();
        $this->load->view('user', $data);
    }

    public function setting()
    {
        $this->load->view('setting');
    }

    public function isLoggedIn()
    {
        $this->session->set_flashdata('error', 'Anda tidak memiliki hak akses');

        if (!$this->session->userdata('logged_in') || $this->session->userdata('role') == 'bendahara') {
            redirect('dashboard');
        }
    }

    public function tambah()
    {
        $data = [
            'id_user' => uniqid(),
            'nama' => $this->input->post('nama'),
            'email' => $this->input->post('email'),
            'username' => $this->input->post('username'),
            'password' => $this->input->post('password'),
            'peran' => "Bendahara",
        ];

        $this->M_User->insert_user($data);

        redirect('user');
    }

    public function edit()
    {
        $data = [
            'id_user' => $this->input->post('id_user'),
            'nama' => $this->input->post('nama'),
            'email' => $this->input->post('email'),
            'username' => $this->input->post('username'),
            'password' => $this->input->post('password'),
            'peran' => "Bendahara",
        ];

        $this->M_User->update_user($data);
        redirect('user');
    }

    public function hapus($id)
    {
        $this->M_User->delete_user($id);
        redirect('user');
    }

    public function update_password()
    {
        $this->load->library('form_validation');

        $this->form_validation->set_rules('current_password', 'Current Password', 'required');
        $this->form_validation->set_rules('new_password', 'New Password', 'required|min_length[6]');
        $this->form_validation->set_rules('confirm_password', 'Confirm New Password', 'required|matches[new_password]');

        if ($this->form_validation->run() === FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('user/setting');
        } else {
            $username = $this->session->userdata('username');
            $current_password = ($this->input->post('current_password'));
            $new_password = ($this->input->post('new_password'));

            // Cek apakah password saat ini sesuai
            $user = $this->M_Auth->check_login($username, $current_password);

            if ($user) {
                $this->M_User->update_password($username, $new_password);
                $this->session->set_flashdata('success', 'Password updated successfully');
            } else {
                $this->session->set_flashdata('error', 'Current password is incorrect');
            }

            redirect('user/setting');
        }
    }
}
