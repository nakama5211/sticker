<?php

class M_data extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    function load_typeDecal(){
        $this->db->select()
        		->from('typedecal')
        		->order_by('id');
        $query = $this->db->get();
        return $query->result_array();
    }

    function load_extrusion(){
    	$this->db->select()
    			->from('extrusion')
        		->order_by('id');
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_typeDecal($id){
    	$this->db->select('name,price')
    			->from('typedecal')
    			->where('id',$id);
    	$query = $this->db->get();
        return $query->result_array();		
    }

    function get_extrusion($id){
    	$this->db->select('name,price')
    			->from('extrusion')
    			->where('id',$id);
    	$query = $this->db->get();
        return $query->result_array();		
    }
}

