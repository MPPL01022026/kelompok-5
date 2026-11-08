<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }
        $this->load->model('Bahan_model');
        $this->load->model('Stok_masuk_model');
        $this->load->model('Stok_keluar_model');
        $this->load->model('Riwayat_model');
    }

    /**
     * Dashboard page
     */
    public function index()
    {
        $data['title'] = 'Dashboard';
        $data['active_menu'] = 'dashboard';
        
        // Statistics
        $data['total_bahan'] = $this->Bahan_model->count_all();
        $data['low_stock'] = $this->Bahan_model->get_low_stock();
        $data['low_stock_count'] = count($data['low_stock']);
        $data['stok_masuk_today'] = $this->Stok_masuk_model->count_today();
        $data['stok_keluar_today'] = $this->Stok_keluar_model->count_today();
        $data['total_value'] = $this->Bahan_model->get_total_value();
        
        // Recent activities
        $data['recent_activities'] = $this->Riwayat_model->get_all(10);
        
        // All bahan for digital twin visualization
        $data['all_bahan'] = $this->Bahan_model->get_all();
        
        $this->load->view('templates/header', $data);
        $this->load->view('dashboard/index', $data);
        $this->load->view('templates/footer', $data);
    }

    /**
     * API: Get dashboard stats (for AJAX refresh)
     */
    public function get_stats()
    {
        $stats = [
            'total_bahan' => $this->Bahan_model->count_all(),
            'low_stock_count' => count($this->Bahan_model->get_low_stock()),
            'stok_masuk_today' => $this->Stok_masuk_model->count_today(),
            'stok_keluar_today' => $this->Stok_keluar_model->count_today(),
            'total_value' => $this->Bahan_model->get_total_value()
        ];
        
        echo json_encode($stats);
    }
}
