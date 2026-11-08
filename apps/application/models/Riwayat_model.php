<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Riwayat_model extends CI_Model {

    private $table = 'riwayat';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Get all riwayat with related info
     */
    public function get_all($limit = 50, $offset = 0)
    {
        $this->db->select('riwayat.*, bahan.nama_bahan, bahan.kode_bahan, users.nama as nama_user');
        $this->db->from($this->table);
        $this->db->join('bahan', 'bahan.id = riwayat.bahan_id', 'left');
        $this->db->join('users', 'users.id = riwayat.user_id', 'left');
        $this->db->order_by('riwayat.created_at', 'DESC');
        $this->db->limit($limit, $offset);
        return $this->db->get()->result();
    }

    /**
     * Insert riwayat
     */
    public function insert($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    /**
     * Get by date range
     */
    public function get_by_date_range($start, $end, $tipe = null)
    {
        $this->db->select('riwayat.*, bahan.nama_bahan, bahan.kode_bahan, users.nama as nama_user');
        $this->db->from($this->table);
        $this->db->join('bahan', 'bahan.id = riwayat.bahan_id', 'left');
        $this->db->join('users', 'users.id = riwayat.user_id', 'left');
        $this->db->where('DATE(riwayat.created_at) >=', $start);
        $this->db->where('DATE(riwayat.created_at) <=', $end);
        if ($tipe) {
            $this->db->where('riwayat.tipe', $tipe);
        }
        $this->db->order_by('riwayat.created_at', 'DESC');
        return $this->db->get()->result();
    }

    /**
     * Count all records
     */
    public function count_all()
    {
        return $this->db->count_all($this->table);
    }
}
