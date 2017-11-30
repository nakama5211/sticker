<?php
class M_revenue extends CI_Model
{
	public function __construct()
    {
        parent::__construct();
    }
    function load_data_for_view_business($match=''){
        $this->db->select('
        		revenue.design as revenue_design,
                revenue.id,

        		bill.status,

        		customer.name as customer,

        		project.id as id_project,
        		project.revenue,
        		project.id_typeproject,

        		cost.print as cost_print,
        		cost.delivery as cost_delivery,
        		cost.outsourcing cost_outsourcing,
        		cost.paper as cost_paper,
        		')
        		->join('project','project.id = revenue.id_project','left')
        		->join('bill','bill.id = project.id_bill','left')
        		->join('customer','customer.id = bill.id_customer','left')
        		->join('cost','cost.id_project = revenue.id_project','left')
        		->from('revenue')
        		->where($match)
        		->order_by('revenue.id','desc');
        $query = $this->db->get();
        return $query->result_array();
    }
    function load_data_for_view_wedding($match=''){
        $this->db->select('
        		revenue.design as revenue_design,
                revenue.id_project,
                revenue.id,

        		bill.status,
        		bill.quantity,

        		customer.name as customer,
        		customer.id as customer_id,

        		project.revenue,
        		project.id_typeproject,

        		cost.print as cost_print,
        		cost.delivery as cost_delivery,
        		cost.outsourcing cost_outsourcing,
        		cost.paper as cost_paper,
        		')
        		->join('project','project.id = revenue.id_project','left')
        		->join('bill','bill.id = project.id_bill','left')
        		->join('customer','customer.id = bill.id_customer','left')
        		->join('cost','cost.id_project = revenue.id_project','left')
        		->from('revenue')
        		->where($match)
        		->order_by('revenue.id','desc');
        $query = $this->db->get();
        return $query->result_array();
    }
    function get_row_for_business($id){
    	$this->db->select('
                revenue.id,
                revenue.id_project,
                revenue.design as revenue_design,

                cost.print as cost_print,
                cost.delivery as cost_delivery,
                cost.outsourcing cost_outsourcing,
                cost.paper as cost_paper,
                ')
                ->join('cost','cost.id_project = revenue.id_project','left')
                ->from('revenue')
                ->where('revenue.id',$id);
        $query = $this->db->get();
        return $query->result_array();
    }
    function get_row_for_wedding($id){
        $this->db->select('
                revenue.id,
                revenue.design as revenue_design,
                revenue.outsourcing as revenue_outsourcing,
                revenue.molding as revenue_molding,

                cost.print as cost_print,
                cost.delivery as cost_delivery,
                cost.outsourcing cost_outsourcing,
                cost.paper as cost_paper,
                ')
                ->join('cost','cost.id_project = revenue.id_project','left')
                ->from('revenue')
                ->where('revenue.id',$id)
                ->order_by('revenue.id','desc');
        $query = $this->db->get();
        return $query->result_array();
    }
    function insert($data)
    {
        $this->db->insert('revenue', $data);
        return $this->db->insert_id();
    }
    function update($id,$data){
        $this->db->where('id',$id)
            ->update('revenue',$data);
    }
}
