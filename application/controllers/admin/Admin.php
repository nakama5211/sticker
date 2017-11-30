<?php

class Admin extends CI_Controller{

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
	function index(){
		if($this->session->userdata('user_id')){
			redirect(base_url().'admin/admin/view_admin/bill');
		}else{
			$data['csrf'] = array(
	        'name' => $this->security->get_csrf_token_name(),
	        'hash' => $this->security->get_csrf_hash()
			);
	        $this->load->view('admin/v_login',$data);
		}
	}

	public function tao_id_project($id_typeProject)
	{
		$id_project;
		$time = date('Y m d');
		$code = substr(str_replace(' ', '', trim($time)),2,6); 
		$type = $this->M_data->get_typeProject($id_typeProject);
		if (file_exists('./files/project_record.txt'))
		{
		    $file_content = (String)file_get_contents('./files/project_record.txt');
		    $record = explode(";", trim($file_content));
		   	$last_record = trim($record[count($record)-1]);
		   	$old_month = substr($last_record,3,2);
		   	$this_month = substr($code,2,2);
		   	if(strcmp($old_month, $this_month)!=0){
		   		$number = '001';
		   	}else{
		   		$number = (int)(substr($last_record, 7,3));
		   		$number+= 1;
		   		if($number<10){
		   			$number = '00'.(String)($number);
		   		}else if($number<100){
		   			$number = '0'.(String)($number);
		   		}else{
		   			$number = (String)($number);
		   		}
		   	}
		   	$id_project = $type[0]['code'].$code.$number;
		 
			// fclose($file_recent);

		}else{
			echo('File not found!');
			$id_project = "";
		}
		return $id_project;
	}
	function view_admin($view=''){
		if($this->session->userdata('user_id')){
			switch ($this->session->userdata('group')){
				case'1':{
		            $category['category'] = array(
		            	'bill'=> array(
		            		'name'=>'Đơn hàng',
		            		'link'=>'admin/view_admin/bill',
		            		'icon'=>'fa fa-object-group'
		            	),
		            	'project'=> array(
		            		'name'=>'Quản lý Dự án',
		            		'link'=>'admin/view_admin/project',
		            		'icon'=>'fa fa-archive'
		            	),
		            	'revenue'=>array(
		            		'type'=>'tree',
		            		'name'=>'Quản lý Doanh thu',
		            		'content'=>array(
		            			'business'=>array(
		            				'name'=>'Doanh nghiệp',
		            				'link'=>'admin/view_admin/business'
		            			),
		            			
		            		),
		            		'icon'=>'fa fa-briefcase'
		            	),
		            	'material'=>array(
		            		'name'=>'Quản lý Giấy',
		            		'link'=>'admin/view_admin/material',
		            		'icon'=>'fa fa-database'
		            	),
		            	'print'=>array(
		            		'name'=>'Quản lý In',
		            		'link'=>'admin/view_admin/print',
		            		'icon'=>'fa fa-print'
		            	),
		            	'resource'=>array(
		            		'type'=>'tree',
		            		'name'=>'Quản lý Dữ liệu',
		            		'content'=>array(
		            			'outsouce'=>array(
		            				'name'=>'Gia Công',
		            				'link'=>'admin/view_admin/outsouce'
		            			),
		            			'status'=>array(
		            				'name'=>'Trạng thái',
		            				'link'=>'admin/view_admin/status'
		            			),
		            		),
		            		'icon'=>'fa fa-table'
		            	),
		            ); 
					switch ($view) {
						case 'bill':
							$match = array(
								'bill.hidden'=>0,
							);
							$data['button'] = array(
				            	'add'=> array(
				            		'name'=>'Thêm mới',
				            		'icon'=>'fa fa-object-group'
				            	),
				            	'edit'=> array(
				            		'name'=>'Cập nhật',
				            		'icon'=>'fa fa-object-group'
				            	),
				            	'delete'=> array(
				            		'name'=>'Xóa',
				            		'icon'=>'fa fa-archive'
				            	),
				            	'create'=> array(
				            		'name'=>'Tạo dự án',
				            		'icon'=>'fa fa-archive'
				            	),
				            	'confirm'=> array(
				            		'name'=>'Xác nhận',
				            		'icon'=>'fa fa-archive'
				            	),
				            );
							$category['active'][$view] = 'active';
							$data['department'] = $this->M_department->load_all_department();
							$data['typeproject'] = $this->M_data->load_typeProject();
							$data['classproject'] = $this->M_data->load_class();
		            		$data['bill'] = $this->M_bill->load_bill($match);
							$this->_data['html_body'] = $this->load->view('admin/v_bill',$data, TRUE);
							break;
						case 'project':
							$match = array(
								'project.hidden'=>0,
							);
							$category['active'][$view] = 'active';
							$data['department'] = $this->M_department->load_all_department();
		            		$data['project'] = $this->M_project->load_project($match);
		            		$data['typeproject'] = $this->M_data->load_typeProject();
		            		$data['status'] = $this->M_status->load_status_by_type('project');
		            		$data['classproject'] = $this->M_data->load_class();
							$this->_data['html_body'] = $this->load->view('admin/v_project',$data, TRUE);
							break;
						case 'business':
							$match = array(
								'id_typeproject'=>1,
								'hidden'=>0
							);
							$category['active']['revenue'][0] = 'active';
							$category['active']['revenue'][$view] = 'fa fa-circle-o';
							$data['department'] = $this->M_department->load_all_department();
							$data['status'] = $this->M_status->load_status_by_type('project');
							$data['typeproject'] = $this->M_data->load_typeProject();
							$revenue = $this->M_project->load_data_for_revenue($match);
							for($i=0; $i<count($revenue);$i++){
								$data['revenue'][$i]['tong_chiphi'] = $revenue[$i]['tong_chiphi'];
			            		$data['revenue'][$i]['id'] = $revenue[$i]['id'];
			            		$data['revenue'][$i]['project_name'] = $revenue[$i]['project_name'];
			            		$data['revenue'][$i]['created_at'] = $revenue[$i]['created_at'];
			            		$data['revenue'][$i]['tong_doanhthu'] = $revenue[$i]['tong_doanhthu'];
			            		foreach (json_decode($revenue[$i]['thongtin_chiphi'],true) as $key => $value) {
			            			$data['revenue'][$i][$key] = $value;
			            		}
			            		foreach (json_decode($revenue[$i]['thongtin_doanhthu'],true) as $key => $value) {
			            			$data['revenue'][$i][$key] = $value;
			            		}
			            		foreach (json_decode($revenue[$i]['thongtin_khachhang'],true) as $key => $value) {
			            			$data['revenue'][$i][$key] = $value;
			            		}
			            		foreach (json_decode($revenue[$i]['thongtin_donhang'],true) as $key => $value) {
			            			$data['revenue'][$i][$key] = $value;
			            		}
							}
							$this->_data['html_body'] = $this->load->view('admin/v_revenue_business',$data, TRUE);
							break;
						case 'wedding':
							$match = array(
								'id_typeproject'=>2,
								'hidden'=>0
							);
							$category['active']['revenue'][0] = 'active';
							$category['active']['revenue'][$view] = 'fa fa-circle-o';
							$data['department'] = $this->M_department->load_all_department();
							$data['status'] = $this->M_status->load_status_by_type('project');
		            		$revenue = $this->M_project->load_data_for_revenue($match);
							for($i=0; $i<count($revenue);$i++){
								$data['revenue'][$i]['created_at'] = $revenue[$i]['created_at'];
								$data['revenue'][$i]['tong_chiphi'] = $revenue[$i]['tong_chiphi'];
			            		$data['revenue'][$i]['id'] = $revenue[$i]['id'];
			            		$data['revenue'][$i]['tong_doanhthu'] = $revenue[$i]['tong_doanhthu'];
			            		foreach (json_decode($revenue[$i]['thongtin_chiphi'],true) as $key => $value) {
			            			$data['revenue'][$i][$key] = $value;
			            		}
			            		foreach (json_decode($revenue[$i]['thongtin_doanhthu'],true) as $key => $value) {
			            			$data['revenue'][$i][$key] = $value;
			            		}
			            		foreach (json_decode($revenue[$i]['thongtin_khachhang'],true) as $key => $value) {
			            			$data['revenue'][$i][$key] = $value;
			            		}
			            		foreach (json_decode($revenue[$i]['thongtin_donhang'],true) as $key => $value) {
			            			$data['revenue'][$i][$key] = $value;
			            		}
							}
							$this->_data['html_body'] = $this->load->view('admin/v_revenue_wedding',$data, TRUE);
							break;
						case 'material':
							$match = array(
								'material.hidden'=>0,
							);
							$data['button'] = array(
				            	'add'=> array(
				            		'name'=>'Thêm mới',
				            		'icon'=>'fa fa-object-group'
				            	),
				            	'edit'=> array(
				            		'name'=>'Cập nhật',
				            		'icon'=>'fa fa-object-group'
				            	),
				            	'delete'=> array(
				            		'name'=>'Xóa',
				            		'icon'=>'fa fa-archive'
				            	),
				            );
							$category['active']['material'] = 'active';
							$data['department'] = $this->M_department->load_all_department();
		            		$data['material'] = $this->M_material->load_data($match);
							$this->_data['html_body'] = $this->load->view('admin/v_material',$data, TRUE);
							break;
						case 'print':
							$match = array(
								'printer.hidden'=>0,
							);
							$category['active'][$view] = 'active';
							$data['department'] = $this->M_department->load_all_department();
		            		$data['print'] = $this->M_printer->load_data($match);
							$this->_data['html_body'] = $this->load->view('admin/v_print',$data, TRUE);
							break;
						case 'outsouce':
							$match = array(
								'hidden'=>0,
							);
							$category['active']['resource'][0] = 'active';
							$category['active']['resource'][$view] = 'fa fa-circle-o';
		            		$data['outsource'] = $this->M_resource->load_data($match,'gia_cong');
							$this->_data['html_body'] = $this->load->view('admin/data_table/v_data_outsource',$data, TRUE);
							break;
						case 'status':
							$match = array(
								'hidden'=>0,
							);
							$category['active']['resource'][0] = 'active';
							$category['active']['resource'][$view] = 'fa fa-circle-o';
							$data['status'] = $this->M_resource->load_data($match,'status');
							$this->_data['html_body'] = $this->load->view('admin/data_table/v_data_status',$data, TRUE);
							break;
						default:
							
							break;
					}
					// Load view header        
					$this->_data['html_header'] = $this->load->view('admin/header', $category, TRUE);
					// Load  footer       
					$this->_data['html_footer'] = $this->load->view('admin/footer', NULL, TRUE);
					// Load view method_one_view        
					$this->load->view('admin/master', $this->_data);
					// var_dump($data['revenue']);
					break;
				}
		        case'2':{
		            $category['category'] = array(
		            	'bill'=> array(
		            		'name'=>'Đơn hàng',
		            		'link'=>'admin/view_admin/bill',
		            		'icon'=>'fa fa-object-group'
		            	),
		            	'revenue'=>array(
		            		'type'=>'tree',
		            		'name'=>'Quản lý Doanh thu',
		            		'content'=>array(
		            			'business'=>array(
		            				'name'=>'Doanh nghiệp',
		            				'link'=>'admin/view_admin/business'
		            			),
		            			'wedding'=>array(
		            				'name'=>'Thiệp cưới',
		            				'link'=>'admin/view_admin/wedding'
		            			),
		            		),
		            		'icon'=>'fa fa-briefcase'),
		            	'material'=>array(
		            		'name'=>'Quản lý Giấy',
		            		'link'=>'admin/view_admin/material',
		            		'icon'=>'fa fa-database'
		            	),
		            );         
					switch ($view) {
						case 'bill':
							$match = array(
								'task.hidden'=>0,
								'task.id_user'=>$this->session->userdata('user_id'),
								'task.status!='=>'t001',
								'task.status!='=>'t004',
							);
							$data['button'] = array(
				            	'upfile'=> array(
				            		'name'=>'Chốt file',
				            		'icon'=>'fa fa-archive'
				            	),
				            );
							$category['active'][$view] = 'active';
							$data['department'] = $this->M_department->load_all_department();
							$data['typeproject'] = $this->M_data->load_typeProject();
							$data['classproject'] = $this->M_data->load_class();
		            		$data['bill'] = $this->M_bill->load_my_task_bill($match);
							$this->_data['html_body'] = $this->load->view('admin/v_bill',$data, TRUE);
							break;
						case 'business':
							$match = array(
								'id_typeproject'=>1,
								'hidden'=>0
							);
							$category['active']['revenue'][0] = 'active';
							$category['active']['revenue'][$view] = 'fa fa-circle-o';
							$data['department'] = $this->M_department->load_all_department();
		            		$data['revenue'] = $this->M_project->load_data_for_revenue($match);
							$this->_data['html_body'] = $this->load->view('admin/v_revenue_business',$data, TRUE);
							break;
						case 'wedding':
							$match = array(
								'id_typeproject'=>2,
								'hidden'=>0
							);
							$category['active']['revenue'][0] = 'active';
							$category['active']['revenue'][$view] = 'fa fa-circle-o';
							$data['department'] = $this->M_department->load_all_department();
		            		$data['revenue'] = $this->M_revenue->load_data_for_view_wedding($match);
							$this->_data['html_body'] = $this->load->view('admin/v_revenue_wedding',$data, TRUE);
							break;
						case 'material':
							$match = array(
								'project.hidden'=>0,
							);
							$category['active']['material'] = 'active';
							$data['department'] = $this->M_department->load_all_department();
		            		$data['material'] = $this->M_material->load_data();
							$this->_data['html_body'] = $this->load->view('admin/v_material',$data, TRUE);
							break;
						default:
							
							break;
					}
					// Load view header        
					$this->_data['html_header'] = $this->load->view('admin/header', $category, TRUE);
					// Load  footer       
					$this->_data['html_footer'] = $this->load->view('admin/footer', NULL, TRUE);
					// Load view method_one_view        
					$this->load->view('admin/master', $this->_data);
					// var_dump($data['revenue']);
					break;
		        }
		        case'3':{
		            $category['category'] = array(
		            	'task'=> array(
		            		'name'=>'My Task',
		            		'link'=>'admin/view_admin/task',
		            		'icon'=>'fa fa-object-group'
		            	),
		            	'print'=>array(
		            		'name'=>'Quản lý In',
		            		'link'=>'admin/view_admin/print',
		            		'icon'=>'fa fa-print'
		            	),
		            ); 
					switch ($view) {
						case 'task':
							$match['newtask'] = array(
								'task.hidden'=>0,
								'task.status'=>'t001',
								'task.id_user'=>$this->session->userdata('user_id'),
							);
							$match['oldtask'] = array(
								'task.hidden'=>0,
								'task.status!='=>'t001',
								'task.id_user'=>$this->session->userdata('user_id'),
							);
							$category['active'][$view] = 'active';
							$data['department'] = $this->M_department->load_all_department();
		            		$data['newtask'] = $this->M_task->load_data($match['newtask']);
		            		$data['oldtask'] = $this->M_task->load_data($match['oldtask']);
							$this->_data['html_body'] = $this->load->view('admin/v_task',$data, TRUE);
							break;
						case 'print':
							$match = array(
								'printer.hidden'=>0,
								'printer.id_user'=>$this->session->userdata('user_id'),
							);
							$category['active'][$view] = 'active';
							$data['department'] = $this->M_department->load_all_department();
		            		$data['print'] = $this->M_printer->load_data($match);
							$this->_data['html_body'] = $this->load->view('admin/v_print',$data, TRUE);
							break;
						default:
							
							break;
					}
					// Load view header        
					$this->_data['html_header'] = $this->load->view('admin/header', $category, TRUE);
					// Load  footer       
					$this->_data['html_footer'] = $this->load->view('admin/footer', NULL, TRUE);
					// Load view method_one_view        
					$this->load->view('admin/master', $this->_data);
					//var_dump($data['print']);
					break;
		        }
		        case'4':{
		            $category['category'] = array(
		            	'task'=> array(
		            		'name'=>'My Task',
		            		'link'=>'admin/view_admin/task',
		            		'icon'=>'fa fa-object-group'
		            	),
		            	'bill'=> array(
		            		'name'=>'Đơn hàng',
		            		'link'=>'admin/view_admin/bill',
		            		'icon'=>'fa fa-object-group'
		            	),
		            	'project'=> array(
		            		'name'=>'Quản lý Dự án',
		            		'link'=>'admin/view_admin/project',
		            		'icon'=>'fa fa-archive'
		            	),
		            ); 
					switch ($view) {
						case 'task':
							$match['newtask'] = array(
								'task.hidden'=>0,
								'task.status'=>'t001',
								'task.id_user'=>$this->session->userdata('user_id'),
							);
							$match['oldtask'] = array(
								'task.hidden'=>0,
								'task.status!='=>'t001',
								'task.id_user'=>$this->session->userdata('user_id'),
							);
							$category['active'][$view] = 'active';
							$data['department'] = $this->M_department->load_all_department();
		            		$data['newtask'] = $this->M_task->load_data($match['newtask']);
		            		$data['oldtask'] = $this->M_task->load_data($match['oldtask']);
							$this->_data['html_body'] = $this->load->view('admin/v_task',$data, TRUE);
							break;
						case 'bill':
							$match = array(
								'task.hidden'=>0,
								'task.id_user'=>$this->session->userdata('user_id'),
								'task.status!='=>'t001',
								'task.status!='=>'t004',
							);
							$data['button'] = array(
				            	'upfile'=> array(
				            		'name'=>'Chốt file',
				            		'icon'=>'fa fa-archive'
				            	),
				            );
							$category['active'][$view] = 'active';
							$data['department'] = $this->M_department->load_all_department();
							$data['typeproject'] = $this->M_data->load_typeProject();
							$data['classproject'] = $this->M_data->load_class();
		            		$data['bill'] = $this->M_bill->load_my_task_bill($match);
							$this->_data['html_body'] = $this->load->view('admin/v_bill',$data, TRUE);
							break;
						case 'project':
							$match = array(
								'task.hidden'=>0,
								'task.id_user'=>$this->session->userdata('user_id'),
								'task.status!='=>'t004',
							);
							$category['active'][$view] = 'active';
							$data['department'] = $this->M_department->load_all_department();
		            		$data['bill'] = $this->M_project->load_my_task_project($match);
		            		$data['classproject'] = $this->M_data->load_class();
							$this->_data['html_body'] = $this->load->view('admin/v_project',$data, TRUE);
							break;
						default:
							
							break;
					}
					// Load view header        
					$this->_data['html_header'] = $this->load->view('admin/header', $category, TRUE);
					// Load  footer       
					$this->_data['html_footer'] = $this->load->view('admin/footer', NULL, TRUE);
					// Load view method_one_view        
					$this->load->view('admin/master', $this->_data);
					//var_dump($data['print']);
					break;
		        }
		        default:{
		            $data['bill'] = $this->M_bill->load_all_bill();
					$this->load->view('admin/header');
					$this->load->view('admin/v_bill',$data);
					$this->load->view('admin/footer');
					break;
		        }
	    	}
	    }else redirect(base_url().'admin/admin/');
	}



