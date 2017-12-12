
<?php if(!$this->session->userdata('user_id'))
  echo "<div style='margin-left:500px; margin-top: 300px;'><h1>Bạn chưa đăng nhập</h1></div>";
else{
                ?> 
<div class="content-wrapper">
        <h3 style="margin-top: -15px; margin-bottom: 10px;">Bộ phận giao hàng - Danh sách công việc</h3>
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
                <button class="btn btn-success btn-sm" id="dropbtn" title="Lọc dự án"><i class="fa fa-bell-o fa-lg" aria-hidden="true"></i><span class="badge badge-notify" style="margin-top: -20px; margin-right: -15px; margin-left: -8px; background: red; color: white;"><?php echo isset($newtask)?count($newtask):'0'?></span></button>
                  <div class="dropdown-content" style="width: 97%; border-radius:10px;">
                    <form class="form-horizontal" method="post" action="">
                      <input type="hidden" id="statusDrop" value="0">
                      <br>
                      <div class="widget-content nopadding">
                        <ul class="recent-posts" id="new-notif" style="width: 100%">
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
                <table class="stripe row-border order-column" cellspacing="0" width="100%" id="sampleTable">
                  <thead>
                    <tr class="text-center">
                      <th class="col-data-table-0-1"></th>
                      <th class="col-data-table-0-7">Mã dự án</th>
                      <th class="col-data-table-0-9">Khách hàng</th>
                      <th class="col-data-table-1-1">Ngày nhận task</th>
                      <th class="col-data-table-0-9">Ngày hoàn thành</th>
                      <th class="col-data-table-1-2">Trạng thái task</th>
                      
                    
                      <th class="col-data-table-1-1">Tên dự án</th>
                      <th class="col-data-table-1-1">Tên khách hàng</th>
                      <th class="col-data-table-1-1">Email khách hàng</th>
                      <th class="col-data-table-1-1">Số điện thoại</th>
                      <th class="col-data-table-1-1">Địa chỉ</th>
                      <th class="col-data-table-1-1">Số lượng</th>
                      <th class="col-data-table-1-1">Đơn vị</th>
                      <th class="col-data-table-0-7">Ghi chú</th>
                      <th class="col-data-table-1-8">Thao tác</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($project as $row) {
                    ?>
                    <tr id="row<?php echo $row['id']?>">
                      <td></td>
                      <td><?php echo $row['id']?></td>
                      <td><?php echo $row['name']?></td>
                      <td><?php echo $row['get_at'];?></td>
                      <td><?php echo $row['done_at']?></td>
                      <td><?php echo $row['status_name']?></td>
                      
                      
                      <td><?php echo $row['project_name']?></td>
                      <td><?php echo $row['name'];?></td>
                      <td><?php echo $row['email']?></td>
                      <td><?php echo $row['phone']?></td>
                      <td><?php echo $row['address'];?></td>
                      <td><?php echo $row['quantity']?></td>
                      <td><?php echo $row['unit']?></td>
                      <td><?php echo isset($row['note']) ? $row['note'] : '';?></td>
                      <td>
                      <?php 
                      if($row['task_status'] != 't003'){ 
                      ?>
                        <button class="btn btn-success btn-sm" style="border-radius: 10px;" onclick="updateCost('<?php echo $row['id']?>')">Cập nhật chi phí</button>
                      <?php }?>
                      </td>
                    </tr>
                    <?php }?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  <div class="modal fade" id="update-cost">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
           <button type="button" class="close" data-dismiss='modal' aria-hidden="true"><span class="glyphicon glyphicon-remove"></span></button>
           <h4 class="modal-title" style="font-size: 20px; padding: 12px;"> Cập nhật doanh thu: </h4>
        </div>
        <form method="post" id="cost-form">
        <div class="modal-body">
           <div class="container-fluid">
              <div class="row">
                 <div class="col-xs-12 col-sm-12 col-md-12" id="form-update-cost">
                 </div>
              </div>
           </div>
        </div>

        <div class="modal-footer">
           <div class="form-group">
              <button type="button" class="btn btn-sm btn-info" onclick="subUpdateCost()"> Save <span class="glyphicon glyphicon-saved"></span></button>
              <button type="button" data-dismiss="modal" class="btn btn-sm btn-default"> Cancel <span class="glyphicon glyphicon-remove"></span></button>
           </div>
        </div>
        </form>
      </div>
    </div>
  </div>
<?php } ?>
<script type="text/javascript">

function updateCost(id){
  $.ajax({
    url:'<?=base_url()?>admin/revenue/load_data_update_cost/',
    type:'post',
    dataType:'json',
    data:{
      id_project:id
    },
    success:function(data){
      $('#form-update-cost').html(data);
      $('#update-cost').modal('show');
    }
  });
}

function subUpdateCost(){
  var route = '<?=base_url()?>admin/revenue/update_data_cost/';
  var frm = new FormData($('form#cost-form')[0]);
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
</script>