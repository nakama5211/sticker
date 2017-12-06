
<?php if(!$this->session->userdata('user_id'))
  echo "<div style='margin-left:500px; margin-top: 300px;'><h1>Bạn chưa đăng nhập</h1></div>";
  else{
                ?> 
<div class="content-wrapper">
        <div class="page-title">
          <div>
            <h1>Quản lý dự án</h1>
            <ul class="breadcrumb side">
              <li><i class="fa fa-home fa-lg"></i></li>
              <li>Bộ phận kinh doanh</li>
              <li class="active"><a href="#">Quản lý dự án</a></li>
            </ul>
          </div>
        </div>
        <?php if($ms=$this->session->userdata('success')){ ?>
          <div class="alert alert-success" id="scs-msg" >
          <strong><?php echo $ms; $this->session->unset_userdata('success');?></strong>
          </div>
          <script type="text/javascript">
          $(document).ready(function() {
            $('#scs-msg').fadeOut(2000); // 5 seconds x 1000 milisec = 5000 milisec
          });
          </script>
        <?php } ?>
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-body ">
                <div class="col-md-11">
                  <button class="btn btn-success btn-lg" id="dropbtn" title="Lọc dự án"><i class="fa fa-filter" aria-hidden="true"></i></button>
                  <div class="dropdown-content">
                    <form class="form-horizontal" method="post" action="<?php echo base_url() ?>admin/admin/filterProject">
                      <input type="hidden" id="statusDrop" value="0">
                      <br>
                      <div class="form-group ">
                        <label class="col-sm-4 control-label">Loại dự án</label>
                        <div class="col-sm-7">
                          <select class="form-control" name="typeProject" required="">
                            <option selected value="0">Tất cả</option>
                            <?php
                            if(!$typeproject) echo "<option value='0'>Empty</option>";
                            else{
                              foreach ($typeproject as $typePro) {
                                echo "<option value=".$typePro['id'].">".$typePro['name']."</option>";
                              }
                            }
                            ?>
                          </select>
                        </div>
                      </div>
                      <div class="form-group ">
                        <label class="col-sm-4 control-label">Tình trạng</label>
                        <div class="col-sm-7">
                          <select class="form-control" name="status" required="">
                            <option selected value="0">Tất cả</option>
                            <?php
                            if(!$status) echo "<option value='0'>Empty</option>";
                            else{
                              foreach ($status as $stt) {
                                echo "<option value=".$stt['id'].">".$stt['name']."</option>";
                              }
                            }
                            ?>
                          </select>
                        </div>
                      </div>
                      <div class="form-group ">
                        <label class="col-sm-4 control-label">Từ ngày</label>
                        <div class="col-sm-7">
                          <input type="date" class="form-control" name="start" required="" id="date-from-picker" value="">
                        </div>
                      </div>
                      <div class="form-group ">
                        <label class="col-sm-4 control-label">Đến ngày</label>
                        <div class="col-sm-7">
                          <input type="date" class="form-control" name="end" required="" id="date-to-picker" value="">
                        </div>
                      </div>
                      <div class="form-group">
                        <div style="margin-left: 35%;">
                          <button type="submit" class="btn btn-success">Lọc</button> 
                          <a class="btn btn-info" href="<?php echo base_url() ?>admin/admin/view_admin/project">Tất cả</a> 
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
                  
                  <div>
                    <a class="btn btn-primary btn-lg glyphicon glyphicon-plus" href="<?php echo base_url() ?>admin/admin/pageNewProject" title="Thêm dự án mới"></a>
                  </div>
                  
              </div>
            </div>
          </div>  
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-body">
                <table class="stripe row-border order-column" cellspacing="0" width="100%" id="sampleTable">
                  <thead>
                    <tr class="text-center">
                      <th></th>
                      <th class="col-data-table-0-7">Mã dự án</th>
                      <th class="col-data-table-1-5">Tên dự án</th>
                      <th class="col-data-table-1-4">Khách hàng</th>
                      <th class="col-data-table-0-9">Loại dự án</th>
                      <!-- <th class="col-data-table-1-8">Hạng mục công việc</th> -->
                      <th class="col-data-table-1-2">Tình trạng</th>
                      <th class="col-data-table-1-2">Ngày tạo</th>
                      <!-- <th class="col-data-table-1-2">File đính kèm</th> -->
                      <!-- <th class="col-data-table-1-2">Người liên hệ</th> -->
                      <th class="col-data-table-1-4">Thời hạn giao hàng</th>
                      <th class="col-data-table-1">Doanh thu</th>
                      <th class="col-data-table-1-2">Chi phí</th>
                      <th class="col-data-table-1">Số lượng</th>
                      <th class="col-data-table-0-5">Đơn vị</th>
                      <th class="col-data-table-1-8">Thao tác</th>
                    </tr>
                  </thead>
                  <tbody>
                  	<?php foreach ($project as $row) {
                      $donhang = json_decode($row['thongtin_donhang'],true);
                      // var_dump($donhang['quantity']);
                  	?>
                  	<tr id="row<?php echo $row['id']?>">
                      <td></td>
                      <td><?php echo $row['id']?></td>
                      <td><?php echo $row['project_name'] ?></td>
                      <td><?php echo "".$row['customer']."</br>";?></td>
                      <td><?php echo $row['typeproject']?></td>
                      
                      <td id="status_<?php echo $row['id']?>"><?php echo $row['status_name']?></td>
                      <td><?php echo $row['created_at']?></td>
                      
                      <td><?php echo $row['dead_line']?></td>
                      <td><?php echo number_format($row['tong_doanhthu'])." ₫"?></td>
                      <td><?php echo number_format($row['tong_chiphi'])." ₫"?></td>
                      <td><?php echo number_format($donhang['quantity'])?></td>
                      <td><?php echo $donhang['unit']?></td>
                      <?php 
                      if($row['status'] != 'p405' && $this->session->userdata('group')==1){ 
                      ?>
                      <td id="button_<?php echo $row['id']?>">
                        <button class="btn btn-success btn-lg" style="border-radius: 10px;" onclick="onCreateTask('<?php echo $row['id'] ?>')">Phân công việc
                        </button> 
                        <button class="btn btn-primary btn-lg" style="border-radius: 10px;" onclick="editRow('<?php echo $row['id'] ?>')">Quy cách in
                        </button>
                        <a class="btn btn-info btn-lg" style="border-radius: 10px;" href="<?php echo base_url().'editProject/'.$row['id'] ?>">Chỉnh sửa dự án
                        </a>
                        <button class="btn btn-success btn-lg" style="border-radius: 10px;" onclick="updateStatus('<?php echo $row['id'] ?>')">Hoàn tất
                        </button>
                        <button class="btn btn-danger btn-lg" style="border-radius: 10px;" onclick="viewProgress('<?php echo $row['id'] ?>')">Xem tiến độ
                        </button>
                  	  </td>
                    <?php }elseif($this->session->userdata('group')==1){ echo ''; ?>
                      <td>
                         <button class="btn btn-danger btn-lg" style="border-radius: 10px;" onclick="viewProgress('<?php echo $row['id'] ?>')">Xem tiến độ
                        </button>
                        <a class="btn btn-info btn-lg" style="border-radius: 10px;" href="<?php echo base_url().'admin/admin/exp_file/'.$row['id'] ?>">Xuất phiếu thu
                        </a>
                      </td>
                    </tr>
                  	<?php
                  	}else{ ?>

                    <td>
                         <button class="btn btn-danger btn-lg" style="border-radius: 10px;" onclick="selectFile('<?php echo $row['id'] ?>')">Chốt file
                        </button>
                      </td>
                      <?php 
                    }


                  } ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="modal fade" id="choose">
           <div class="modal-dialog">
           <div class="modal-content">
              <div class="modal-header">
                 <button type="button" class="close" data-dismiss='modal' aria-hidden="true"><span class="glyphicon glyphicon-remove"></span></button>
                 <h4 class="modal-title" style="font-size: 20px; padding: 12px;">Xác nhận và chuyển tới các bộ phận:</h4>
              </div>
              <form method="post" id="choose-form">
              <div class="modal-body">
                 <div class="container-fluid">
                    <div class="row">
                    <?php foreach ($department as $dep) {
                      if($dep['id']==$this->session->userdata('group')) continue;
                        echo '
                          <div class="col-lg-12 form-group">
                            <div class="input-group">
                                <span class="input-group-addon beautiful">
                                    <input type="checkbox" name="checked_list[]" value="'.$dep['code'].'">
                                </span>
                                <input type="text" value="'.$dep['name'].'" class="form-control">
                            </div>
                          </div>
                        ';
                    } ?>
                    </div>
                 </div>
              </div>
              <input type="hidden" name="id" id="cur-id">
              <div class="modal-footer">
                 <div class="form-group">
                    <button type="button" class="btn btn-sm btn-info" onclick="confirmChoose()"> Save <span class="glyphicon glyphicon-saved"></span></button>

                    <button type="button" data-dismiss="modal" class="btn btn-sm btn-default"> Cancel <span class="glyphicon glyphicon-remove"></span></button>
                 </div>
              </div>
              </form>
            </div>
          </div>
        </div>
    <div class="modal fade" id="taskOptModal">
           <div class="modal-dialog">
           <div class="modal-content">
              <div class="modal-header">
                 <button type="button" class="close" data-dismiss='modal' aria-hidden="true"><span class="glyphicon glyphicon-remove"></span></button>
                 <h4 class="modal-title" style="font-size: 20px; padding: 12px;">Phân công dự án:</h4>
              </div>
              <form method="post" id="select-user-form">
              <div class="modal-body">
                 <div class="container-fluid">
                    <div class="row">
                        <div><b>Bộ phận:</b></div>
                        <div class="input-group">
                          <div class="input-group-addon iga2">
                             <span class="glyphicon glyphicon-edit"></span>
                          </div>
                          <select class="form-control" name="id_depart" id="id_depart" onchange="load_list_user()">
                            <option value="" hidden="" disabled="" selected="">Chọn bộ phận</option>
                            <?php foreach ($department as $key => $value) {
                              if($this->session->userdata('group')==$value['id']) continue;
                              echo '<option value="'.$value['id'].'">'.$value['name'].'</option>';
                            } ?>
                          </select>
                        </div>
                        <div class="help-block" id="error-select-depart"></div>
                        <div><b>Nhân viên:</b></div>
                        <div class="input-group">
                          <div class="input-group-addon iga2">
                             <span class="glyphicon glyphicon-edit"></span>
                          </div>
                          <select disabled="" class="form-control" name="id_user" id="user_list" onchange="enableBtnConfirm()">
                          </select>
                        </div>
                        <div class="help-block" id="error-select-user"></div>
                    <!-- <?php foreach ($department as $dep) {
                      if($dep['id']==$this->session->userdata('group')) continue;
                        echo '
                          <div class="col-lg-12 form-group">
                            <div class="input-group">
                                <span class="input-group-addon beautiful">
                                    <input type="checkbox" name="checked_list[]" value="'.$dep['code'].'">
                                </span>
                                <input type="text" value="'.$dep['name'].'" class="form-control">
                            </div>
                          </div>
                        ';
                    } ?> -->
                    </div>
                 </div>
              </div>
              <input type="hidden" name="id_project" id="cur-id-for-task">
              <div class="modal-footer">
                 <div class="form-group">
                    <button type="button" disabled="" id="confirm-select-user" class="btn btn-sm btn-info" onclick="confirmSelectUser()"> Save <span class="glyphicon glyphicon-saved"></span></button>

                    <button type="button" data-dismiss="modal" class="btn btn-sm btn-default"> Cancel <span class="glyphicon glyphicon-remove"></span></button>
                 </div>
              </div>
              </form>
            </div>
          </div>
        </div>
  <div class="modal fade" id="edit-modal">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
           <button type="button" class="close" data-dismiss='modal' aria-hidden="true"><span class="glyphicon glyphicon-remove"></span></button>
           <h4 class="modal-title" style="font-size: 20px; padding: 12px;"> Quy cách in </h4>
        </div>
        <form method="post" id="edit-form">
        <div class="modal-body">
           <div class="container-fluid">
              <div class="row">
                 <div class="col-xs-12 col-sm-12 col-md-12" id="form-data-edit">
                 </div>
              </div>
           </div>
        </div>
        </form>
      </div>
    </div>
  </div>

  <div class="modal fade" id="project-progress">
          <div class="modal-dialog">
           <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss='modal' aria-hidden="true"><span class="glyphicon glyphicon-remove"></span></button>
                <h4 class="modal-title" style="font-size: 20px; padding: 12px;"><b>Tiến độ của dự án:</b></h4>
              </div>
              <form method="post" id="choose-form">
              <div class="modal-body">
                 <div class="container-fluid">
                    <div class="container">
                      <div class="[ col-xs-12 col-sm-6 ]" id="progress-view">
                          
                      </div>
                  </div>
                 </div>
              </div>
              <div class="modal-footer">
                 <div class="form-group">
                    <!-- <button type="button" class="btn btn-sm btn-info" onclick="createProject()"> Save <span class="glyphicon glyphicon-saved"></span></button>
                    <button type="button" data-dismiss="modal" class="btn btn-sm btn-default"> Cancel <span class="glyphicon glyphicon-remove"></span></button> -->
                 </div>
              </div>
              </form>
            </div>
          </div>
        </div>
    </div>
    <div class="modal fade" id="select-file-modal">
           <div class="modal-dialog">
           <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss='modal' aria-hidden="true"><span class="glyphicon glyphicon-remove"></span></button>
                <h4 class="modal-title" style="font-size: 20px; padding: 12px;"><b>Chọn file thiết kế:</b></h4>
              </div>
              <form method="post" id="file-select-form">
              <div class="modal-body">
                 <div class="container-fluid">
                    <div class="row">
                      <div class="form-group">
                        <div><b>Chọn file thiết kế</b></div>
                          <div class="input-group">
                            <input type="text" class="form-control" name="" disabled="" id="f_in" value="">
                            <div class="input-group-addon iga2">
                               <label style="margin-bottom: 0px;" class="fa"><b>Browse...</b><input onchange="file_change(this,0);" type="file" id="f" name="file" style="display: none;"></label>
                            </div>
                          </div>
                          <img src="" width="100%" height="auto" id="img0" style="margin-top: 10px;  display: none;" />
                        <div class="help-block" id="error-select-file"></div>
                      </div>
                    </div>
                 </div>
                 <input type="hidden" name="id" id="cur-id-select-file">
              </div>
              <div class="modal-footer">
                 <div class="form-group">
                    <button type="button" class="btn btn-sm btn-info" id="btn-select-file" disabled="" onclick="confirmSelectFile()"> Save <span class="glyphicon glyphicon-saved"></span></button>

                    <button type="button" data-dismiss="modal" class="btn btn-sm btn-default"> Cancel <span class="glyphicon glyphicon-remove"></span></button>
                 </div>
              </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    <div class="modal fade" id="select-paper-modal">
           <div class="modal-dialog">
           <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss='modal' aria-hidden="true"><span class="glyphicon glyphicon-remove"></span></button>
                <h4 class="modal-title" style="font-size: 20px; padding: 12px;"><b>Cập nhật loại giấy:</b></h4>
              </div>
              <form method="post" id="paper-select-form">
              <div class="modal-body">
                 <div class="container-fluid">
                    <div class="row">
                       <div class="col-xs-12 col-sm-12 col-md-12" id="form-select-more-paper">
                       </div>
                    </div>
                 </div>
              </div>
              <div class="modal-footer">
                 <div class="form-group">
                    <button type="button" class="btn btn-sm btn-info" onclick="ConfirmPaper()"> Ok <span class="glyphicon glyphicon-saved"></span></button>

                    <button type="button" data-dismiss="modal" class="btn btn-sm btn-default"> Cancel <span class="glyphicon glyphicon-remove"></span></button>
                 </div>
              </div>
              </form>
            </div>
          </div>
        </div>
      </div>
<?php } ?>
<script type="text/javascript">
function onCreateTask(id=''){
  document.getElementById("cur-id-for-task").value = id;
  $('#taskOptModal').modal('show');
}
function confirmChoose(){
  var route = '<?=base_url()?>admin/admin/change_status/';
  var frm = new FormData($('form#choose-form')[0]);
   $.ajax({
    url:route,
    processData: false, 
    contentType: false,
    type:'post',
    dataType:'json',
    data:frm,
    success:function(data){
      if(data.id){
        $('#choose').modal('hide');
        //$('#row'+data.id).hide();
        ssi_modal.notify('success', {content: data.success});
      }else ssi_modal.notify('error', {content: 'Thất bại.'});
    }
  });
}
function load_list_user(){
  $('#error-select-depart').html('');
  var id = $('#id_depart').val();
  $.ajax({
    type:'post',
    url:"<?php echo base_url(); ?>admin/admin/load_list_user",
    data: {
      'id': id},
    dataType: 'json',
    success: function(data){
      if(data){
        $('#user_list').removeAttr('disabled');
        $('#user_list').html(data['list-user']);
      }
    }
  });
}
function enableBtnConfirm(){
  $('#confirm-select-user').removeAttr('disabled');
}
function confirmSelectUser(){
  if($('#id_depart').val()==null){
    $('#error-select-depart').html("Bạn chưa chọn bộ phận");
  }else{
    $('#error-select-user').html("");
    var route = '<?=base_url()?>admin/task/create_task/';
    var frm = new FormData($('form#select-user-form')[0]);
     $.ajax({
      url:route,
      processData: false, 
      contentType: false,
      type:'post',
      dataType:'json',
      data:frm,
      success:function(data){
        if(data){
          $('#taskOptModal').modal('hide');
          if(data.status) $('#status_'+frm.get('id_project')).html(data.status);
          if(data.success) ssi_modal.notify('success', {content: data.success});
          if(data.exists) ssi_modal.notify('error', {content: data.exists});
          if(data.error) ssi_modal.notify('error', {content: data.error});
        }else ssi_modal.notify('error', {content: 'Thất bại.'});
      }
    });
  }
}
function editRow(id){
  $.ajax({
    url:'<?=base_url()?>admin/printer/load_data_for_edit_form/',
    type:'post',
    dataType:'json',
    data:{
      id_project:id
    },
    success:function(data){
      $('#form-data-edit').html(data);
      $('#edit-modal').modal('show');
    }
  });
}