	function add_bill(){
		$data['typedecal'] = $this->M_data->load_typeDecal();
		$data['extrusion'] = $this->M_data->load_extrusion();
		$data['unit'] = $this->M_data->load_unit();
		$data['csrf'] = array(
        'name' => $this->security->get_csrf_token_name(),
        'hash' => $this->security->get_csrf_hash()
		);
		$category['category'] = array(
            	'bill'=> array(
            		'name'=>'Đơn hàng',
            		'link'=>'admin/view_admin/bill',
            		'icon'=>'fa fa-object-group'
            	),
            	'project'=> array(
            		'name'=>'Quản lý Dự án',
            		'link'=>'admin/view_admin/project',
            		'icon'=>'fa fa-archive'
            	),
            	'revenue'=>array(
            		'type'=>'tree',
            		'name'=>'Quản lý Doanh thu',
            		'content'=>array(
            			'business'=>array(
            				'name'=>'Doanh nghiệp',
            				'link'=>'admin/view_admin/business'
            			),
            			
            		),
            		'icon'=>'fa fa-briefcase'),
            	'material'=>array(
            		'name'=>'Quản lý Giấy',
            		'link'=>'admin/view_admin/material',
            		'icon'=>'fa fa-database'
            	),
            	'print'=>array(
            		'name'=>'Quản lý In',
            		'link'=>'admin/view_admin/print',
            		'icon'=>'fa fa-print'
            	),
            ); 
		// Load view header        
		$this->_data['html_header'] = $this->load->view('admin/header', $category, TRUE);        
		// Load  footer        
		$this->_data['html_footer'] = $this->load->view('admin/footer', NULL, TRUE);
		        // Load view method_one_view        
		$this->_data['html_body'] = $this->load->view('admin/v_new_bill',$data, TRUE);

		$this->load->view('admin/master', $this->_data);
	}

