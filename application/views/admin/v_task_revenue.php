
<?php if(!$this->session->userdata('user_id'))
  echo "<div style='margin-left:500px; margin-top: 300px;'><h1>Bạn chưa đăng nhập</h1></div>";
else{
                ?> 
<div class="content-wrapper">
        <h3 style="margin-top: -15px; margin-bottom: 10px;">Bộ phận kế toán - Danh sách công việc</h3>
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
                <table class="stripe row-border order-column" cellspacing="0" width="100%" id="sampleTable">
                  <thead>
                    <tr class="text-center">
                      <th class="col-data-table-0-1"></th>
                      <th class="col-data-table-0-7">Mã dự án</th>
                      <th class="col-data-table-0-9">Khách hàng</th>
                      <th class="col-data-table-1-1">Ngày nhận task</th>
                      <th class="col-data-table-0-9">Ngày hoàn thành</th>
                      <th class="col-data-table-1-2">Trạng thái task</th>
                      
                      <th class="col-data-table-0-9">Doanh thu (VNĐ)</th>
                      <th class="col-data-table-0-9">Chi phí (VNĐ)</th>
                      <th class="col-data-table-0-9">Ngày tạo</th>
                      <th class="col-data-table-1-1">Tên dự án</th>
                      <th class="col-data-table-0-7">Tạm ứng</th>
                      <th class="col-data-table-1-5">Thời gian tạm ứng</th>
                      <th class="col-data-table-1-7">Doanh thu thiết kế</th>
                      <th class="col-data-table-0-9">Chi phí giấy</th>
                      <th class="col-data-table-0-9">Chi phí in</th>
                      <th class="col-data-table-1-2">Chi phí gia công</th>
                      <th class="col-data-table-1-2">Chi phí giao hàng</th>
                      <th class="col-data-table-0-7">Lợi nhuận</th>
                      <th class="col-data-table-1-2">Tỉ suất lợi nhuận</th>
                      <th class="col-data-table-1-5">Tình trạng đơn hàng</th>
                      <th class="col-data-table-1-4">Tình trạng thu tiền</th>
                      <th class="col-data-table-1-4">Phiếu thu/ Hóa đơn</th>
                      <th class="col-data-table-1-6">Thời gian hoàn thành</th>
                      <th class="col-data-table-0-7">Ghi chú</th>
                      <th class="col-data-table-1-8">Thao tác</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($revenue as $row) {
                    ?>
                    <tr id="row<?php echo $row['id']?>">
                      <td></td>
                      <td><?php echo $row['id']?></td>
                      <td><?php echo $row['name']?></td>
                      <td><?php echo $row['get_at'];?></td>
                      <td><?php echo $row['done_at']?></td>
                      <td><?php echo $row['status_name']?></td>
                      
                      <td><?php echo number_format($row['tong_doanhthu'])?></td>
                      <td><?php echo number_format($row['tong_chiphi'])?></td>
                      <td><?php echo $row['created_at']?></td>
                      <td><?php echo $row['project_name']?></td>
                      <td><?php echo number_format($row['tam_ung']).' vnđ'?></td>
                      <td><?php echo isset($row['ngay_tam_ung']) ? $row['ngay_tam_ung'] : '';?></td>
                      <td><?php echo isset($row['doanhthu_thietke']) ? number_format($row['doanhthu_thietke']).' vnđ' : '';?></td>
                      <td><?php echo isset($row['chiphi_giay']) ? number_format($row['chiphi_giay']).' vnđ' : '';?></td>
                      <td><?php echo isset($row['chiphi_inngoai']) ? number_format($row['chiphi_inngoai']).' vnđ' : '';?></td>
                      <td><?php echo isset($row['chiphi_giacong']) ? number_format($row['chiphi_giacong']).' vnđ' : '';?></td>
                      <td><?php echo isset($row['chiphi_giaohang']) ? number_format($row['chiphi_giaohang']).' vnđ' : '';?></td>
                      <td><?php echo number_format($row['tong_doanhthu']-$row['tong_chiphi']).' vnđ';?></td>
                      <td><?php echo number_format(($row['tong_doanhthu']-$row['tong_chiphi'])/$row['tong_doanhthu']*100).' %';?></td>
                      <td><?php echo isset($row['status_don_hang']) ? $row['status_don_hang'] : '';?></td>
                      <td><?php echo isset($row['status_thu_tien']) ? $row['status_thu_tien'] : '';?></td>
                      <td><?php echo isset($row['phieu_thu']) ? $row['phieu_thu'] : '';?></td>
                      <td><?php echo isset($row['ngay_hoan_thanh_don_hang']) ? $row['ngay_hoan_thanh_don_hang'] : '';?></td>
                      <td><?php echo isset($row['note']) ? $row['note'] : '';?></td>
                      <td>
                      <?php 
                      if($row['task_status'] != 't003'){ 
                      ?>
                        <button class="btn btn-primary btn-sm" style="border-radius: 10px;" onclick="updateRevenue('<?php echo $row['id']?>')">Cập nhật doanh thu</button> 
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
   <div class="modal fade" id="update-revenue">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
           <button type="button" class="close" data-dismiss='modal' aria-hidden="true"><span class="glyphicon glyphicon-remove"></span></button>
           <h4 class="modal-title" style="font-size: 20px; padding: 12px;"> Cập nhật doanh thu: </h4>
        </div>
        <form method="post" id="revenue-form">
        <div class="modal-body">
           <div class="container-fluid">
              <div class="row">
                 <div class="col-xs-12 col-sm-12 col-md-12" id="form-update-revenue">
                 </div>
              </div>
           </div>
        </div>

        <div class="modal-footer">
           <div class="form-group">
              <button type="button" class="btn btn-sm btn-info" onclick="subUpdateRevenue()"> Save <span class="glyphicon glyphicon-saved"></span></button>
              <button type="button" data-dismiss="modal" class="btn btn-sm btn-default"> Cancel <span class="glyphicon glyphicon-remove"></span></button>
           </div>
        </div>
        </form>
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
function updateRevenue(id){
  $.ajax({
    url:'<?=base_url()?>admin/revenue/load_data_update_revenue/',
    type:'post',
    dataType:'json',
    data:{
      id_project:id
    },
    success:function(data){
      $('#form-update-revenue').html(data);
      $('#update-revenue').modal('show');
    }
  });
}
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
function subUpdateRevenue(){
  var route = '<?=base_url()?>admin/revenue/update_data_revenue/';
  var frm = new FormData($('form#revenue-form')[0]);
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
</script>