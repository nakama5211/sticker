<?php

class Home extends CI_Controller{

	public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('M_data');
        $this->load->model('M_bill');
        $this->load->model('M_customer');
    }
	function index(){
		$data['csrf'] = array(
        'name' => $this->security->get_csrf_token_name(),
        'hash' => $this->security->get_csrf_hash()
		);
		$data['typedecal'] = $this->M_data->load_typeDecal();
		$data['extrusion'] = $this->M_data->load_extrusion();
		$this->load->view('header');
		$this->load->view('container',$data);
		$this->load->view('footer');
	}

	function getInfor(){
		$data['csrf'] = array(
        'name' => $this->security->get_csrf_token_name(),
        'hash' => $this->security->get_csrf_hash()
		);
		$post = $this->input->post('DecalPriceForm');
		$data['typedecal'] = $this->M_data->get_typeDecal($post['decalType']);
		$data['extrusion'] = $this->M_data->get_Extrusion($post['isExtrusion']);
		$data['width'] = $post['sizeWidth']; 
		$data['height'] = $post['sizeHeight']; 
		$data['quantity'] = $post['quantity']; 
		$this->session->set_userdata($post);
		//var_dump($data);
		$this->load->view('header');
		$this->load->view('checkout',$data);
		$this->load->view('footer');
	}

	function order(){
		$sess = $this->session->userdata();
		$post = $this->input->post();

		//var_dump($sess);
		if (!empty($_FILES['uploadFiles'])) {
        $config['upload_path'] = './upload/';
        $config['allowed_types'] = 'jpg|jpeg|png|gif';
        $config['file_name'] = $_FILES['uploadFiles']['name'];

        $this->load->library('upload', $config);
        $this->upload->initialize($config);

        if ($this->upload->do_upload('uploadFiles')) {
          $uploadData = $this->upload->data();
          $data["image"] = $uploadData['file_name'];
          //echo "file upload success!! ";
        } else{
          $data["image"] = '';
          $data["error"] = $this->upload->display_errors();
          // var_dump($data);
        }
      	}else{
        $data["image"] = '';
      	}
      
		$bill['customer'] = array('name'=>$post['customerName'],'email'=>$post['customerEmail'],'phone'=>$post['customerPhone'],'address'=>$post['customerAddress'],'note'=>$post['note']);
		$id_customer = $this->M_customer->insert_customer($bill['customer']);
		$bill['bill'] = array('id_customer'=>$id_customer,'id_typedecal'=>$sess['decalType'],'id_extrusion'=>$sess['isExtrusion'],'width'=>$sess['sizeWidth'],'height'=>$sess['sizeHeight'],'quantity'=>$sess['quantity'],'file'=>$data['image'],'status'=>0);

		if($id = $this->M_bill->insert_bill($bill['bill'])){
		$data['bill'] = $this->M_bill->get_bill($id);
		$this->session->sess_destroy();
		$this->load->view('header');
		$this->load->view('v_cart_infor',$data);
		$this->load->view('footer');
		}else echo "error";
	}

	function destroy(){
		$this->session->sess_destroy();
		redirect(base_url());
	}

	function created(){
    $vals = array(
        'word' => '',
        'word_length' => 5,
        'img_path' => './pub/captcha/',
        'img_url' => base_url('pub/').'/captcha/',
        'font_path' => base_url('pub/font').'/webfont.ttf',
        'img_width' => '100',
        'img_height' => 35,
        'expiration' => 7200
        );
    $cap = create_captcha($vals);
    $this->session->set_userdata($cap);
    echo json_encode($cap);
	}           
	function calculate(){
		$get = $this->input->get();
		$width = $get['sizeWidth'];
		$height = $get['sizeHeight'];
		$quantity = $get['quantity'];
		$typedecal = $get['decalType'];
		$extrusion = $get['isExtrusion'];

		$del = $this->M_data->get_typeDecal($typedecal);
		$extr = $this->M_data->get_extrusion($extrusion);

		$unit_price = number_format($del[0]['price']+$extr[0]['price']);
		$total_order = number_format(($del[0]['price']+$extr[0]['price'])*$quantity);
		$summary_size = $width."x".$height." mm";
		$summary_quantity = $quantity;
		$summary_decal_type = $del[0]['name']."; ".$extr[0]['name'];

		$data = array("unit_price"=>$unit_price,"total_order"=>$total_order,"summary_size"=>
				$summary_size,"summary_quantity"=>$summary_quantity,"summary_decal_type"=>$summary_decal_type);
		echo json_encode($data);
	}
}