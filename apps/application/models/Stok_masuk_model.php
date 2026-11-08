<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Stok_masuk_model extends CI_Model {

    private $table = 'stok_masuk';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Get all stok masuk with bahan info
     */
    public function get_all($limit = null, $offset = 0)
    {
        $this->db->select('stok_masuk.*, bahan.nama_bahan, bahan.satuan, bahan.kode_bahan, users.nama as nama_user');
        $this->db->from($this->table);
        $this->db->join('bahan', 'bahan.id = stok_masuk.bahan_id', 'left');
        $this->db->join('users', 'users.id = stok_masuk.user_id', 'left');
        $this->db->order_by('stok_masuk.created_at', 'DESC');
        if ($limit) {
            $this->db->limit($limit, $offset);
        }
        return $this->db->get()->result();
    }

    /**
     * Get by ID
     */
    public function get_by_id($id)
    {
        $this->db->select('stok_masuk.*, bahan.nama_bahan, bahan.satuan');
        $this->db->from($this->table);
        $this->db->join('bahan', 'bahan.id = stok_masuk.bahan_id', 'left');
        $this->db->where('stok_masuk.id', $id);
        return $this->db->get()->row();
    }

    /**
     * Insert stok masuk
     */
    public function insert($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    /**
     * Delete stok masuk
     */
    public function delete($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete($this->table);
    }

    /**
     * Generate transaction code
     */
    public function generate_kode()
    {
        $today = date('Ymd');
        $this->db->like('kode_transaksi', 'SM-' . $today);
        $count = $this->db->count_all_results($this->table);
        return 'SM-' . $today . '-' . str_pad($count + 1, 3, '0', STR_PAD_LEFT);
    }

    /**
     * Count today's transactions
     */
    public function count_today()
    {
        $this->db->where('tanggal', date('Y-m-d'));
        return $this->db->count_all_results($this->table);
    }

    /**
     * Get by date range
     */
    public function get_by_date_range($start, $end)
    {
        $this->db->select('stok_masuk.*, bahan.nama_bahan, bahan.satuan, bahan.kode_bahan');
        $this->db->from($this->table);
        $this->db->join('bahan', 'bahan.id = stok_masuk.bahan_id', 'left');
        $this->db->where('stok_masuk.tanggal >=', $start);
        $this->db->where('stok_masuk.tanggal <=', $end);
        $this->db->order_by('stok_masuk.tanggal', 'DESC');
        return $this->db->get()->result();
    }

    /**
     * Get total value by date range
     */
    public function get_total_value($start = null, $end = null)
    {
        $this->db->select_sum('harga_beli', 'total');
        if ($start && $end) {
            $this->db->where('tanggal >=', $start);
            $this->db->where('tanggal <=', $end);
        }
        $result = $this->db->get($this->table)->row();
        return $result->total ?? 0;
    }
}
