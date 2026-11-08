<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Stok_masuk extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }
        $this->load->model('Stok_masuk_model');
        $this->load->model('Bahan_model');
        $this->load->model('Riwayat_model');
    }

    /**
     * List all stok masuk
     */
    public function index()
    {
        $data['title'] = 'Stok Masuk';
        $data['active_menu'] = 'stok_masuk';
        $data['stok_masuk'] = $this->Stok_masuk_model->get_all();
        $data['bahan_list'] = $this->Bahan_model->get_all();
        $data['kode_transaksi'] = $this->Stok_masuk_model->generate_kode();
        
        $this->load->view('templates/header', $data);
        $this->load->view('stok_masuk/index', $data);
        $this->load->view('templates/footer', $data);
    }

    /**
     * Add stok masuk
     */
    public function tambah()
    {
        $this->form_validation->set_rules('bahan_id', 'Bahan', 'required');
        $this->form_validation->set_rules('jumlah', 'Jumlah', 'required|numeric|greater_than[0]');
        $this->form_validation->set_rules('tanggal', 'Tanggal', 'required');

        if ($this->form_validation->run() == TRUE) {
            $bahan_id = $this->input->post('bahan_id');
            $jumlah = $this->input->post('jumlah');
            
            $data = [
                'kode_transaksi' => $this->input->post('kode_transaksi'),
                'bahan_id'       => $bahan_id,
                'jumlah'         => $jumlah,
                'harga_beli'     => $this->input->post('harga_beli') ?: 0,
                'tanggal'        => $this->input->post('tanggal'),
                'supplier'       => $this->input->post('supplier'),
                'keterangan'     => $this->input->post('keterangan'),
                'user_id'        => $this->session->userdata('user_id')
            ];
            
            $id = $this->Stok_masuk_model->insert($data);
            
            if ($id) {
                // Update stok bahan
                $this->Bahan_model->update_stok($bahan_id, $jumlah, 'masuk');
                
                // Log riwayat
                $bahan = $this->Bahan_model->get_by_id($bahan_id);
                $this->Riwayat_model->insert([
                    'tipe'       => 'masuk',
                    'bahan_id'   => $bahan_id,
                    'jumlah'     => $jumlah,
                    'keterangan' => 'Stok masuk: ' . $bahan->nama_bahan . ' sebanyak ' . $jumlah . ' ' . $bahan->satuan,
                    'user_id'    => $this->session->userdata('user_id')
                ]);
                
                $this->session->set_flashdata('success', 'Stok masuk berhasil dicatat!');
            } else {
                $this->session->set_flashdata('error', 'Gagal mencatat stok masuk!');
            }
        } else {
            $this->session->set_flashdata('error', validation_errors());
        }
        
        redirect('stok-masuk');
    }

    /**
     * Delete stok masuk
     */
    public function hapus($id)
    {
        $stok = $this->Stok_masuk_model->get_by_id($id);
        
        if ($stok) {
            // Revert stock
            $this->Bahan_model->update_stok($stok->bahan_id, $stok->jumlah, 'keluar');
            
            $this->Riwayat_model->insert([
                'tipe'       => 'hapus',
                'bahan_id'   => $stok->bahan_id,
                'jumlah'     => $stok->jumlah,
                'keterangan' => 'Stok masuk dibatalkan: ' . $stok->nama_bahan,
                'user_id'    => $this->session->userdata('user_id')
            ]);
            
            $this->Stok_masuk_model->delete($id);
            $this->session->set_flashdata('success', 'Data stok masuk berhasil dihapus!');
        } else {
            $this->session->set_flashdata('error', 'Data tidak ditemukan!');
        }
        
        redirect('stok-masuk');
    }
}
