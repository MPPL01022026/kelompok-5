<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

    private $table = 'users';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Login authentication
     */
    public function login($username, $password)
    {
        $user = $this->db->get_where($this->table, ['username' => $username, 'is_active' => 1])->row();
        
        if ($user && password_verify($password, $user->password)) {
            return $user;
        }
        return false;
    }

    /**
     * Get user by ID
     */
    public function get_by_id($id)
    {
        return $this->db->get_where($this->table, ['id' => $id])->row();
    }

    /**
     * Get all users
     */
    public function get_all()
    {
        return $this->db->order_by('id', 'ASC')->get($this->table)->result();
    }
}
