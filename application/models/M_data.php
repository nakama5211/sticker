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

    function load_typeProject(){
        $this->db->select()
                ->from('typeproject')
                ->order_by('id');
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_typeProject($id){
        $this->db->select()
                ->from('typeproject')
                ->where('id',$id);
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

    function load_unit(){
        $this->db->select()
                ->from('unit')
                ->order_by('id');
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_unit($id){
        $this->db->select()
                ->from('unit')
                ->where('id',$id);
        $query = $this->db->get();
        return $query->result_array();  
    }

    function load_class(){
        $this->db->select()
                ->from('class')
                ->order_by('id');
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_class($id){
        $this->db->select()
                ->from('class')
                ->where('id',$id);
        $query = $this->db->get();
        return $query->result_array();  
    }

    function load_outsource(){
        $this->db->select()
                ->from('gia_cong')
                ->order_by('id');
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_outsource($id){
        $this->db->select()
                ->from('gia_cong')
                ->where('id',$id);
        $query = $this->db->get();
        return $query->result_array();  
    }

    function record_exists($record,$table)
    {
        $this->db->where($record);
        $query = $this->db->get($table);
        if ($query->num_rows() > 0){
            return true;
        }
        else{
            return false;
        }
    }
    function null_key($match,$key,$table)
    {
        $this->db->select($key);
        $this->db->where($match);
        $this->db->where($key.'!=','');
        $query = $this->db->get($table);
        if ($query->num_rows() > 0){
            return false;
        }
        else{
            return true;
        }
    }

    function load_donHang(){
        $this->db->select()
                ->from('donhang');
        $query = $this->db->get();
        return $query->result_array();
    }
}

