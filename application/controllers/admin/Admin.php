<?php

class Admin extends CI_Controller{

	public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->model(array('M_bill'));
        $this->load->model(array('M_data'));
        $this->load->model('M_department');
        $this->load->model('M_customer');
        $this->load->model('M_material');
        $this->load->model('M_cost');
        $this->load->model('M_debt');
        $this->load->helper('date');
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

	function view_admin($view=''){
		if($this->session->userdata('user_id')){
		switch ($this->session->userdata('group')){
		case'1':{
			$match = array(
				'hidden'=>0,
			);
            $category['category'] = array('bill'=> array('name'=>'Hóa đơn','link'=>'admin/view_admin/bill'));
            $category['category'][$view]['class'] = 'active';
			// Load view header        
			$this->_data['html_header'] = $this->load->view('admin/header', $category, TRUE);        
			// Load  footer        
			switch ($view) {
				case 'bill':
					$data['department'] = $this->M_department->load_all_department();
            		$data['bill'] = $this->M_bill->load_bill($match);
					$this->_data['html_body'] = $this->load->view('admin/v_bill_caller',$data, TRUE);
					break;
				
				default:
					
					break;
			}
			$this->_data['html_footer'] = $this->load->view('admin/footer', NULL, TRUE);
			// Load view method_one_view        
			$this->load->view('admin/master', $this->_data);

			break;
		}
        case'2':{
            $match = array(
				'hidden'=>0,
				'counter'=>1,
			);
            $category['category'] = array('bill'=> array('name'=>'Hóa đơn','link'=>'admin/view_admin/bill'),'debt'=> array('name'=>'Công nợ','link'=>'admin/view_admin/debt'),'mater'=> array('name'=>'Vật liệu','link'=>'admin/view_admin/mater'),'cost'=> array('name'=>'Chi phí','link'=>'admin/view_admin/cost'));
            $category['category'][$view]['class'] = 'active';
			// Load view header        
			$this->_data['html_header'] = $this->load->view('admin/header', $category, TRUE);        
			// Load  footer        
			switch ($view) {
				case 'bill':{
					$data['bill'] = $this->M_bill->load_bill($match);
					$this->_data['html_body'] = $this->load->view('admin/v_bill_caller',$data, TRUE);
					}break;
				case 'cost':{
					$data['cost'] = $this->M_cost->load_all();
					$this->_data['html_body'] = $this->load->view('admin/v_cost',$data, TRUE);
					}break;
				case 'mater':{
					$data['material'] = $this->M_material->load_all();
					$this->_data['html_body'] = $this->load->view('admin/v_material',$data, TRUE);
					}break;
				case 'debt':{
					$data['debt'] = $this->M_debt->load_all();
					$this->_data['html_body'] = $this->load->view('admin/v_debt',$data, TRUE);
					}break;
				default:
					
					break;
			}
			$this->_data['html_footer'] = $this->load->view('admin/footer', NULL, TRUE);
			// Load view method_one_view        

			$this->load->view('admin/master', $this->_data);

			break;
        }
        case'3':{
            $match1 = array(
				'status'=>3,
				'hidden'=>0
			);
			$match2 = array(
				'status'=>33,
				'hidden'=>0
			);
            $data['bill'] = array_merge($this->M_bill->load_bill($match1),$this->M_bill->load_bill($match2));
			$this->load->view('admin/header');
			$this->load->view('admin/v_bill_shipper',$data);
			$this->load->view('admin/footer');
			break;
        }default:{
            $data['bill'] = $this->M_bill->load_all_bill();
			$this->load->view('admin/header');
			$this->load->view('admin/v_bill',$data);
			$this->load->view('admin/footer');
			break;
        }}}else redirect(base_url().'admin/admin/');
	}



	function add_bill(){
		$data['typedecal'] = $this->M_data->load_typeDecal();
		$data['extrusion'] = $this->M_data->load_extrusion();
		$data['csrf'] = array(
        'name' => $this->security->get_csrf_token_name(),
        'hash' => $this->security->get_csrf_hash()
		);
		$category['category'] = array('bill'=> array('name'=>'Hóa đơn','link'=>'admin/view_admin/bill'));
		// Load view header        
		$this->_data['html_header'] = $this->load->view('admin/header', $category, TRUE);        
		// Load  footer        
		$this->_data['html_footer'] = $this->load->view('admin/footer', NULL, TRUE);
		        // Load view method_one_view        
		$this->_data['html_body'] = $this->load->view('admin/v_new_bill',$data, TRUE);

		$this->load->view('admin/master', $this->_data);
	}

	function edit_bill($id){
		$data['typedecal'] = $this->M_data->load_typeDecal();
		$data['extrusion'] = $this->M_data->load_extrusion();
		$data['bill'] = $this->M_bill->get_bill($id);
		$data['csrf'] = array(
        'name' => $this->security->get_csrf_token_name(),
        'hash' => $this->security->get_csrf_hash()
		);
		$category['category'] = array('bill'=> array('name'=>'Hóa đơn','link'=>'admin/view_admin/bill'));
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
          var_dump($data);
        }
      	}else{
        $data["image"] = '';
      	}
      
		$bill['customer'] = array('name'=>$post['customer'],'email'=>$post['email'],'phone'=>$post['phone'],'address'=>$post['address'],'note'=>$post['note']);
		$id_customer = $this->M_customer->insert_customer($bill['customer']);
		$bill['bill'] = array('id_customer'=>$id_customer,'id_typedecal'=>$post['id_typedecal'],'id_extrusion'=>$post['id_extrusion'],'width'=>$post['width'],'height'=>$post['height'],'quantity'=>$post['quantity'],'file'=>$data['image']);
		
		if($this->M_bill->insert_bill($bill['bill'])){
			$this->session->set_userdata('success',"Thêm thành công!!");
			redirect(base_url().'admin/admin/view_admin/');
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
          var_dump($data);
        }
      	}else{
        $data["image"] = '';
      	}
      
		$bill['customer'] = array('name'=>$post['customer'],'email'=>$post['email'],'phone'=>$post['phone'],'address'=>$post['address'],'note'=>$post['note']);
		$this->M_customer->update_customer($post['id_customer'],$bill['customer']);
		$bill['bill'] = array('id_typedecal'=>$post['id_typedecal'],'id_extrusion'=>$post['id_extrusion'],'width'=>$post['width'],'height'=>$post['height'],'quantity'=>$post['quantity'],'file'=>$data['image']);
		if($data['image']==''){
			array_pop($bill['bill']);
		}
		
		if(!$this->M_bill->update_bill($post['id'],$bill['bill'])){
			$this->session->set_userdata('success',"Thay đổi thành công!!");
			redirect(base_url().'admin/admin/view_admin/');
		}
		else{
			$log['error']="Update Thất bại!!";
			redirect(base_url().'admin/admin/edit_bill/'.$post['id'],$log);
		} 
	}

	
	function change_status(){
		$id = $this->input->post('id');
		$checked_list = $this->input->post('checked_list');
		foreach ($checked_list as $key => $value) {	
			$data[$value] = 1;
		}
		$data['status'] = 1;
		$this->M_bill->update_bill($id,$data);
		$data['id'] = $id;
		$data['success'] = 'Thành công.';
		echo json_encode($data);
	}

	function cancel_bill(){
		$id = $this->input->get('id');
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
}
