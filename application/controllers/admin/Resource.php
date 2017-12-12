<?php 
class Resource extends CI_Controller{

	public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('excel');
        $this->load->model(array('M_bill'));
        $this->load->model(array('M_data'));
        $this->load->model('M_department');
        $this->load->model('M_customer');
        $this->load->model('M_material');
        $this->load->model('M_cost');
        $this->load->model('M_debt');
        $this->load->model('M_receipt');
        $this->load->model('M_project');
        $this->load->model('M_revenue');
        $this->load->model('M_printer');
        $this->load->model('M_user');
        $this->load->model('M_task');
        $this->load->model('M_status');
        $this->load->model('M_resource');
        $this->load->helper('date');
        $this->load->helper('string');
        date_default_timezone_set('Asia/Ho_Chi_Minh');
    }

	public function load_data_row(){
		$id = $this->input->post('id');
		$table = $this->input->post('table');
		$datatb = $this->M_resource->get_row($id,$table);
		$data['form-data'] = '';
		$data['form-data'].= '<input type="hidden" name="id" value="'.$id.'">';
		$data['form-data'].= '<input type="hidden" name="table" value="'.$table.'">';
		unset($datatb[0]['id']);
		foreach ($datatb[0] as $key => $value) {
			switch ($key) {
				case 'name':
					$data['form-data'].='
	                <div class="form-group">
	                   	<div><b>Tên giấy</b></div>
	                 	<div class="input-group">
	                    	<div class="input-group-addon iga2">
	                       		<span class="fa fa-pencil-square"></span>
	                    	</div>
	                    <input type="text" class="form-control" name="'.$key.'" value="'.$value.'">
	                 	</div>
	                 	<div class="help-block" id="error-'.$key.'"></div>
	                </div>
	            	';
					break;
				case 'id':
					$data['form-data'].='
	                <div class="form-group">
	                   	<div><b>ID</b></div>
	                 	<div class="input-group">
	                    	<div class="input-group-addon iga2">
	                       		<span class="fa fa-pencil-square"></span>
	                    	</div>
	                    <input type="text" class="form-control" name="'.$key.'" value="'.$value.'">
	                 	</div>
	                 	<div class="help-block" id="error-'.$key.'"></div>
	                </div>
	            	';
					break;
				default:
					
					break;
			}
		}
		echo json_encode($data['form-data']);
	}
	public function update_data_row(){
		$frm = $this->input->post();
		$id = $frm['id'];
		$table = $frm['table'];
		$data = [];
		unset($frm['id'],$frm['table']);
		$this->M_resource->update($id,$frm,$table);
		$res = $this->M_resource->get_row($id,$table);
		unset(
			$res[0]['hidden']
		);
		$data['response'] = $res;
		echo json_encode($data);
	}

	public function add_data_row(){
		$frm = $this->input->post();
		$table = $frm['table'];
		unset($frm['table']);
		$data = [];
		$config = array();
		foreach ($frm as $key => $value) {
			switch ($key) {
			case '':
	
				break;
			default:
				array_push($config,array(
                    'field' => $key,
                    'label' => $key,
                    'rules' => 'required',
                    'errors' => array(
                    	'required'=>'Không được bỏ trống ô này.'
                    )
                ));
				break;
			}
		}
		$this->load->library('form_validation');
        $this->form_validation->set_rules($config);
        if($frm != null && $this->form_validation->run($frm) == FALSE)
        {
        	foreach ($frm as $key => $value){
        		$data['error'][$key] = form_error($key);
        	}
        }elseif ($this->M_data->record_exists(array('id'=>$frm['id']),'status')) {
        	$data['err'] = "ĐÃ tồn tại mã trạng thái.";
        }else{
			$this->M_resource->insert($frm,$table);
			$res = $this->M_resource->get_last_row($table);
			unset(
				$res[0]['description'],
				$res[0]['hidden'],
				$res[0]['class']
			);
			$data['response'] = $res;
		}
		echo json_encode($data);
	}

	public function del_row(){
		$id = $this->input->post('id');
		$match = array('hidden'=>1);
		if(!$this->M_material->update($id,$match)){
			echo json_encode('success');
		}else echo json_encode('error');
	}
}