	function add_project(){
		$data['typedecal'] = $this->M_data->load_typeDecal();
		$data['extrusion'] = $this->M_data->load_extrusion();
		$data['unit'] = $this->M_data->load_unit();
		$data['csrf'] = array(
        'name' => $this->security->get_csrf_token_name(),
        'hash' => $this->security->get_csrf_hash()
		);
		$category['category'] = array(
            	'bill'=> array(
            		'name'=>'Đơn hàng',
            		'link'=>'admin/view_admin/bill',
            		'icon'=>'fa fa-object-group'
            	),
            	'project'=> array(
            		'name'=>'Quản lý Dự án',
            		'link'=>'admin/view_admin/project',
            		'icon'=>'fa fa-archive'
            	),
            	'revenue'=>array(
            		'type'=>'tree',
            		'name'=>'Quản lý Doanh thu',
            		'content'=>array(
            			'business'=>array(
            				'name'=>'Doanh nghiệp',
            				'link'=>'admin/view_admin/business'
            			),
            			
            		),
            		'icon'=>'fa fa-briefcase'),
            	'material'=>array(
            		'name'=>'Quản lý Giấy',
            		'link'=>'admin/view_admin/material',
            		'icon'=>'fa fa-database'
            	),
            	'print'=>array(
            		'name'=>'Quản lý In',
            		'link'=>'admin/view_admin/print',
            		'icon'=>'fa fa-print'
            	),
            ); 
		// Load view header        
		$this->_data['html_header'] = $this->load->view('admin/header', $category, TRUE);        
		// Load  footer        
		$this->_data['html_footer'] = $this->load->view('admin/footer', NULL, TRUE);
		        // Load view method_one_view        
		$this->_data['html_body'] = $this->load->view('admin/v_add_project',$data, TRUE);

		$this->load->view('admin/master', $this->_data);
	}