function updateStatus(id){
  $.ajax({
    url:'<?=base_url()?>admin/admin/updateStatusProject',
    type:'post',
    data:{
      id_project:id
    },
    success:function(){
      $('#status_'+id).html('Dự án đã hoàn thành');
      // $('#button_'+id).hide();
      window.location.reload();
    }
  });
}
function subEditForm(){
  var route = '<?=base_url()?>admin/printer/update_data_row/';
  var frm = new FormData($('form#edit-form')[0]);
  $.ajax({
    url:route,
    processData: false, 
    contentType: false,
    type:'post',
    dataType:'json',
    data:frm,
    success:function(data){
      if(data.error){
        $('#error-quantity').html(data.error);
      }else{
        $('#edit-modal').modal('hide');
        if(data.success) ssi_modal.notify('success', {content: 'Thành công!!'});
        if(data.fail) ssi_modal.notify('error', {content: 'Thất bại!!'});
      }
    }
  });
}

function viewProgress(id){
  $.ajax({
    url:'<?=base_url()?>admin/task/get_progress_by_task',
    type:'post',
    dataType:'json',
    data:{
      id_project:id
    },
    success:function(data){
      $('#progress-view').html(data.progress);
      $('#project-progress').modal('show');
    }
  });
}
function selectFile(id) {
  document.getElementById("cur-id-select-file").value = id;
  $('#error-select-file').html('');
  $('#select-file-modal').modal('show');
}
function ConfirmPaper(){
  var frm = new FormData($('form#paper-select-form')[0]);
  if(frm.get('id_paper')!=null){
    var route = '<?=base_url()?>admin/printer/confirm_edit_paper';
  }else{
    var route = '<?=base_url()?>admin/printer/confirm_add_paper';
  }
  $.ajax({
    url:route,
    processData: false, 
    contentType: false,
    type:'post',
    dataType:'json',
    data:frm,
    success:function(data){
      if(data.success){
        window.location.reload();
      }
      if(data.error){
        ssi_modal.notify('error', {content: data.error});
      }
    }
  });
}

