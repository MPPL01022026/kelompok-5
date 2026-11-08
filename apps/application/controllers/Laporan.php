<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }
        $this->load->model('Bahan_model');
        $this->load->model('Stok_masuk_model');
        $this->load->model('Stok_keluar_model');
    }

    /**
     * Laporan page
     */
    public function index()
    {
        $data['title'] = 'Laporan Persediaan';
        $data['active_menu'] = 'laporan';
        
        // Date range filter
        $start = $this->input->get('start') ?: date('Y-m-01');
        $end = $this->input->get('end') ?: date('Y-m-d');
        
        $data['start'] = $start;
        $data['end'] = $end;
        $data['bahan'] = $this->Bahan_model->get_all();
        $data['stok_masuk'] = $this->Stok_masuk_model->get_by_date_range($start, $end);
        $data['stok_keluar'] = $this->Stok_keluar_model->get_by_date_range($start, $end);
        $data['total_pembelian'] = $this->Stok_masuk_model->get_total_value($start, $end);
        $data['total_nilai_stok'] = $this->Bahan_model->get_total_value();
        
        $this->load->view('templates/header', $data);
        $this->load->view('laporan/index', $data);
        $this->load->view('templates/footer', $data);
    }

    /**
     * Print report
     */
    public function cetak()
    {
        $start = $this->input->get('start') ?: date('Y-m-01');
        $end = $this->input->get('end') ?: date('Y-m-d');
        
        $data['start'] = $start;
        $data['end'] = $end;
        $data['bahan'] = $this->Bahan_model->get_all();
        $data['stok_masuk'] = $this->Stok_masuk_model->get_by_date_range($start, $end);
        $data['stok_keluar'] = $this->Stok_keluar_model->get_by_date_range($start, $end);
        $data['total_pembelian'] = $this->Stok_masuk_model->get_total_value($start, $end);
        $data['total_nilai_stok'] = $this->Bahan_model->get_total_value();
        
        $this->load->view('laporan/cetak', $data);
    }
}
