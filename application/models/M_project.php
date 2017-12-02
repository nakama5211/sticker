<?php

class M_project extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    function load_project($match){
        $this->db->select('
        	project.*,

        	customer.name as customer,

        	typeproject.name as typeproject,

        	bill.quantity as qty,
        	bill.unit as unit,
        	bill.file as file,

            unit.name as unit_name,

            status.name as status_name,
        ')
        ->from('project')
        ->join('status','status.id = project.status','left')
        ->join('typeproject','typeproject.id = id_typeproject','left')
        ->join('bill','bill.id = id_bill','left')
        ->join('customer','customer.id = bill.id_customer','left')
        ->join('unit','unit.id = bill.unit','left')
        ->where($match)
        ->order_by('project.created_at','desc');
        $query = $this->db->get();
        return $query->result_array();
    }

    function load_project_by_filter($match){
        $this->db->select('
            project.*,

            customer.name as customer,

            typeproject.name as typeproject,

            bill.quantity as qty,
            bill.unit as unit,
            bill.file as file,

            unit.name as unit_name,

            status.name as status_name,
        ')
        ->from('project')
        ->join('status','status.id = project.status')
        ->join('typeproject','typeproject.id = id_typeproject')
        ->join('bill','bill.id = id_bill','left')
        ->join('customer','customer.id = bill.id_customer','left')
        ->join('unit','unit.id = bill.unit','left')
        ->where($match)
        ->order_by('project.created_at','desc');
        $query = $this->db->get();
        return $query->result_array();
    }
    function load_my_task_project($match){
        $this->db->select('
            project.*,

            customer.name as customer,

            typeproject.name as typeproject,

            bill.quantity as qty,
            bill.unit as unit,
            bill.file as file,

            unit.name as unit_name,

            status.name as status_name,
        ')
        ->from('project')
        ->join('status','status.id = project.status','left')
        ->join('typeproject','typeproject.id = id_typeproject','left')
        ->join('bill','bill.id = id_bill','left')
        ->join('customer','customer.id = bill.id_customer','left')
        ->join('unit','unit.id = bill.unit','left')
        ->join('task','task.id_project = project.id','left')
        ->where($match)
        ->order_by('project.created_at','desc');
        $query = $this->db->get();
        return $query->result_array();
    }

     function load_my_task_project_bill($match){
        $this->db->select('
            project.*,

            customer.name as customer,

            typeproject.name as typeproject,

            bill.quantity as qty,
            bill.unit as unit,

            unit.name as unit_name,

            status.name as status_name,

            task.get_at,
            task.done_at,
        ')
        ->from('project')
        ->join('typeproject','typeproject.id = id_typeproject','left')
        ->join('bill','bill.id = id_bill','left')
        ->join('customer','customer.id = bill.id_customer','left')
        ->join('unit','unit.id = bill.unit','left')
        ->join('task','task.id_project = project.id')
        ->join('status','status.id = task.status','left')
        ->where($match)
        ->order_by('project.created_at','desc');
        $query = $this->db->get();
        return $query->result_array();
    }

    function load_project_by_id($id){
        $this->db->select('
            project.*,

            customer.name as customer, 
            customer.phone, customer.email, customer.address,

            typeproject.name as typeproject,

            bill.quantity as qty,
            bill.unit as unit,
            bill.note as note_bill,
            
            printer.*,
        ')
        ->from('project')
        ->join('printer','printer.id_project = project.id','left')
        ->join('typeproject','typeproject.id = id_typeproject','left')
        ->join('bill','bill.id = id_bill','left')
        ->join('customer','customer.id = bill.id_customer','left')
        ->where('project.id',$id)
        ->order_by('project.created_at','desc');
        $query = $this->db->get();
        return $query->result_array();
    }
    function update_row($id,$data){
        $this->db->where('id',$id)
            ->update('project',$data);
    }

    function insert_row($data){
        $this->db->insert('project',$data);
        return $this->db->affected_rows();
    }
    public function updateStatus($id,$data)
    {
         $this->db->where('id',$id)
            ->update('project',$data);
    }

    function load_data_for_revenue($match){
        $this->db->select('
            id,
            created_at,
            project_name,
            tong_chiphi,
            thongtin_chiphi,
            tong_doanhthu,
            thongtin_doanhthu,
            thongtin_khachhang,
            thongtin_donhang'
        )
        ->from('project')
        ->where($match)
        ->order_by('project.created_at','desc');
        $query = $this->db->get();
        return $query->result_array();   
    }
}

