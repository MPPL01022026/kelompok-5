<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Riwayat extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }
        $this->load->model('Riwayat_model');
    }

    /**
     * Riwayat page
     */
    public function index()
    {
        $data['title'] = 'Riwayat Aktivitas';
        $data['active_menu'] = 'riwayat';
        
        // Filter by date range
        $start = $this->input->get('start') ?: date('Y-m-01');
        $end = $this->input->get('end') ?: date('Y-m-d');
        $tipe = $this->input->get('tipe') ?: null;
        
        $data['start'] = $start;
        $data['end'] = $end;
        $data['tipe_filter'] = $tipe;
        $data['riwayat'] = $this->Riwayat_model->get_by_date_range($start, $end, $tipe);
        
        $this->load->view('templates/header', $data);
        $this->load->view('riwayat/index', $data);
        $this->load->view('templates/footer', $data);
    }
}
