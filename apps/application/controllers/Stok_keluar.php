<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Stok_keluar extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }
        $this->load->model('Stok_keluar_model');
        $this->load->model('Bahan_model');
        $this->load->model('Riwayat_model');
    }

    /**
     * List all stok keluar
     */
    public function index()
    {
        $data['title'] = 'Stok Keluar';
        $data['active_menu'] = 'stok_keluar';
        $data['stok_keluar'] = $this->Stok_keluar_model->get_all();
        $data['bahan_list'] = $this->Bahan_model->get_all();
        $data['kode_transaksi'] = $this->Stok_keluar_model->generate_kode();
        
        $this->load->view('templates/header', $data);
        $this->load->view('stok_keluar/index', $data);
        $this->load->view('templates/footer', $data);
    }

    /**
     * Add stok keluar
     */
    public function tambah()
    {
        $this->form_validation->set_rules('bahan_id', 'Bahan', 'required');
        $this->form_validation->set_rules('jumlah', 'Jumlah', 'required|numeric|greater_than[0]');
        $this->form_validation->set_rules('tanggal', 'Tanggal', 'required');

        if ($this->form_validation->run() == TRUE) {
            $bahan_id = $this->input->post('bahan_id');
            $jumlah = $this->input->post('jumlah');
            
            // Check if stock is sufficient
            $bahan = $this->Bahan_model->get_by_id($bahan_id);
            if ($bahan->stok_saat_ini < $jumlah) {
                $this->session->set_flashdata('error', 'Stok tidak mencukupi! Stok tersedia: ' . $bahan->stok_saat_ini . ' ' . $bahan->satuan);
                redirect('stok-keluar');
                return;
            }
            
            $data = [
                'kode_transaksi' => $this->input->post('kode_transaksi'),
                'bahan_id'       => $bahan_id,
                'jumlah'         => $jumlah,
                'tanggal'        => $this->input->post('tanggal'),
                'keperluan'      => $this->input->post('keperluan') ?: 'Pemakaian Harian',
                'keterangan'     => $this->input->post('keterangan'),
                'user_id'        => $this->session->userdata('user_id')
            ];
            
            $id = $this->Stok_keluar_model->insert($data);
            
            if ($id) {
                // Update stok bahan
                $this->Bahan_model->update_stok($bahan_id, $jumlah, 'keluar');
                
                // Log riwayat
                $this->Riwayat_model->insert([
                    'tipe'       => 'keluar',
                    'bahan_id'   => $bahan_id,
                    'jumlah'     => $jumlah,
                    'keterangan' => 'Stok keluar: ' . $bahan->nama_bahan . ' sebanyak ' . $jumlah . ' ' . $bahan->satuan,
                    'user_id'    => $this->session->userdata('user_id')
                ]);
                
                $this->session->set_flashdata('success', 'Stok keluar berhasil dicatat!');
            } else {
                $this->session->set_flashdata('error', 'Gagal mencatat stok keluar!');
            }
        } else {
            $this->session->set_flashdata('error', validation_errors());
        }
        
        redirect('stok-keluar');
    }

    /**
     * Delete stok keluar
     */
    public function hapus($id)
    {
        $stok = $this->Stok_keluar_model->get_by_id($id);
        
        if ($stok) {
            // Revert stock
            $this->Bahan_model->update_stok($stok->bahan_id, $stok->jumlah, 'masuk');
            
            $this->Riwayat_model->insert([
                'tipe'       => 'hapus',
                'bahan_id'   => $stok->bahan_id,
                'jumlah'     => $stok->jumlah,
                'keterangan' => 'Stok keluar dibatalkan: ' . $stok->nama_bahan,
                'user_id'    => $this->session->userdata('user_id')
            ]);
            
            $this->Stok_keluar_model->delete($id);
            $this->session->set_flashdata('success', 'Data stok keluar berhasil dihapus!');
        } else {
            $this->session->set_flashdata('error', 'Data tidak ditemukan!');
        }
        
        redirect('stok-keluar');
    }
}