	function edit_bill($id){
		$data['typedecal'] = $this->M_data->load_typeDecal();
		$data['extrusion'] = $this->M_data->load_extrusion();
		$data['unit'] = $this->M_data->load_unit();
		$data['bill'] = $this->M_bill->get_bill($id);
		$data['csrf'] = array(
        'name' => $this->security->get_csrf_token_name(),
        'hash' => $this->security->get_csrf_hash()
		);
		$category['category'] = array(
            	'bill'=> array(
            		'name'=>'Đơn hàng',
            		'link'=>'admin/view_admin/bill',
            		'icon'=>'fa fa-object-group'
            	),
            	'project'=> array(
            		'name'=>'Quản lý Dự án',
            		'link'=>'admin/view_admin/project',
            		'icon'=>'fa fa-archive'
            	),
            	'revenue'=>array(
            		'type'=>'tree',
            		'name'=>'Quản lý Doanh thu',
            		'content'=>array(
            			'business'=>array(
            				'name'=>'Doanh nghiệp',
            				'link'=>'admin/view_admin/business'
            			),
            			
            		),
            		'icon'=>'fa fa-briefcase'),
            	'material'=>array(
            		'name'=>'Quản lý Giấy',
            		'link'=>'admin/view_admin/material',
            		'icon'=>'fa fa-database'
            	),
            	'print'=>array(
            		'name'=>'Quản lý In',
            		'link'=>'admin/view_admin/print',
            		'icon'=>'fa fa-print'
            	),
            ); 
		// Load view header        
		$this->_data['html_header'] = $this->load->view('admin/header', $category, TRUE);        
		// Load  footer        
		$this->_data['html_footer'] = $this->load->view('admin/footer', NULL, TRUE);
		        // Load view method_one_view        
		$this->_data['html_body'] = $this->load->view('admin/v_update_bill',$data, TRUE);

		$this->load->view('admin/master', $this->_data);
	}

	function insert_bill(){
		$post = $this->input->post();
		// var_dump($post);
		// var_dump($_FILES['file']);
		if (!empty($_FILES['file']['name'])) {
        $config['upload_path'] = './upload/';
        $config['allowed_types'] = 'jpg|jpeg|png|gif';
        $config['file_name'] = $_FILES['file']['name'];

        $this->load->library('upload', $config);
        $this->upload->initialize($config);

        if ($this->upload->do_upload('file')) {
          $uploadData = $this->upload->data();
          $data["image"] = $uploadData['file_name'];
          echo "file upload success!! ";
        } else{
          $data["image"] = '';
          $data["error"] = $this->upload->display_errors();
          //var_dump($data);
        }
      	}else{
        $data["image"] = '';
      	}
      
		$bill['customer'] = array(
			'name'=>$post['customer'],
			'email'=>$post['email'],
			'phone'=>$post['phone'],
			'address'=>$post['address'],
		);
		$id_customer = $this->M_customer->insert_customer($bill['customer']);
		$bill['bill'] = array(
			'id_customer'=>$id_customer,
			'id_typedecal'=>$post['id_typedecal'],
			'id_extrusion'=>$post['id_extrusion'],
			'width'=>$post['width'],
			'height'=>$post['height'],
			'quantity'=>$post['quantity'],
			'file'=>$data['image'],
			'status'=>'b002',
			'note'=>$post['note'],
			'unit'=>$post['unit'],
		);
		$id_bill = $this->M_bill->insert_bill($bill['bill']);
		if($id_bill!=0){
			$this->session->set_userdata('success',"Thêm thành công!!");
			redirect(base_url().'admin/admin/view_admin/bill');
		}
		else{
			$log['error']="Thêm Thất bại!!";
			redirect(base_url().'admin/admin/add_bill/'.$post['id'],$log);
		} 
	}
	function update_bill(){
		$post = $this->input->post();
		// var_dump($post);
		// var_dump($_FILES['file']);
		if (!empty($_FILES['file']['name'])) {
        $config['upload_path'] = './upload/';
        $config['allowed_types'] = 'jpg|jpeg|png|gif';
        $config['file_name'] = $_FILES['file']['name'];

        $this->load->library('upload', $config);
        $this->upload->initialize($config);

        if ($this->upload->do_upload('file')) {
          $uploadData = $this->upload->data();
          $data["image"] = $uploadData['file_name'];
          echo "file upload success!! ";
        } else{
          $data["image"] = '';
          $data["error"] = $this->upload->display_errors();
          //var_dump($data);
        }
      	}else{
        $data["image"] = '';
      	}
      
		$bill['customer'] = array(
			'name'=>$post['customer'],
			'email'=>$post['email'],
			'phone'=>$post['phone'],
			'address'=>$post['address'],
		);
		$this->M_customer->update_customer($post['id_customer'],$bill['customer']);
		$bill['bill'] = array(
			'id_typedecal'=>$post['id_typedecal'],
			'id_extrusion'=>$post['id_extrusion'],
			'width'=>$post['width'],
			'height'=>$post['height'],
			'quantity'=>$post['quantity'],
			'file'=>$data['image'],
			'note'=>$post['note'],
			'unit'=>$post['unit'],
		);
		if($data['image']==''){
			unset($bill['bill']['file']);
		}
		
		if(!$this->M_bill->update_bill($post['id'],$bill['bill'])){
			$this->session->set_userdata('success',"Thay đổi thành công!!");
			redirect(base_url().'admin/admin/view_admin/bill');
		}
		else{
			$log['error']="Update Thất bại!!";
			redirect(base_url().'admin/admin/edit_bill/'.$post['id'],$log);
		} 
	}

	
	function change_status(){
		$id = $this->input->post('id');
		$status = $this->input->post('status');
		$update = array('status'=>$status); 
		$this->M_bill->update_bill($id,$update);
		$newstt = $this->M_status->get_status_name($status);
		if($status=='b002'){
			$data['button'] = '<button class="btn btn-info btn-lg glyphicon glyphicon-hand-right" style="border-radius: 10px;" onclick="checkRow('. $id .')">
              	</button> <button class="btn btn-primary btn-lg glyphicon glyphicon-edit" style="border-radius: 10px;" onclick="editRow('. $id .')">
              	</button> <button class="btn btn-warning btn-lg glyphicon glyphicon-trash" style="border-radius: 10px;" onclick="cancelRow('. $id .')">
              	</button> ';
		}
		$data['status'] = $newstt[0]['name'];
		$data['success'] = 'Thành công.';
		echo json_encode($data);
	}

