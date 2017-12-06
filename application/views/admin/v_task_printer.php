
<?php if(!$this->session->userdata('user_id'))
  echo "<div style='margin-left:500px; margin-top: 300px;'><h1>Bạn chưa đăng nhập</h1></div>";
else{
                ?> 
<div class="content-wrapper">
        <div class="page-title">
          <div>
            <h1>Data Table</h1>
            <ul class="breadcrumb side">
              <li><i class="fa fa-home fa-lg"></i></li>
              <li>Tables</li>
              <li class="active"><a href="#">Data Table</a></li>
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
              <div class="card-body">
                <button class="btn btn-success btn-lg" id="dropbtn" title="Lọc dự án"><i class="fa fa-bell-o fa-lg" aria-hidden="true"></i><span class="badge badge-notify" style="margin-top: -20px; margin-right: -15px; margin-left: -8px; background: red; color: white;"><?php echo isset($newtask)?count($newtask):'0'?></span></button>
                  <div class="dropdown-content" style="width: 97%; border-radius:10px;">
                    <form class="form-horizontal" method="post" action="">
                      <input type="hidden" id="statusDrop" value="0">
                      <br>
                      <div class="widget-content nopadding">
                        <ul class="recent-posts" id="new-notif">
                          <?php 
                            if (!isset($newtask)) {
                              echo('<li>không có thông báo nào mới!</li>');
                            }else{
                            foreach ($newtask as $key => $value) { ?>
                          <li id="notif_<?php echo $value['id']?>">
                            <div class="user-thumb"> <img width="40" height="40" alt="User" src="<?php echo base_url().'upload/'.$value['file']?>"> </div>
                            <div class="article-post">
                              <div class="fr"><a href="#" class="btn btn-success btn-sm" onclick="acceptNotif('<?php echo $value['id'] ?>','<?php echo($this->session->userdata('group'))?>')">Chấp nhận</a> <a href="#" class="btn btn-danger btn-sm" onclick="deniedNotif('<?php echo $value['id'] ?>','<?php echo($this->session->userdata('group'))?>')">Từ chối</a></div>
                              <span class="user-info"> Dự án: <?php echo $value['id_project']?> / Ngày: <?php echo date_format(date_create($value['created_at']),'Y-m-d');?> / Lúc: <?php echo date_format(date_create($value['created_at']),'H:i:s');?> </span>
                              <p><a href="#">Nhân viên phòng in ấn nhận được thông báo này phải nhấn 'Chấp nhận' để tham gia vào dự án.</a> </p>
                            </div>
                          </li>
                          <?php }} ?>
                          <li>
                            <button class="btn btn-warning btn-sm">Xem thêm</button>
                          </li>
                        </ul>
                      </div>
                    </form>
                  </div>
                  <div id="external_filter_container_wrapper input-group" style="margin-bottom: 30px;">
                  <label style="margin-top: 5px; margin-left: 36%">Lọc trạng thái:</label>
                  <div id="external_filter_container" style="float: right; margin-right: 37%;"></div>
                </div>
                  <hr>
                <table class="stripe row-border order-column" id="sampleTable">
                  <thead>
                    <tr style="text-align: center;">
                      <th></th>
                      <th class="col-data-table-0-7">Mã bài in</th>
                      <th class="col-data-table-0-8">Máy in</th>
                      <th class="col-data-table-1-1">Ngày nhận task</th>
                      <th class="col-data-table-0-9">Ngày hoàn thành</th>
                      <th class="col-data-table-1-2">Trạng thái task</th>
                      <th class="col-data-table-1">Số lượng</th>
                      <th class="col-data-table-1">NV in</th>
                      <th class="col-data-table-1-9">Khách hàng</th>
                      <th class="col-data-table-0-8">Mô tả</th>
                      <th class="col-data-table-0-9">Giấy in</th>
                      <th class="col-data-table-0-7">Khổ giấy</th>
                      <th class="col-data-table-0-8">Số mặt in</th>
                      <th class="col-data-table-0-8">Số tờ in</th>
                      <th class="col-data-table-0-8">Gia công</th>
                      <th class="col-data-table-0-8">Ghi chú</th>
                      <th class="col-data-table-0-8">Số tờ test</th>
                      <th class="col-data-table-1">Số tờ in hư</th>
                      <th class="col-data-table-1-2">Số tờ kẹt giấy</th>
                      <th class="col-data-table-1-4">Số tờ hư - in lại</th>
                      <th class="col-data-table-1-3">Tổng số trang in</th>
                      <th class="col-data-table-1-8">Thao tác</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($print as $row) {
                    ?>
                    <tr id="row<?php echo $row['id']?>">
                      <td></td>
                      <td><?php echo $row['id_project']?></td>
                      <td id="name<?php echo $row['id']?>"><?php echo $row['name']?></td>
                      <td><?php echo $row['get_at'];?></td>
                      <td><?php echo $row['done_at']?></td>
                      
                      <td id="status_<?php echo $row['id']?>"><?php echo $row['status_name']?></td>
                      <td><?php echo number_format($row['tong_so_giay_in_su_dung'])?> (tờ)</td>
                      <td><?php echo $row['username']?></td>
                      <td><?php echo $row['customer']?></td>
                      <td><?php echo isset($row['note'])?$row['note']:''?></td>
                      
                      <td><?php echo $row['material_name']?></td>
                      <td><?php echo isset($row['big_size'])?$row['big_size']:'';?></td>
                      <td><?php echo $row['num_face']?></td>
                      <td><?php echo number_format($row['num_print'])?> (tờ)</td>
                      <td><?php echo $row['giacong_name']?></td>
                      <td><?php echo $row['note']?></td>
                      <td><?php echo $row['num_test']?> (tờ)</td>
                      <td><?php echo $row['num_bad']?> (tờ)</td>
                      <td><?php echo $row['num_jam']?> (tờ)</td>
                      <td><?php echo $row['num_reprint']?> (tờ)</td>
                      <td><?php echo number_format($row['tong_so_giay_in_su_dung']*$row['num_face'])?> (trang)</td>
                      <td>
                      <?php 
                      if($row['task_status'] != 't003'){ 
                      ?>
                        <button class="btn btn-primary btn-lg glyphicon glyphicon-edit" style="border-radius: 10px;" onclick="editRow('<?php echo $row['id_project']?>')">
                              </button>
                      <?php } 
                      if($row['tong_so_giay_in_su_dung'] != '' && $row['task_status'] != 't003'){
                      ?> 
                        <button class="btn btn-danger btn-lg" style="border-radius: 10px;" onclick="doneTask('<?php echo $row['id_task']?>','<?php echo($this->session->userdata('group'))?>')">Hoàn tất
                        </button>
                      <?php }?>
                      </td>
                    </tr>
                    <?php
                    } ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  <div class="modal fade" id="edit-modal">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
           <button type="button" class="close" data-dismiss='modal' aria-hidden="true"><span class="glyphicon glyphicon-remove"></span></button>
           <h4 class="modal-title" style="font-size: 20px; padding: 12px;"> Chỉnh sửa thông tin: </h4>
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
  function acceptNotif(id,group){
    $.ajax({
      type:'post',
      url:"<?php echo base_url(); ?>admin/task/accept_task",
      data: {
        'id': id,
        'group': group,
      },
      dataType: 'json',
      success: function(data){
        if(data){
          window.location.reload();
        }
      }
    });
  }
  function deniedNotif(id,group){
    $.ajax({
      type:'post',
      url:"<?php echo base_url(); ?>admin/task/denied_task",
      data: {
        'id': id,
        'group': group,
      },
      dataType: 'json',
      success: function(data){
        if(data){
         window.location.reload();
        }
      }
    });
  }

function doneTask(id,group){
    $.ajax({
      type:'post',
      url:"<?php echo base_url(); ?>admin/task/done_task",
      data: {
        'id': id,
        'group': group,
      },
      dataType: 'json',
      success: function(data){
        if(data){
          window.location.reload();
        }
      }
    });
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
$(document).ready(function(){
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
});
</script>