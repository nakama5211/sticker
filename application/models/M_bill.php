<?php

class M_bill extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    function load_all_bill(){
        $this->db->select('
            bill.*,

            customer.name as customer,
            customer.email as email,
            customer.phone as phone,
            customer.address as address,

            typedecal.name as typedecal,
            typedecal.price as typedecal_price,

            extrusion.price as extrusion_price,
            extrusion.name as extrusion

            unit.name as unit_name
            ')
        		->from('bill')
                ->join('unit','unit.id = bill.unit')
                ->join('customer','bill.id_customer = customer.id')
        		->join('typedecal', 'bill.id_typedecal = typedecal.id')
        		->join('extrusion', 'bill.id_extrusion = extrusion.id')
                ->where('bill.hidden',0)
        		->order_by('bill.created_at','desc');
        $query = $this->db->get();
        return $query->result_array();
    }

    function load_bill($match){
        $this->db->select('
            bill.*,

            customer.name as customer,
            customer.email as email,
            customer.phone as phone,
            customer.address as address,

            typedecal.name as typedecal,
            typedecal.price as typedecal_price,

            extrusion.price as extrusion_price,
            extrusion.name as extrusion,

            unit.name as unit_name,

            status.name as status_name,
            ')
                ->from('bill')
                ->join('status','status.id = bill.status')
                ->join('unit','unit.id = bill.unit')
                ->join('customer','bill.id_customer = customer.id')
                ->join('typedecal', 'bill.id_typedecal = typedecal.id')
                ->join('extrusion', 'bill.id_extrusion = extrusion.id')
                ->where($match)
                ->order_by('bill.created_at','desc');
        $query = $this->db->get();
        return $query->result_array();
    }

    function load_my_task_bill($match){
        $this->db->select('
            bill.*,

            customer.name as customer,
            customer.email as email,
            customer.phone as phone,
            customer.address as address,

            typedecal.name as typedecal,
            typedecal.price as typedecal_price,

            extrusion.price as extrusion_price,
            extrusion.name as extrusion,

            unit.name as unit_name,

            status.name as status_name,
            ')
                ->from('bill')
                ->join('status','status.id = bill.status','left')
                ->join('unit','unit.id = bill.unit','left')
                ->join('project','project.id_bill = bill.id','left')
                ->join('customer','bill.id_customer = customer.id','left')
                ->join('typedecal', 'bill.id_typedecal = typedecal.id','left')
                ->join('extrusion', 'bill.id_extrusion = extrusion.id','left')
                ->join('task','task.id_project = project.id','left')
                ->where($match)
                ->order_by('bill.created_at','desc');
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_bill($id){
    	$this->db->select('bill.*,customer.name as customer,customer.email as email,customer.phone as phone,customer.address as address,typedecal.id as typedecal,typedecal.price as typedecal_price,extrusion.price as extrusion_price,extrusion.id as extrusion,extrusion.name as extrusion_name,typedecal.name as typedecal_name')
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

    function get_file($id){
        $this->db->select('file')
                ->where('id',$id)
                ->from('bill');
        $query = $this->db->get();
        return $query->result_array();
    }
}