	function cancel_bill(){
		$id = $this->input->post('id');
		$data = array('hidden' => 1);
		$this->M_bill->update_bill($id,$data);
	}

	function get_department_list(){
		$group = $this->input->post('group');
		$department = $this->M_department->load_all_department();
		$data['opt-depart'] = '';
        foreach ($department as $dep) {
        	if($dep['id']==$group) continue;
            $data['opt-depart'].= '
            	
                <div class="input-group">
                    <span class="input-group-addon beautiful">
                        <input type="checkbox">
                    </span>
                    <input type="text" class="form-control">
                </div>
            
            ';
        }
        echo json_encode($data['opt-depart']);                       
	}
	function new_bill(){
		$time = $this->input->get('time');
		$bill = $this->M_bill->get_new_bill($time);
		date_default_timezone_set('Asia/Ho_Chi_Minh');
		$t1 = now('Asia/Ho_Chi_Minh');
		$data['notif'] = '';
		$data['count_bill'] = count($bill);
		if($data['count_bill']>0){
			$data['notif'] .= '<li class="not-head">Bạn có '.count($bill).' hóa đơn mới!!</li>';
			foreach ($bill as $bil) {
			$t2 = strtotime($bil['created_at']);
    		$datetime1 = new DateTime(date('Y-m-d H:i:s', $t2));
			$datetime2 = new DateTime(date('Y-m-d H:i:s',$t1));
			$oDiff = $datetime1->diff($datetime2);
			// $oDiff->y.' Years <br/>';
			// $oDiff->m.' Months <br/>';
			// $oDiff->d.' Days <br/>';
			// $oDiff->h.' Hours <br/>';
			// $oDiff->i.' Minutes <br/>';
			// $oDiff->s.' Seconds <br/>';

			if($oDiff->d>0) $t=$oDiff->d.' Days ago<br/>';
			else if($oDiff->h>0) $t=$oDiff->h.' Hours ago<br/>';
			else if($oDiff->i>0) $t=$oDiff->i.' Minutes ago<br/>';
			else $t=$oDiff->s.' Seconds ago<br/>';
    		
			$data['notif'].='<li><a class="media" href="javascript:void(0)"><span class="media-left media-icon"><span class="fa-stack fa-lg"><i class="fa fa-circle fa-stack-2x text-primary"></i><i class="fa fa-envelope fa-stack-1x fa-inverse"></i></span></span><div class="media-body"><span class="block">'.$bil['customer'].' vừa đặt hàng!</span><span class="text-muted block">'.$t.'</span></div></a></li>';
			}
			$data['notif'] .= '<li class="not-footer"><a href="#">Xem tất cả thông báo.</a></li>';
		}
		echo json_encode($data);
	}

	function exp_file(){
		$id = $this->input->post('id');
		$type = $this->input->post('type');
		$receipt = $this->M_receipt->get_row($id);
		//var_dump($bill);

		$object = new PHPExcel();
        $objReader = PHPExcel_IOFactory::createReader('Excel2007');
        $objPHPExcel = $objReader->load('files/mau_phieu_thu.xlsx');

        $objWorksheet  = $objPHPExcel->setActiveSheetIndex(0);
        $highestRow    = $objWorksheet->getHighestRow();
        $highestColumn = $objWorksheet->getHighestColumn();
        $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
        $array = array();
        $k=1;
        for ($row = 2; $row <= $highestRow;++$row)
        {
            for ($col = 0; $col <$highestColumnIndex-1;++$col)
            {
                $value=$objWorksheet->getCellByColumnAndRow($col, $row)->getValue();
                
                if (substr($value, 0,2) == '${' && substr($value,-1) == '}') {    //tim nhung chuoi co chu vung
                	$value = trim($value,'${ }');
                	$mData = explode(";", $value);
                	if ($mData[1] == "text") {
                		$mData[1] = "textarea";
                	}
                    $array[$k] =array(
                    	'id'=>$k, 
                    	'ten'=>$mData[0],
                    	'loai'=>$mData[1], 
                    	'cot'=>$col, 
                    	'hang'=>$row
                    );
                    $k++;
                }
            }
        }
        var_dump($array);
	}

