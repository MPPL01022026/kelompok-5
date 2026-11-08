<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_model');
    }

    /**
     * Login page
     */
    public function login()
    {
        // If already logged in, redirect to dashboard
        if ($this->session->userdata('logged_in')) {
            redirect('dashboard');
        }

        if ($this->input->method() === 'post') {
            $this->form_validation->set_rules('username', 'Username', 'required|trim');
            $this->form_validation->set_rules('password', 'Password', 'required');

            if ($this->form_validation->run() == TRUE) {
                $username = $this->input->post('username');
                $password = $this->input->post('password');

                $user = $this->User_model->login($username, $password);

                if ($user) {
                    $session_data = [
                        'user_id'   => $user->id,
                        'username'  => $user->username,
                        'nama'      => $user->nama,
                        'role'      => $user->role,
                        'logged_in' => TRUE
                    ];
                    $this->session->set_userdata($session_data);
                    redirect('dashboard');
                } else {
                    $this->session->set_flashdata('error', 'Username atau password salah!');
                    redirect('login');
                }
            } else {
                $this->session->set_flashdata('error', validation_errors());
                redirect('login');
            }
        }

        $this->load->view('auth/login');
    }

    /**
     * Logout
     */
    public function logout()
    {
        $this->session->sess_destroy();
        redirect('login');
    }
}
