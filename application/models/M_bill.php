<?php

class M_bill extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    function load_all_bill(){
        $this->db->select('bill.*,customer.name as customer,customer.email as email,customer.phone as phone,customer.address as address,customer.note as note,typedecal.name as typedecal,typedecal.price as typedecal_price,extrusion.price as extrusion_price,extrusion.name as extrusion')
        		->from('bill')
                ->join('customer','bill.id_customer = customer.id')
        		->join('typedecal', 'bill.id_typedecal = typedecal.id')
        		->join('extrusion', 'bill.id_extrusion = extrusion.id')
                ->where('hidden',0)
        		->order_by('bill.created_at');
        $query = $this->db->get();
        return $query->result_array();
    }

    function load_bill($match){
        $this->db->select('bill.*,customer.name as customer,customer.email as email,customer.phone as phone,customer.address as address,customer.note as note,typedecal.name as typedecal,typedecal.price as typedecal_price,extrusion.price as extrusion_price,extrusion.name as extrusion')
                ->from('bill')
                ->join('customer','bill.id_customer = customer.id')
                ->join('typedecal', 'bill.id_typedecal = typedecal.id')
                ->join('extrusion', 'bill.id_extrusion = extrusion.id')
                ->where($match)
                ->order_by('bill.created_at');
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_bill($id){
    	$this->db->select('bill.*,customer.name as customer,customer.email as email,customer.phone as phone,customer.address as address,customer.note as note,typedecal.id as typedecal,typedecal.price as typedecal_price,extrusion.price as extrusion_price,extrusion.id as extrusion,extrusion.name as extrusion_name,typedecal.name as typedecal_name')
        		->from('bill')
                ->join('customer','bill.id_customer = customer.id')
        		->join('typedecal', 'bill.id_typedecal = typedecal.id')
        		->join('extrusion', 'bill.id_extrusion = extrusion.id')
        		->where(['bill.id'=>$id,'bill.hidden'=>0]);
        $query = $this->db->get();
        return $query->result_array();
    }

    function update_bill($id,$data){
        $this->db->where('id',$id)
            ->update('bill',$data);
    }

    function insert_bill($data){
        $this->db->insert('bill',$data);
        return $this->db->insert_id();
    }

    function get_new_bill($time){
        $this->db->select()
                ->where('created_at >',$time)
                ->from('bill')
                ->order_by('created_at','DESC')
                ->limit(5);
        $query = $this->db->get();
        return $query->result_array();
    }
}

