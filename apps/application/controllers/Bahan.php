<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bahan extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }
        $this->load->model('Bahan_model');
        $this->load->model('Riwayat_model');
    }

    /**
     * List all bahan
     */
    public function index()
    {
        $data['title'] = 'Data Bahan Makanan';
        $data['active_menu'] = 'bahan';
        $data['bahan'] = $this->Bahan_model->get_all();
        $data['categories'] = $this->Bahan_model->get_categories();
        $data['kode_bahan'] = $this->Bahan_model->generate_kode();
        
        $this->load->view('templates/header', $data);
        $this->load->view('bahan/index', $data);
        $this->load->view('templates/footer', $data);
    }

    /**
     * Add new bahan
     */
    public function tambah()
    {
        $this->form_validation->set_rules('nama_bahan', 'Nama Bahan', 'required|trim');
        $this->form_validation->set_rules('satuan', 'Satuan', 'required|trim');
        $this->form_validation->set_rules('batas_minimum', 'Batas Minimum', 'required|numeric');

        if ($this->form_validation->run() == TRUE) {
            $data = [
                'kode_bahan'    => $this->input->post('kode_bahan'),
                'nama_bahan'    => $this->input->post('nama_bahan'),
                'kategori_id'   => $this->input->post('kategori_id') ?: null,
                'satuan'        => $this->input->post('satuan'),
                'stok_saat_ini' => $this->input->post('stok_awal') ?: 0,
                'batas_minimum' => $this->input->post('batas_minimum'),
                'harga_satuan'  => $this->input->post('harga_satuan') ?: 0,
                'keterangan'    => $this->input->post('keterangan')
            ];
            
            $id = $this->Bahan_model->insert($data);
            
            if ($id) {
                // Log to riwayat
                $this->Riwayat_model->insert([
                    'tipe'       => 'masuk',
                    'bahan_id'   => $id,
                    'jumlah'     => $data['stok_saat_ini'],
                    'keterangan' => 'Bahan baru ditambahkan: ' . $data['nama_bahan'],
                    'user_id'    => $this->session->userdata('user_id')
                ]);
                
                $this->session->set_flashdata('success', 'Data bahan berhasil ditambahkan!');
            } else {
                $this->session->set_flashdata('error', 'Gagal menambahkan data bahan!');
            }
        } else {
            $this->session->set_flashdata('error', validation_errors());
        }
        
        redirect('bahan');
    }

    /**
     * Edit bahan
     */
    public function edit($id)
    {
        $this->form_validation->set_rules('nama_bahan', 'Nama Bahan', 'required|trim');
        $this->form_validation->set_rules('satuan', 'Satuan', 'required|trim');
        $this->form_validation->set_rules('batas_minimum', 'Batas Minimum', 'required|numeric');

        if ($this->form_validation->run() == TRUE) {
            $data = [
                'nama_bahan'    => $this->input->post('nama_bahan'),
                'kategori_id'   => $this->input->post('kategori_id') ?: null,
                'satuan'        => $this->input->post('satuan'),
                'batas_minimum' => $this->input->post('batas_minimum'),
                'harga_satuan'  => $this->input->post('harga_satuan') ?: 0,
                'keterangan'    => $this->input->post('keterangan')
            ];
            
            $result = $this->Bahan_model->update($id, $data);
            
            if ($result) {
                $this->Riwayat_model->insert([
                    'tipe'       => 'edit',
                    'bahan_id'   => $id,
                    'keterangan' => 'Data bahan diperbarui: ' . $data['nama_bahan'],
                    'user_id'    => $this->session->userdata('user_id')
                ]);
                
                $this->session->set_flashdata('success', 'Data bahan berhasil diperbarui!');
            } else {
                $this->session->set_flashdata('error', 'Gagal memperbarui data bahan!');
            }
        } else {
            $this->session->set_flashdata('error', validation_errors());
        }
        
        redirect('bahan');
    }

    /**
     * Delete bahan
     */
    public function hapus($id)
    {
        $bahan = $this->Bahan_model->get_by_id($id);
        
        if ($bahan) {
            $this->Riwayat_model->insert([
                'tipe'       => 'hapus',
                'bahan_id'   => $id,
                'keterangan' => 'Bahan dihapus: ' . $bahan->nama_bahan,
                'user_id'    => $this->session->userdata('user_id')
            ]);
            
            $this->Bahan_model->delete($id);
            $this->session->set_flashdata('success', 'Data bahan berhasil dihapus!');
        } else {
            $this->session->set_flashdata('error', 'Data bahan tidak ditemukan!');
        }
        
        redirect('bahan');
    }

    /**
     * Get bahan data (AJAX)
     */
    public function get($id)
    {
        $bahan = $this->Bahan_model->get_by_id($id);
        echo json_encode($bahan);
    }
}
