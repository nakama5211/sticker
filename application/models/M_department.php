<?php
class M_department extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    function load_all_department(){
        $this->db->select()
        		->from('department')
        		->order_by('id');
        $query = $this->db->get();
        return $query->result_array();
    }
}