	function create_project(){
		$post = $this->input->post();
		$bill = $this->M_bill->get_bill($post['id']);
		$data = [];
		$class = '';
		$time = date('Y m d');
		$code = substr(str_replace(' ', '', trim($time)),2,6); 
		$type = $this->M_data->get_typeProject($post['type_project']);
		if(isset($post['checked_list'])){
			foreach ($post['checked_list'] as $key => $value) {
				$class.=$value.';';
			}
		}
		if (file_exists('./files/project_record.txt'))
		{
		    $file_content = (String)file_get_contents('./files/project_record.txt');
		    $record = explode(";", trim($file_content));
		   	$last_record = trim($record[count($record)-1]);
		   	$old_month = substr($last_record,3,2);
		   	$this_month = substr($code,2,2);
		   	if(strcmp($old_month, $this_month)!=0){
		   		$number = '001';
		   	}else{
		   		$number = (int)(substr($last_record, 7,3));
		   		$number+= 1;
		   		if($number<10){
		   			$number = '00'.(String)($number);
		   		}else if($number<100){
		   			$number = '0'.(String)($number);
		   		}else{
		   			$number = (String)($number);
		   		}
		   	}
		   	$id_project = $type[0]['code'].$code.$number;
		   	$file_recent = fopen("./files/project_record.txt", "a+");
			fwrite($file_recent, ';'.$id_project);
			fclose($file_recent);
		   	$project = array(
				'id'=>$id_project,
				'id_typeproject'=>$post['type_project'],
				'id_bill'=>$post['id'],
				'class'=>$class,
				'status'=>'0',
				'contact_by'=>$post['contact_by'],
				'dead_line'=>$post['dead_line'],
				'revenue'=>($bill[0]['typedecal_price']+$bill[0]['extrusion_price'])*$bill[0]['quantity'],
				'cost'=>'0',
			);
			if($this->M_project->insert_row($project)){
				$match = array(
					'id_project'=>$id_project,
				);
				$this->M_cost->insert($match);
				$this->M_revenue->insert($match);
				$this->M_bill->update_bill($post['id'],array('status'=>'b003'));
				$newstt = $this->M_status->get_status_name('b003');
				$data['button'] = '<button class="btn btn-primary btn-lg glyphicon glyphicon-edit" style="border-radius: 10px;" onclick="editRow('. $post['id'] .')">
	                              </button> ';
				$data['status'] = $newstt[0]['name'];
				$data['success'] = 'Thành công!';
			}else{
				$data['error'] = 'Thất bại!';
			}
		}else {
			echo('File not found!');
			$data['error'] = 'Thất bại!';
		}
		echo json_encode($data);
	}
	function load_list_user(){
		$id = $this->input->post('id');
		$match = array(
			'group'=>$id,
			'hidden'=>0,
		);
		$data = [];
		$list_user = $this->M_user->load_data($match);
		$data['list-user'] = '<option value="" hidden="" disabled="" selected="">Chọn nhân viên</option>';
		foreach ($list_user as $key => $value) {
			$data['list-user'].='<option value="'.$value['id'].'">'.$value['username'].'</option>';
		}
		echo json_encode($data);
	}

	function select_final_file(){
		$id = $this->input->post('id');
		if (!empty($_FILES['file']['name'])) {
	        $config['upload_path'] = './upload/';
	        $config['allowed_types'] = 'jpg|jpeg|png|gif';
	        $config['file_name'] = $_FILES['file']['name'];

	        $this->load->library('upload', $config);
	        $this->upload->initialize($config);

	        if ($this->upload->do_upload('file')) {
	          $uploadData = $this->upload->data();
	          $data["image"] = $uploadData['file_name'];
	          $data['scs'] = "file upload success!! ";
	        } else{
	          $data["image"] = '';
	          $data["err"] = $this->upload->display_errors();
	        }
      	}else{
        $data["image"] = '';
      	}
      	if($data['image']!=''){
      		$file_req = array('file'=>$data['image']);
      		$this->M_bill->update_bill($id,$file_req);
      		$data['file_res'] = $this->M_bill->get_file($id);
      		$data['success'] = "Thành công!!";
      	}else{
      		$data['error'] = "Thất bại.";
      	} 
      	echo(json_encode($data));
	}

	public function pageNewProject()
	{
		$match = array('hidden'=>0);
		$data['pages'] = $this->M_material->load_data($match);
		$data['giacong'] = $this->M_data->load_outsource();
		$data['typeProjects'] = $this->M_data->load_typeProject();
		// $data['donhangs'] = $this->M_data->load_donHang();
		$data['csrf'] = array(
        'name' => $this->security->get_csrf_token_name(),
        'hash' => $this->security->get_csrf_hash()
		);
		$category['category'] = array(
            	'bill'=> array(
            		'name'=>'Đơn hàng',
            		'link'=>'admin/view_admin/bill',
            		'icon'=>'fa fa-object-group'
            	),
            	'project'=> array(
            		'name'=>'Quản lý Dự án',
            		'link'=>'admin/view_admin/project',
            		'icon'=>'fa fa-archive'
            	),
            	'revenue'=>array(
            		'type'=>'tree',
            		'name'=>'Quản lý Doanh thu',
            		'content'=>array(
            			'business'=>array(
            				'name'=>'Doanh nghiệp',
            				'link'=>'admin/view_admin/business'
            			),
            			
            		),
            		'icon'=>'fa fa-briefcase'),
            	'material'=>array(
            		'name'=>'Quản lý Giấy',
            		'link'=>'admin/view_admin/material',
            		'icon'=>'fa fa-database'
            	),
            	'print'=>array(
            		'name'=>'Quản lý In',
            		'link'=>'admin/view_admin/print',
            		'icon'=>'fa fa-print'
            	),
            ); 
		// Load view header        
		$this->_data['html_header'] = $this->load->view('admin/header', $category, TRUE);        
		// Load  footer        
		$this->_data['html_footer'] = $this->load->view('admin/footer', NULL, TRUE);
		        // Load view method_one_view        
		$this->_data['html_body'] = $this->load->view('admin/v_new_project',$data, TRUE);

		$this->load->view('admin/master', $this->_data);
	}


	public function unNumber_Format($number)
	{
		return str_replace(',', '',$number);
	}

	public function insert_project()
	{	
		
		$post = $this->input->post(); 
		// var_dump(str_replace(',', '',$post['doanhthu']));
		$id_project = $this->tao_id_project($post['id_typeProject']);

		$chiphi = array(
				'chiphi_giay' 		=> $this->unNumber_Format($post['chiphi_giay']),
				'chiphi_inngoai' 	=> $this->unNumber_Format($post['chiphi_inngoai']),
				'chiphi_giacong' 	=> $this->unNumber_Format($post['chiphi_giacong']),
				'chiphi_giaohang' 	=> $this->unNumber_Format($post['chiphi_giaohang']),
		);

		$doanhthu = array(
				'doanhthu_thietke' 	=> $this->unNumber_Format($post['doanhthu_thietke']),
				'tam_ung' 			=> $this->unNumber_Format($post['tam_ung']),
				'ngay_tam_ung' 		=> $post['ngay_tam_ung'],
				'status_thu_tien' 	=> $post['status_thu_tien'],
				'phieu_thu' 		=> $post['phieu_thu'],
				'ghi_chu' 			=> $post['note_doanhthu'],
		);

		$khachhang = array(
				'name' 				=> $post['name_customer'],
				'email' 			=> $post['email'],
				'phone' 			=> $post['phone'],
				'address' 			=> $post['address'],
		);
		$id_khachhang = $this->M_customer->insert_customer($khachhang);

		$donhang = array(
				'id_customer'		=> $id_khachhang,
				'quantity'			=> $this->unNumber_Format($post['so_luong']),
				'unit'				=> $post['donvi'],
				'note'				=> $post['note_donhang'],
		);
		$id_bill = $this->M_bill->insert_bill($donhang);


		$project = array(
				'id'				=> $id_project,
				'id_typeproject'	=> $post['id_typeProject'],
				'id_bill'			=> $id_bill,
				'dead_line'			=> $post['deadline'],
				'project_name'		=> $post['name_project'],
				'ma_khachhang'		=> $id_khachhang,
				'tong_chiphi'		=> $this->unNumber_Format($post['chiphi']),
				'thongtin_chiphi'	=> json_encode($chiphi),
				'tong_doanhthu'		=> $this->unNumber_Format($post['doanhthu']),
				'thongtin_doanhthu' => json_encode($doanhthu),
				'thongtin_khachhang'=> json_encode($khachhang),
				'thongtin_donhang'	=> json_encode($donhang),
				'file_thiet_ke'		=> $post['file_thietke'],
		);

		$print = array(
				'id_project'		=> $id_project,
				'id_user'			=> $this->session->userdata('user_id'),
				'id_material'		=> $post['id_loaigiay'],
				'outsource'			=> $post['id_giacong'],
				'name'				=> $post['ten_mayin'],
				'num_face'			=> $this->unNumber_Format($post['so_mat_in']),
				'num_print'			=> $this->unNumber_Format($post['so_to_in']),
				'num_test'			=> $this->unNumber_Format($post['so_to_test']),
				'num_bad' 			=> $this->unNumber_Format($post['so_to_in_hu']),
				'num_jam'			=> $this->unNumber_Format($post['so_to_ket']),
				'num_reprint'		=> $this->unNumber_Format($post['in_lai']),
				'note'				=> $post['note_in'],
				'tong_so_giay_in_su_dung'	=> $this->unNumber_Format($post['tong_to_in']),
		);

		if (file_exists('./files/project_record.txt'))
		{
			if($this->M_project->insert_row($project)){
				$this->M_printer->insert($print);
				$file_recent = fopen("./files/project_record.txt", "a+");
				fwrite($file_recent, ';'.$id_project);
				fclose($file_recent);
				redirect(base_url().'admin/admin/view_admin/project');
			}
		}else{
			echo('File not found!');
		}
	}

