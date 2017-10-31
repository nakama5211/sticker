
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
          <div><a class="btn btn-primary btn-primary" onclick="newRow()"><i class="fa fa-lg fa-plus"></i></a></div>
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
              <div class="card-body" style="overflow-x:auto;">
                <table class="table table-hover table-bordered" id="sampleTable">
                  <thead>
                    <tr style="text-align: center;">
                      <th>ID</th>
                      <th style="min-width: 100px;">Thông tin khách hàng</th>
                      <!-- <th style="min-width: 120px;">Email</th>
                      <th>Số ĐT</th>
                      <th style="min-width: 120px;">Địa chỉ</th> -->
                      <th>Ghi chú</th>
                      <th style="min-width: 100px;">Tên sản phẩm</th>
                      <th>Kích thước</th>
                      <th>Số lượng</th>
                      <th>Đơn giá</th>
                      <th>File thiết kế</th>
                      <th>Trạng thái</th>
                      <th>Opt</th>
                    </tr>
                  </thead>
                  <tbody>
                  	<?php foreach ($bill as $row) {
                  	?>
                  	<tr id="row<?php echo $row['id']?>">
                      <td><?php echo $row['id']?></td>
                      <td><?php echo "".$row['customer']."</br>".$row['email']."</br>".$row['phone']."</br>".$row['address']."</br>".$row['created_at']?></td>
                      <!-- <td><?php echo $row['email']?></td>
                      <td><?php echo $row['phone']?></td>
                      <td><?php echo $row['address']?></td> -->
                      <td><?php echo $row['note']?></td>
                      <td><?php echo $row['typedecal'].";</br>".$row['extrusion']?></td>
                      <td><?php echo $row['width']."x".$row['height']." mm"?></td>
                      <td><?php echo $row['quantity']." cái"?></td>
                      <td><?php echo number_format($row['typedecal_price']+$row['extrusion_price'])."₫"?></td>
                      <td><?php echo "<img style='height: 120px; width: 120px;'src='".base_url()."upload/".$row['file']."'>"?></td>
                      <?php 
                        if($row['status']==3) echo "<td>Đã thanh toán</td>";
                        else if($row['status']==2) echo '<td style="background-color: rgba(0, 0, 255, 0.25);"> Chưa thanh toán</td>';
                        else echo "<td style='background-color: rgba(255, 0, 0, 0.25);'>Chưa xác nhận</td>";
                      ?>
                      <td>
                  		<?php 
                        echo '<button class="btn btn-info btn-lg glyphicon glyphicon-hand-right" style="border-radius: 10px;" onclick="checkRow('. $row['id'] .','.$this->session->userdata('group').')"></button>';
                        echo '<button class="btn btn-primary btn-lg glyphicon glyphicon-edit" style="border-radius: 10px;" onclick="editRow('. $row['id'] .')"></button>';
                        echo '<button class="btn btn-warning btn-lg glyphicon glyphicon-trash" style="border-radius: 10px;" onclick="cancelRow('. $row['id'] .')"></button>';
                        ?>
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
<?php } ?>
<script type="text/javascript">
function checkRow(id,group){
  document.getElementById("cur-id").value = id;
  $('#choose').modal('show');
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
function cancelRow(id)
{
  ssi_modal.confirm({
    content: 'Bạn có chắc muốn hủy đơn hàng này?',
    okBtn: {
    className:'btn btn-primary'
    },
    cancelBtn:{
    className:'btn btn-danger'
    }
    },function (result) {
      if(result){
          var route="<?= base_url()?>admin/admin/cancel_bill/";
          $.ajax({
            url:route,
            type:'GET',
            data:{
              id:id,
            },
            success:function() {  
                $('#row'+id).hide();
                ssi_modal.notify('success', {content: 'Thành công!!'});
            }
          }); 
       }else ssi_modal.notify('error', {content: 'Thất bại: ' + result});
    }
  );
}
  function editRow(id)
  {
    var  route="<?= base_url()?>admin/admin/edit_bill/id";
    route=route.replace('id',id);
    window.location.replace(route);
  }
  function newRow()
  {
    var  route="<?= base_url()?>admin/admin/add_bill/";
    window.location.replace(route);
  }
  // $(document).ready(function(){
  //   var route="<?= base_url()?>admin/admin/new_bill/";
  //   var time="<?php echo $row['created_at']?>";
  //   setInterval(function(){
  //       $.ajax({
  //       url:route,
  //       type:'get',
  //       dataType:'json',
  //       data:{
  //         time:time,
  //       },
  //       success:function(data) {  
  //           if(data.count_bill>0){
  //               $('.new-bill').html('<span class="label label-pill label-danger count" style="border-radius:10px;">'+data.count_bill+'</span>');
  //               $('#notif-dropdown').html(data.notif);
  //           }
  //           else{
  //               $('.new-bill').html("");
  //               $('#notif-dropdown').html('<li class="not-head">Chưa có thông báo mới!!</li>');
  //           }
           
  //       }
  //   });
  //   },10000);
  // });
</script>
