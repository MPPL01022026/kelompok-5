<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Status_stok extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }
        $this->load->model('Bahan_model');
    }

    /**
     * Status stok page
     */
    public function index()
    {
        $data['title'] = 'Status Stok';
        $data['active_menu'] = 'status_stok';
        $data['bahan'] = $this->Bahan_model->get_all();
        $data['low_stock'] = $this->Bahan_model->get_low_stock();
        $data['empty_stock'] = $this->Bahan_model->get_empty_stock();
        
        $this->load->view('templates/header', $data);
        $this->load->view('status_stok/index', $data);
        $this->load->view('templates/footer', $data);
    }
}