	public function pageEditProject($id)
	{	
		$data['project'] = $this->M_project->load_project_by_id($id);
		$data['donhang'] = json_decode($data['project'][0]['thongtin_donhang'],true);
		$data['doanhthu'] = json_decode($data['project'][0]['thongtin_doanhthu'],true);
		$data['chiphi'] = json_decode($data['project'][0]['thongtin_chiphi'],true);
		// var_dump($data['project'][0]);
		$match = array('hidden'=>0);
		$data['pages'] = $this->M_material->load_data($match);
		$data['giacong'] = $this->M_data->load_outsource();
		$data['typeProjects'] = $this->M_data->load_typeProject();
		// $data['donhangs'] = $this->M_data->load_donHang();
		$data['csrf'] = array(
        'name' => $this->security->get_csrf_token_name(),
        'hash' => $this->security->get_csrf_hash()
		);
		$category['category'] = array(
            	'bill'=> array(
            		'name'=>'Đơn hàng',
            		'link'=>'admin/view_admin/bill',
            		'icon'=>'fa fa-object-group'
            	),
            	'project'=> array(
            		'name'=>'Quản lý Dự án',
            		'link'=>'admin/view_admin/project',
            		'icon'=>'fa fa-archive'
            	),
            	'revenue'=>array(
            		'type'=>'tree',
            		'name'=>'Quản lý Doanh thu',
            		'content'=>array(
            			'business'=>array(
            				'name'=>'Doanh nghiệp',
            				'link'=>'admin/view_admin/business'
            			),
            			
            		),
            		'icon'=>'fa fa-briefcase'),
            	'material'=>array(
            		'name'=>'Quản lý Giấy',
            		'link'=>'admin/view_admin/material',
            		'icon'=>'fa fa-database'
            	),
            	'print'=>array(
            		'name'=>'Quản lý In',
            		'link'=>'admin/view_admin/print',
            		'icon'=>'fa fa-print'
            	),
            ); 
		// Load view header        
		$this->_data['html_header'] = $this->load->view('admin/header', $category, TRUE);        
		// Load  footer        
		$this->_data['html_footer'] = $this->load->view('admin/footer', NULL, TRUE);
		        // Load view method_one_view        
		$this->_data['html_body'] = $this->load->view('admin/v_edit_project',$data, TRUE);

		$this->load->view('admin/master', $this->_data);
	}

