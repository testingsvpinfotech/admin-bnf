<?php
class Commission_master_model extends CI_Model {
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    public function get_all() {
        return $this->db->get('items')->result_array();
    }
    public function add(array $data) {
        var_dump($data);
        $this->db->insert('items', $data);
    }
    public function edit( $id, $data) {
        $this->db->where('id', $id);
        $this->db->update('items', $data);
    }
}