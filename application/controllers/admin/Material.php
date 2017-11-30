<?php 
class Material extends CI_Controller{

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
        $this->load->helper('date');
        $this->load->helper('string');
        date_default_timezone_set('Asia/Ho_Chi_Minh');
    }

    public function load_info_row(){
		$datatb = $this->db->list_fields('material');
		$data['form-data'] = '';
		foreach ($datatb as $key => $value) {
			switch ($value) {
				case 'name':
					$data['form-data'].='
	                <div class="form-group">
	                   	<div><b>Tên giấy</b></div>
	                 	<div class="input-group">
	                    	<div class="input-group-addon iga2">
	                       		<span class="fa fa-pencil-square"></span>
	                    	</div>
	                    <input type="text" class="form-control" name="'.$value.'" value="">
	                 	</div>
	                 	<div class="help-block" id="error-'.$value.'"></div>
	                </div>
	            	';
					break;
				case 'big_size':
					$data['form-data'].='
	                <div class="form-group">
	                   	<div><b>Kích thước</b></div>
	                 	<div class="input-group">
	                    	<div class="input-group-addon iga2">
	                       		<span class="fa fa-pencil-square"></span>
	                    	</div>
	                    <input type="text" class="form-control" name="'.$value.'" value="">
	                 	</div>
	                 	<div class="help-block" id="error-'.$value.'"></div>
	                </div>
	            	';
					break;
				case 'quantity':
					$data['form-data'].='
	                <div class="form-group">
	                   	<div><b>Số lượng</b></div>
	                 	<div class="input-group">
	                    	<div class="input-group-addon iga2">
	                       		<span class="fa fa-pencil-square"></span>
	                    	</div>
	                    <input type="number" class="form-control" name="'.$value.'" value="">
	                 	</div>
	                 	<div class="help-block" id="error-'.$value.'"></div>
	                </div>
	            	';
					break;
				case 'price':
					$data['form-data'].='
	                <div class="form-group">
	                   	<div><b>Đơn giá</b></div>
	                 	<div class="input-group">
	                    	<div class="input-group-addon iga2">
	                       		<span class="fa fa-pencil-square"></span>
	                    	</div>
	                    <input type="number" class="form-control" name="'.$value.'" value="">
	                 	</div>
	                 	<div class="help-block" id="error-'.$value.'"></div>
	                </div>
	            	';
					break;
				case 'description':
					$data['form-data'].='
	                <div class="form-group">
	                   	<div><b>Mô tả</b></div>
	                 	<div class="input-group">
	                    	<div class="input-group-addon iga2">
	                       		<span class="fa fa-pencil-square"></span>
	                    	</div>
	                    <textarea type="text" class="form-control" name="'.$value.'"></textarea>
	                 	</div>
	                 	<div class="help-block" id="error-'.$value.'"></div>
	                </div>
	            	';
					break;
				default:
					
					break;
			}
		}
		echo json_encode($data['form-data']);
	}

	public function load_data_row(){
		$id = $this->input->post('id');
		$datatb = $this->M_material->get_row($id);
		$data['form-data'] = '';
		$data['form-data'].= '<input type="hidden" name="id" value="'.$id.'">';
		unset(
			$datatb[0]['id'],
			$datatb[0]['created_at'],
			$datatb[0]['updated_at']
		);
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
	                </div>
	            	';
					break;
				case 'big_size':
					$data['form-data'].='
	                <div class="form-group">
	                   	<div><b>Kích thước</b></div>
	                 	<div class="input-group">
	                    	<div class="input-group-addon iga2">
	                       		<span class="fa fa-pencil-square"></span>
	                    	</div>
	                    <input type="text" class="form-control" name="'.$key.'" value="'.$value.'">
	                 	</div>
	                </div>
	            	';
					break;
				case 'quantity':
					$data['form-data'].='
	                <div class="form-group">
	                   	<div><b>Số lượng</b></div>
	                 	<div class="input-group">
	                    	<div class="input-group-addon iga2">
	                       		<span class="fa fa-pencil-square"></span>
	                    	</div>
	                    <input type="number" class="form-control" name="'.$key.'" value="'.$value.'">
	                 	</div>
	                </div>
	            	';
					break;
				case 'price':
					$data['form-data'].='
	                <div class="form-group">
	                   	<div><b>Đơn giá</b></div>
	                 	<div class="input-group">
	                    	<div class="input-group-addon iga2">
	                       		<span class="fa fa-pencil-square"></span>
	                    	</div>
	                    <input type="number" class="form-control" name="'.$key.'" value="'.$value.'">
	                 	</div>
	                </div>
	            	';
					break;
				case 'description':
					$data['form-data'].='
	                <div class="form-group">
	                   	<div><b>Mô tả</b></div>
	                 	<div class="input-group">
	                    	<div class="input-group-addon iga2">
	                       		<span class="fa fa-pencil-square"></span>
	                    	</div>
	                    <textarea type="text" class="form-control" name="'.$key.'">'.$value.'</textarea>
	                 	</div>
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
		$data = [];
		unset($frm['id']);
		if(!$this->M_material->update($id,$frm)){
			$data['success'] = "Updated successful!!!";
			$material = $this->M_material->get_row($id);
			unset(
				$material[0]['exc_size'],
				$material[0]['id'],
				$material[0]['exc_qty'],
				$material[0]['exc_price'],
				$material[0]['hidden'],
				$material[0]['remain'],
				$material[0]['created_at'],
				$material[0]['description']
			);
			$data['response'] = $material;
		} 
		else $data['fail'] = "Updated failure!!!";
		echo json_encode($data);
	}

	public function add_data_row(){
		$frm = $this->input->post();
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
        }else{
			if($id=$this->M_material->insert($frm)){
				$data['success'] = "Added successful!!!";
				$material = $this->M_material->get_row($id);
				unset(
					$material[0]['exc_size'],
					$material[0]['exc_qty'],
					$material[0]['exc_price'],
					$material[0]['hidden'],
					$material[0]['remain'],
					$material[0]['created_at'],
					$material[0]['description']
				);
				$data['response'] = $material;
			}
			else $data['fail'] = "Added failure!!!";
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