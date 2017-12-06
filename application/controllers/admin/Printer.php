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
        $id_project = $this->input->post('id_project');
        $match['printer'] = array(
            'printer.hidden'=>0,
            'printer.id_project'=>$id_project
        );
        $printer = $this->M_printer->get_row($match['printer']);
        $match['print_detail'] = array(
            'print_detail.hidden'=>0,
            'print_detail.id_printer'=>$printer[0]['id']
        );
        $paper = $this->M_material->load_data(array('hidden'=>0));
        $print_detail = $this->M_printer->load_print_detail($match['print_detail']);

        $data['form-data'] = '';
        $data['form-data'].='
            <div class="form-group">
                <div><b>Danh sách các loại giấy:</b></div>
                <div class="input-group">
                    <div class="input-group-addon iga2">
                        <span class="fa fa-pencil-square"></span>
                    </div>
                    <div class="form-control">';
                        foreach ($print_detail as $key => $value) {
                            $data['form-data'].='
                                <div class="tag" id="tag_'.$value['id'].'"> 
                                    <ul class="tags">
                                        <li><a onclick="editPaper('.$value['id'].','.$printer[0]['id'].')"><p class="tag-title">'.$value['material_name'].' </p> <span>'.$value['sum_qty'].'</span><img onclick="delPaper('.$value['id'].','.$printer[0]['id'].')" src="https://www.facebook.com/rsrc.php/v3/yP/r/AzxmlQ2Tcny.png"></a></li>
                                    </ul>
                                </div>
                            ';
                        }

                    $data['form-data'].='
                    </div>
                    <div class="input-group-addon iga2">
                        <span onclick="selectPaper('.$printer[0]['id'].')" class="fa fa-plus"></span>
                    </div>
                </div>
            </div>
            ';
        $data['form-data'].='
            <div class="form-group">
                <div><b>Tổng số lượng giấy:</b></div>
                <div class="input-group">
                    <div class="input-group-addon iga2">
                        <span class="fa fa-pencil-square"></span>
                    </div>
                    <input disabled="" type="text" class="form-control" name="sum_qty" value="'.number_format($printer[0]['tong_so_giay_in_su_dung']).' (tờ)">
                </div>
            </div>
            ';
        $data['form-data'].='
            <div class="form-group">
                <div><b>Tổng chi phí giấy:</b></div>
                <div class="input-group">
                    <div class="input-group-addon iga2">
                        <span class="fa fa-pencil-square"></span>
                    </div>
                    <input disabled="" type="text" class="form-control" name="sum_qty" value="'.number_format($printer[0]['cost_print']).' (vnđ)">
                </div>
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
        $frm['tong_so_giay_in_su_dung'] = $frm['num_print']
                +$frm['num_test']
                +$frm['num_bad']
                +$frm['num_jam']
                +$frm['num_reprint'];
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

    function load_more_paper(){
        $paper = $this->M_material->load_data(array('hidden'=>0));
        $outsource = $this->M_data->load_outsource();
        $id_printer = $this->input->post('id_printer');
        $print_detail = $this->M_data->load_field_table('print_detail');
        $data['form-data'] = '';
        foreach ($print_detail as $key => $value) {
            switch ($value) {
                case 'id_printer':
                    $data['form-data'].= '<input type="hidden" name="id_printer" value="'.$id_printer.'">';
                    break;
                case 'id_material':
                    $data['form-data'].='
                    <div class="form-group">
                        <div><b>Loại giấy</b></div>
                        <div class="input-group">
                            <div class="input-group-addon iga2">
                                <span class="fa fa-pencil-square"></span>
                            </div>
                            <select class="form-control" name="'.$value.'">';
                            foreach ($paper as $cat) {
                                $data['form-data'].='<option value="'.$cat['id'].'" >'.$cat['name'].'</option>';
                            }
                    $data['form-data'].='</select>
                        </div>
                    </div>
                    ';
                    break;
                case 'id_outsource':
                    $data['form-data'].='
                    <div class="form-group">
                        <div><b>Gia công</b></div>
                        <div class="input-group">
                            <div class="input-group-addon iga2">
                                <span class="fa fa-pencil-square"></span>
                            </div>
                            <select class="form-control" name="'.$value.'">';
                            foreach ($outsource as $cat) {
                                $data['form-data'].='<option value="'.$cat['id'].'" >'.$cat['name'].'</option>';
                            }
                    $data['form-data'].='</select>
                        </div>
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
                        <input type="text" class="form-control" name="'.$value.'" value="">
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
                        <input type="text" class="form-control" name="'.$value.'" value="">
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
                        <input type="text" class="form-control" name="'.$value.'" value="">
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
                        <input type="text" class="form-control" name="'.$value.'" value="">
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
                        <input type="text" class="form-control" name="'.$value.'" value="">
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
                        <input type="text" class="form-control" name="'.$value.'" value="">
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
                        <input type="text" class="form-control" name="'.$value.'" value="">
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
                    break;
            }
        }
        echo json_encode($data['form-data']);
    }

    function edit_paper(){
        $id_paper = $this->input->post('id_paper');
        $id_printer = $this->input->post('id_printer');
        $match['print_detail'] = array(
            'print_detail.id'=>$id_paper,
            'print_detail.hidden'=>0
        );
        $print_detail = $this->M_printer->load_print_detail($match['print_detail']);
        $data['form-data'] = '';
        $data['form-data'].= '<input type="hidden" name="id_paper" value="'.$id_paper.'">';
        $data['form-data'].= '<input type="hidden" name="id_printer" value="'.$id_printer.'">';
        $match['paper'] = array('material.hidden'=>0);
        $paper = $this->M_material->load_data($match['paper']);
        $outsource = $this->M_data->load_outsource();
        
        foreach ($print_detail[0] as $key => $value) {
            switch ($key) {
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
                    $data['form-data'].='</select>
                        </div>
                    </div>
                    ';
                    break;
                case 'id_outsource':
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
                    $data['form-data'].='</select>
                        </div>
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
                    break;
            }
        }
        echo json_encode($data['form-data']);
    }

    function confirm_edit_paper(){
        $frm = $this->input->post();
        $id_paper = $frm['id_paper'];
        $id_printer = $frm['id_printer'];
        unset($frm['id_paper'],$frm['id_printer']);
        $sum_qty = $frm['num_print'] + $frm['num_test'] + $frm['num_jam'] + $frm['num_bad'] + $frm['num_reprint'];
        $frm['sum_qty'] = $sum_qty;
        $match['print_detail'] = array('id'=>$id_paper);
        $this->M_data->update($match['print_detail'],$frm,'print_detail');
        $this->update_sum_qty($id_printer);
        $data['success'] = 'success';
        echo json_encode($data);
    }
    function confirm_add_paper(){
        $frm = $this->input->post();
        $sum_qty = $frm['num_print'] + $frm['num_test'] + $frm['num_jam'] + $frm['num_bad'] + $frm['num_reprint'];
        $frm['sum_qty'] = $sum_qty;
        $id = $this->M_data->insert($frm,'print_detail');
        $this->update_sum_qty($frm['id_printer']);
        if($id!=0){
            $data['success'] = 'success';
        }
        echo json_encode($data);
    }
    function delete_Paper(){
        $id_paper = $this->input->post('id_paper');
        $id_printer = $this->input->post('id_printer');
        $match['delete'] = array(
            'print_detail.hidden'=>1
        );
        $match['print_detail'] = array(
            'print_detail.id'=>$id_paper
        );
        $this->M_data->update($match['print_detail'],$match['delete'],'print_detail');
        $this->update_sum_qty($id_printer);
        $data['success'] = 'Thành công';
        echo json_encode($data);
    }

    public function update_sum_qty($id_printer){
        $match['printer'] = array(
            'printer.hidden'=>0,
            'printer.id'=>$id_printer
        );
        $print_detail = $this->M_printer->get_sum_qty($id_printer);
        $new_qty['tong_so_giay_in_su_dung'] = 0;
        $new_qty['tong_so_giay_in_su_dung']+= $print_detail[0]['sum'];
        $this->M_data->update($match['printer'],$new_qty,'printer');
        $this->update_cost_print($id_printer);
    }

    public function update_cost_print($id_printer){
        $match['printer'] = array(
            'printer.hidden'=>0,
            'printer.id'=>$id_printer
        );
        $print_detail = $this->M_printer->get_cost_print($id_printer);
        $new_cost['cost_print'] = 0;
        if (count($print_detail)>0) {
            foreach ($print_detail as $key => $value) {
                $new_cost['cost_print'] += ($value['sum_qty']*$value['price']);
            }
        }
        $this->M_data->update($match['printer'],$new_cost,'printer');
    }
}