	public function updateProject()
	{	
		
		$post = $this->input->post(); 
		// var_dump(str_replace(',', '',$post['doanhthu']));
		$id_project = $post['id'];

		$chiphi = array(
				'chiphi_giay' 		=> $this->unNumber_Format($post['chiphi_giay']),
				'chiphi_inngoai' 	=> $this->unNumber_Format($post['chiphi_inngoai']),
				'chiphi_giacong' 	=> $this->unNumber_Format($post['chiphi_giacong']),
				'chiphi_giaohang' 	=> $this->unNumber_Format($post['chiphi_giaohang']),
		);

		$doanhthu = array(
				'doanhthu_thietke' 	=> $this->unNumber_Format($post['doanhthu_thietke']),
				'tam_ung' 			=> $this->unNumber_Format($post['tam_ung']),
				'ngay_tam_ung' 		=> $post['ngay_tam_ung'],
				'status_thu_tien' 	=> $post['status_thu_tien'],
				'phieu_thu' 		=> $post['phieu_thu'],
				'ghi_chu' 			=> $post['note_doanhthu'],
		);

		$khachhang = array(
				'name' 				=> $post['name_customer'],
				'email' 			=> $post['email'],
				'phone' 			=> $post['phone'],
				'address' 			=> $post['address'],
		);
		$id_khachhang = $post['id_customer'];

		$donhang = array(
				'id_customer'		=> $id_khachhang,
				'quantity'			=> $this->unNumber_Format($post['so_luong']),
				'unit'				=> $post['donvi'],
				'note'				=> $post['note_donhang'],
		);
		$id_bill = $post['id_bill'];


		$project = array(
				'id'				=> $id_project,
				'id_typeproject'	=> $post['id_typeProject'],
				'id_bill'			=> $id_bill,
				'dead_line'			=> $post['deadline'],
				'project_name'		=> $post['name_project'],
				'ma_khachhang'		=> $id_khachhang,
				'tong_chiphi'		=> $this->unNumber_Format($post['chiphi']),
				'thongtin_chiphi'	=> json_encode($chiphi),
				'tong_doanhthu'		=> $this->unNumber_Format($post['doanhthu']),
				'thongtin_doanhthu' => json_encode($doanhthu),
				'thongtin_khachhang'=> json_encode($khachhang),
				'thongtin_donhang'	=> json_encode($donhang),
				'file_thiet_ke'		=> $post['file_thietke'],
		);

		$print = array(
				'id_project'		=> $id_project,
				'id_user'			=> $this->session->userdata('user_id'),
				'id_material'		=> $post['id_loaigiay'],
				'outsource'			=> $post['id_giacong'],
				'name'				=> $post['ten_mayin'],
				'num_face'			=> $this->unNumber_Format($post['so_mat_in']),
				'num_print'			=> $this->unNumber_Format($post['so_to_in']),
				'num_test'			=> $this->unNumber_Format($post['so_to_test']),
				'num_bad' 			=> $this->unNumber_Format($post['so_to_in_hu']),
				'num_jam'			=> $this->unNumber_Format($post['so_to_ket']),
				'num_reprint'		=> $this->unNumber_Format($post['in_lai']),
				'note'				=> $post['note_in'],
				'tong_so_giay_in_su_dung'	=> $this->unNumber_Format($post['tong_to_in']),
		);

		$this->M_customer->update_customer($id_khachhang, $khachhang);
		$this->M_bill->update_bill($id_bill, $donhang);
		$this->M_project->update_row($id_project, $project);
		$this->M_printer->update_row($id_project, $print);
		redirect(base_url().'admin/admin/view_admin/project');
		
	}
	//cập nhập trạng thái dự án hoàn thành
	public function updateStatusProject()
	{
		$id_project = $this->input->post('id_project');
		$data['status'] = 'p405';
		$this->M_project->updateStatus($id_project,$data);
		$print = $this->M_printer->get_tong_to_in($id_project);
		$tong_to_in = $print[0]['tong_to'];
		$id_material = $print[0]['id_material'];
		$material = $this->M_material->get_row($id_material);
		$tong_giay = $material[0]['quantity'];
		$mdata['quantity'] = $tong_giay - $tong_to_in;
		$this->M_material->update($id_material,$mdata);
	}
	//lọc dự án
	public function filterProject()
	{
		$data = [];
		$post = $this->input->post(); 
		$match = array(
			'project.hidden'=>0,
			'project.status'=>$post['status'],
			'id_typeproject'=>$post['typeProject'],
			'dead_line >='=>$post['start'],
			'dead_line <='=>$post['end']
		);

		if ($post['status']==0) {
			unset($match['project.status']);
		}
		if ($post['typeProject']==0) {
			unset($match['id_typeproject']);
		}
		
		$data['project'] = $this->M_project->load_project_by_filter($match);
		$data['typeproject'] = $this->M_data->load_typeProject();
		$data['status'] = $this->M_status->load_status_by_type('project');

		$category['category'] = array(
            	'bill'=> array(
            		'name'=>'Đơn hàng',
            		'link'=>'admin/view_admin/bill',
            		'icon'=>'fa fa-object-group'
            	),
            	'project'=> array(
            		'name'=>'Quản lý Dự án',
            		'link'=>'admin/view_admin/project',
            		'icon'=>'fa fa-archive'
            	),
            	'revenue'=>array(
            		'type'=>'tree',
            		'name'=>'Quản lý Doanh thu',
            		'content'=>array(
            			'business'=>array(
            				'name'=>'Doanh nghiệp',
            				'link'=>'admin/view_admin/business'
            			),
            			
            		),
            		'icon'=>'fa fa-briefcase'),
            	'material'=>array(
            		'name'=>'Quản lý Giấy',
            		'link'=>'admin/view_admin/material',
            		'icon'=>'fa fa-database'
            	),
            	'print'=>array(
            		'name'=>'Quản lý In',
            		'link'=>'admin/view_admin/print',
            		'icon'=>'fa fa-print'
            	),
            ); 
		// Load view header        
		$this->_data['html_header'] = $this->load->view('admin/header', $category, TRUE);        
		// Load  footer        
		$this->_data['html_footer'] = $this->load->view('admin/footer', NULL, TRUE);
		$this->_data['html_body'] = $this->load->view('admin/v_project',$data, TRUE);
		$this->load->view('admin/master', $this->_data);
		// var_dump($data['project']);
	}

	public function filterRevenue()
	{
		$data = [];
		$post = $this->input->post(); 
		$match = array(
			'project.hidden'=>0,
			'project.status'=>$post['status'],
			'id_typeproject'=>$post['typeProject'],
			'created_at >='=>$post['start'],
			'created_at <='=>$post['end']
		);

		if($post['status']==0) unset($match['project.status']);
		if($post['typeProject']==0) unset($match['id_typeproject']);

		$revenue = $this->M_project->load_data_for_revenue($match);
		for($i=0; $i<count($revenue);$i++){
			$data['revenue'][$i]['tong_chiphi'] = $revenue[$i]['tong_chiphi'];
    		$data['revenue'][$i]['id'] = $revenue[$i]['id'];
    		$data['revenue'][$i]['project_name'] = $revenue[$i]['project_name'];
    		$data['revenue'][$i]['created_at'] = $revenue[$i]['created_at'];
    		$data['revenue'][$i]['tong_doanhthu'] = $revenue[$i]['tong_doanhthu'];
    		foreach (json_decode($revenue[$i]['thongtin_chiphi'],true) as $key => $value) {
    			$data['revenue'][$i][$key] = $value;
    		}
    		foreach (json_decode($revenue[$i]['thongtin_doanhthu'],true) as $key => $value) {
    			$data['revenue'][$i][$key] = $value;
    		}
    		foreach (json_decode($revenue[$i]['thongtin_khachhang'],true) as $key => $value) {
    			$data['revenue'][$i][$key] = $value;
    		}
    		foreach (json_decode($revenue[$i]['thongtin_donhang'],true) as $key => $value) {
    			$data['revenue'][$i][$key] = $value;
    		}
		}
		$category['active']['revenue'][0] = 'active';
		$category['active']['revenue']['business'] = 'fa fa-circle-o';
		$data['status'] = $this->M_status->load_status_by_type('project');
		$data['typeproject'] = $this->M_data->load_typeProject();
		$category['category'] = array(
            	'bill'=> array(
            		'name'=>'Đơn hàng',
            		'link'=>'admin/view_admin/bill',
            		'icon'=>'fa fa-object-group'
            	),
            	'project'=> array(
            		'name'=>'Quản lý Dự án',
            		'link'=>'admin/view_admin/project',
            		'icon'=>'fa fa-archive'
            	),
            	'revenue'=>array(
            		'type'=>'tree',
            		'name'=>'Quản lý Doanh thu',
            		'content'=>array(
            			'business'=>array(
            				'name'=>'Doanh nghiệp',
            				'link'=>'admin/view_admin/business'
            			),
            			
            		),
            		'icon'=>'fa fa-briefcase'),
            	'material'=>array(
            		'name'=>'Quản lý Giấy',
            		'link'=>'admin/view_admin/material',
            		'icon'=>'fa fa-database'
            	),
            	'print'=>array(
            		'name'=>'Quản lý In',
            		'link'=>'admin/view_admin/print',
            		'icon'=>'fa fa-print'
            	),
            ); 
		// Load view header        
		$this->_data['html_header'] = $this->load->view('admin/header', $category, TRUE);        
		// Load  footer        
		$this->_data['html_footer'] = $this->load->view('admin/footer', NULL, TRUE);
		$this->_data['html_body'] = $this->load->view('admin/v_revenue_business',$data, TRUE);
		$this->load->view('admin/master', $this->_data);
		// var_dump($data['project']);
	}
}
