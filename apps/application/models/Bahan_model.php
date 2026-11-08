<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bahan_model extends CI_Model {

    private $table = 'bahan';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Get all bahan with kategori
     */
    public function get_all()
    {
        $this->db->select('bahan.*, kategori_bahan.nama_kategori');
        $this->db->from($this->table);
        $this->db->join('kategori_bahan', 'kategori_bahan.id = bahan.kategori_id', 'left');
        $this->db->order_by('bahan.id', 'ASC');
        return $this->db->get()->result();
    }

    /**
     * Get bahan by ID
     */
    public function get_by_id($id)
    {
        $this->db->select('bahan.*, kategori_bahan.nama_kategori');
        $this->db->from($this->table);
        $this->db->join('kategori_bahan', 'kategori_bahan.id = bahan.kategori_id', 'left');
        $this->db->where('bahan.id', $id);
        return $this->db->get()->row();
    }

    /**
     * Insert new bahan
     */
    public function insert($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    /**
     * Update bahan
     */
    public function update($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update($this->table, $data);
    }

    /**
     * Delete bahan
     */
    public function delete($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete($this->table);
    }

    /**
     * Update stock
     */
    public function update_stok($id, $jumlah, $tipe = 'masuk')
    {
        if ($tipe === 'masuk') {
            $this->db->set('stok_saat_ini', 'stok_saat_ini + ' . (float)$jumlah, FALSE);
        } else {
            $this->db->set('stok_saat_ini', 'stok_saat_ini - ' . (float)$jumlah, FALSE);
        }
        $this->db->where('id', $id);
        return $this->db->update($this->table);
    }

    /**
     * Get total count
     */
    public function count_all()
    {
        return $this->db->count_all($this->table);
    }

    /**
     * Get bahan with low stock
     */
    public function get_low_stock()
    {
        $this->db->select('bahan.*, kategori_bahan.nama_kategori');
        $this->db->from($this->table);
        $this->db->join('kategori_bahan', 'kategori_bahan.id = bahan.kategori_id', 'left');
        $this->db->where('stok_saat_ini <= batas_minimum', NULL, FALSE);
        return $this->db->get()->result();
    }

    /**
     * Get bahan with critical stock (0)
     */
    public function get_empty_stock()
    {
        $this->db->where('stok_saat_ini', 0);
        return $this->db->get($this->table)->result();
    }

    /**
     * Get all categories
     */
    public function get_categories()
    {
        return $this->db->get('kategori_bahan')->result();
    }

    /**
     * Generate kode bahan
     */
    public function generate_kode()
    {
        $this->db->select_max('id');
        $result = $this->db->get($this->table)->row();
        $next_id = ($result->id ?? 0) + 1;
        return 'BHN-' . str_pad($next_id, 3, '0', STR_PAD_LEFT);
    }

    /**
     * Get total asset value
     */
    public function get_total_value()
    {
        $this->db->select('SUM(stok_saat_ini * harga_satuan) AS total_value', FALSE);
        $result = $this->db->get($this->table)->row();
        return $result->total_value ?? 0;
    }
}