function file_change(f,i){
  var reader = new FileReader();
  reader.onload = function (e) {
    $("#img0").show();
    var img = document.getElementById("img"+i);
    img.src = e.target.result;
    img.style.display = "block-inline";
  };
  var ftype =f.files[0].type;
  switch(ftype)
  {
    case 'image/png':
    case 'image/gif':
    case 'image/jpeg':
    case 'image/pjpeg':
      reader.readAsDataURL(f.files[0]);
      $('#f_in').val(f.files[0].name);
      $('#btn-select-file').removeAttr('disabled');
      break;
    default:
      alert('Tập tin này không được hỗ trợ! Bạn chỉ được chọn file ảnh.');
      $("#f").val(null);
      $('#f_in').val(null);
      $("#img0").hide();
      $('#btn-select-file').attr('disabled','');
  }
}

function confirmSelectFile() {
  var route = '<?=base_url()?>admin/admin/select_final_file/';
  var frm = new FormData($('form#file-select-form')[0]);
  if(frm.get('file').name==''){
    $('#error-select-file').html('Vui lòng chọn một file.');
  }else{
    $.ajax({
      url:route,
      processData: false, 
      contentType: false,
      type:'post',
      dataType:'json',
      data:frm,
      success:function(data){
        if(data.error){
          ssi_modal.notify('error', {content: data.error});
        }
        if(data.success){
          // console.log(data.file_res[0]['file']);
          var table = $('#sampleTable').DataTable();
          $('#select-file-modal').modal('hide');
          // table.cell($('#file'+frm.get('id'))).data("<a rel = 'prettyPhoto' href = '<?=base_url()?>upload/"+data.file_res[0]['file']+"'><img style='height: 50px; width: 50px;'src='<?=base_url()?>upload/"+data.file_res[0]['file']+"'></a>").draw();
          ssi_modal.notify('success', {content: data.success});
        }
      }
    });
  }
}
function selectPaper(id){
  $.ajax({
    url:'<?=base_url()?>admin/printer/load_more_paper',
    type:'post',
    dataType:'json',
    data:{
      id_printer:id,
    },
    success:function(data){
      $('#form-select-more-paper').html(data);
      $('#select-paper-modal').modal('show');
    }
  });
}

function editPaper(id,id_printer){
  $.ajax({
    url:'<?=base_url()?>admin/printer/edit_paper',
    type:'post',
    dataType:'json',
    data:{
      id_paper:id,
      id_printer:id_printer
    },
    success:function(data){
      $('#form-select-more-paper').html(data);
      $('#select-paper-modal').modal('show');
    }
  });
}
function delPaper(id,id_printer){
  $.ajax({
    url:'<?=base_url()?>admin/printer/delete_paper',
    type:'post',
    dataType:'json',
    data:{
      id_paper:id,
      id_printer:id_printer
    },
    success:function(data){
      window.location.reload();
    }
  });
}
$(document).ready(function() {
  $('#dropbtn').click(function(event) {
    var status = $('#statusDrop').val();
    if (status == 0) {
      $('.dropdown-content').show();
      $('#statusDrop').val(1);
    }else{
      $('.dropdown-content').hide();
      $('#statusDrop').val(0);
    }
  });
  var date = new Date(), y = date.getFullYear(), m = date.getMonth();
var fd = new Date(y, m, 2);
var ld = new Date(y, m + 1, 1);
  document.querySelector("#date-from-picker").valueAsDate = fd;
  document.querySelector("#date-to-picker").valueAsDate = ld;
});
</script>
