<?php 
class Printer extends CI_Controller{

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
        $this->load->helper('date');
        $this->load->helper('string');
        date_default_timezone_set('Asia/Ho_Chi_Minh');
    }
	function load_data_for_edit_form(){
        $match = array('hidden'=>0);
        if($this->input->post('id')){
            $match_printer = array('id'=>$this->input->post('id'));
        }
        if($this->input->post('id_project')){
            $match_printer = array('id_project'=>$this->input->post('id_project'));
            if(!$this->M_data->record_exists($this->input->post('id_project'),'id_project','printer')){
                $new_printer = array(
                    'id_project'=>$this->input->post('id_project'),
                );
                $this->M_printer->insert($new_printer);
            }
        }
        $printer = $this->M_printer->get_row($match_printer);
        $paper = $this->M_material->load_data($match);
        $outsource = $this->M_data->load_outsource();
        $data['form-data'] = '';
        $data['form-data'].= '<input type="hidden" name="id" value="'.$printer[0]['id'].'">';
        unset(
            $printer[0]['id'],
            $printer[0]['created_at'],
            $printer[0]['updated_at'],
            $printer[0]['hidden'],
            $printer[0]['id_project'],
            $printer[0]['id_user']
        );
        foreach ($printer[0] as $key => $value) {
            switch ($key) {
                case 'outsource':
                    $data['form-data'].='
                    <div class="form-group">
                        <div><b>Gia công</b></div>
                        <div class="input-group">
                            <div class="input-group-addon iga2">
                                <span class="fa fa-pencil-square"></span>
                            </div>
                            <select class="form-control" name="'.$key.'">';
                            foreach ($outsource as $cat) {
                                if($value == $cat['id']){
                                    $data['form-data'].='<option selected="" value="'.$cat['id'].'" >'.$cat['name'].'</option>';
                                }else
                                $data['form-data'].='<option value="'.$cat['id'].'" >'.$cat['name'].'</option>';
                            }
                    $data['form-data'].='</select></div>
                    </div>
                    ';
                    break;
                case 'id_material':
                    $data['form-data'].='
                    <div class="form-group">
                        <div><b>Loại giấy</b></div>
                        <div class="input-group">
                            <div class="input-group-addon iga2">
                                <span class="fa fa-pencil-square"></span>
                            </div>
                            <select class="form-control" name="'.$key.'">';
                            foreach ($paper as $cat) {
                                if($value == $cat['id']){
                                    $data['form-data'].='<option selected="" value="'.$cat['id'].'" >'.$cat['name'].'</option>';
                                }else
                                $data['form-data'].='<option value="'.$cat['id'].'" >'.$cat['name'].'</option>';
                            }
                    $data['form-data'].='</select></div>
                    </div>
                    ';
                    break;
                case 'name':
                    $data['form-data'].='
                    <div class="form-group">
                        <div><b>Tên máy in</b></div>
                        <div class="input-group">
                            <div class="input-group-addon iga2">
                                <span class="fa fa-pencil-square"></span>
                            </div>
                        <input type="text" class="form-control" name="'.$key.'" value="'.$value.'">
                        </div>
                    </div>
                    ';
                    break;
                case 'num_face':
                    $data['form-data'].='
                    <div class="form-group">
                        <div><b>Số mặt in</b></div>
                        <div class="input-group">
                            <div class="input-group-addon iga2">
                                <span class="fa fa-pencil-square"></span>
                            </div>
                        <input type="text" class="form-control" name="'.$key.'" value="'.$value.'">
                        </div>
                    </div>
                    ';
                    break;
                case 'num_print':
                    $data['form-data'].='
                    <div class="form-group">
                        <div><b>Số tờ in</b></div>
                        <div class="input-group">
                            <div class="input-group-addon iga2">
                                <span class="fa fa-pencil-square"></span>
                            </div>
                        <input type="text" class="form-control" name="'.$key.'" value="'.$value.'">
                        </div>
                    </div>
                    ';
                    break;
                case 'num_test':
                    $data['form-data'].='
                    <div class="form-group">
                        <div><b>Số tờ test</b></div>
                        <div class="input-group">
                            <div class="input-group-addon iga2">
                                <span class="fa fa-pencil-square"></span>
                            </div>
                        <input type="text" class="form-control" name="'.$key.'" value="'.$value.'">
                        </div>
                    </div>
                    ';
                    break;
                case 'num_bad':
                    $data['form-data'].='
                    <div class="form-group">
                        <div><b>Số tờ in hư</b></div>
                        <div class="input-group">
                            <div class="input-group-addon iga2">
                                <span class="fa fa-pencil-square"></span>
                            </div>
                        <input type="text" class="form-control" name="'.$key.'" value="'.$value.'">
                        </div>
                    </div>
                    ';
                    break;
                case 'num_jam':
                    $data['form-data'].='
                    <div class="form-group">
                        <div><b>Số tờ kẹt giấy</b></div>
                        <div class="input-group">
                            <div class="input-group-addon iga2">
                                <span class="fa fa-pencil-square"></span>
                            </div>
                        <input type="text" class="form-control" name="'.$key.'" value="'.$value.'">
                        </div>
                    </div>
                    ';
                    break;
                case 'num_reprint':
                    $data['form-data'].='
                    <div class="form-group">
                        <div><b>Số tờ in hư - in lại</b></div>
                        <div class="input-group">
                            <div class="input-group-addon iga2">
                                <span class="fa fa-pencil-square"></span>
                            </div>
                        <input type="text" class="form-control" name="'.$key.'" value="'.$value.'">
                        </div>
                    </div>
                    ';
                    break;
                case 'note':
                    $data['form-data'].='
                    <div class="form-group">
                        <div><b>Ghi chú</b></div>
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
                    $data['form-data'].='
                    <div class="form-group">
                        <div><b>'.$key.'</b></div>
                        <div class="input-group">
                            <div class="input-group-addon iga2">
                                <span class="fa fa-pencil-square"></span>
                            </div>
                        <input type="text" class="form-control" name="'.$key.'" value="'.$value.'">
                        </div>
                    </div>
                    ';
                    break;
            }
        }
        $data['form-data'].= '
            <div class="form-group">
                <div class="help-block" id="error-quantity"></div>
            </div>
        ';
        echo json_encode($data['form-data']);
    }

    function update_data_row(){
        $frm = $this->input->post();
        $id = $frm['id'];
        $data = [];
        unset($frm['id']);
        $oldprinter = $this->M_printer->get_row(array('id'=>$id));
        $sumqty = $frm['num_print']-$oldprinter[0]['num_print']
                +$frm['num_test']-$oldprinter[0]['num_test']
                +$frm['num_bad']-$oldprinter[0]['num_bad']
                +$frm['num_jam']-$oldprinter[0]['num_jam']
                +$frm['num_reprint']-$oldprinter[0]['num_reprint'];
        $store = $this->M_material->get_quantity($frm['id_material']);
        if($sumqty>$store[0]['quantity']){
            $data['error'] = "Số lượng trong kho không đủ.";
        }else if(!$this->M_printer->update($id,$frm)){
            $data['success'] = "Cập nhật thành công.";
            $this->M_material->update($frm['id_material'],array('quantity'=>($store[0]['quantity']-$sumqty)));
            $data['response'] = $this->M_printer->get_row(array('id'=>$id));
            unset(
                $data['response'][0]['id'],
                $data['response'][0]['updated_at'],
                $data['response'][0]['hidden'],
                $data['response'][0]['id_project'],
                $data['response'][0]['id_user']
            );
            if(isset($data['response'][0]['id_material'])){
                $paper = $this->M_material->get_row($data['response'][0]['id_material']);
                $data['response'][0]['id_material'] = $paper[0]['name'];
            }
            if(isset($data['response'][0]['outsource'])){
                $outs = $this->M_data->get_outsource($data['response'][0]['outsource']);
                $data['response'][0]['outsource'] = $outs[0]['name'];
            }
        } 
        else $data['fail'] = "Cập nhật thất bại.";
        echo json_encode($data);
    }
}