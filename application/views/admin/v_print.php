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
          <!-- <div><a class="btn btn-primary btn-flat" href="#"><i class="fa fa-lg fa-plus"></i></a><a class="btn btn-info btn-flat" href="#"><i class="fa fa-lg fa-refresh"></i></a><a class="btn btn-warning btn-flat" href="#"><i class="fa fa-lg fa-trash"></i></a></div> -->
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-body">
                <table class="stripe row-border order-column" id="sampleTable">
                  <thead>
                    <tr style="text-align: center;">
                      <th></th>
                      <th class="col-data-table-0-6">Ngày</th>
                      <th class="col-data-table-0-7">Mã bài in</th>
                      <th class="col-data-table-0-8">Máy in</th>
                      <th class="col-data-table-1">NV in</th>
                      <th class="col-data-table-1-9">Khách hàng</th>
                      <th class="col-data-table-0-8">Mô tả</th>
                      <th class="col-data-table-0-7">Số lượng</th>
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
                      <td id="created_at<?php echo $row['id']?>"><?php echo $row['created_at']?></td>
                      <td><?php echo $row['id_project']?></td>
                      <td id="name<?php echo $row['id']?>"><?php echo $row['name']?></td>
                      <td><?php echo $row['username']?></td>
                      <td><?php echo $row['customer']?></td>
                      <td><?php echo $row['bill_note']?></td>
                      <td id="quantity<?php echo $row['id']?>"><?php echo $row['quantity']?></td>
                      <td id="id_material<?php echo $row['id']?>"><?php echo $row['material']?></td>
                      <td><?php echo $row['exc_size']?></td>
                      <td id="num_face<?php echo $row['id']?>"><?php echo $row['num_face']?></td>
                      <td id="num_print<?php echo $row['id']?>"><?php echo $row['num_print']?></td>
                      <td id="outsource<?php echo $row['id']?>"><?php echo $row['outsource_name']?></td>
                      <td id="note<?php echo $row['id']?>"><?php echo $row['note']?></td>
                      <td id="num_test<?php echo $row['id']?>"><?php echo $row['num_test']?></td>
                      <td id="num_bad<?php echo $row['id']?>"><?php echo $row['num_bad']?></td>
                      <td id="num_jam<?php echo $row['id']?>"><?php echo $row['num_jam']?></td>
                      <td id="num_reprint<?php echo $row['id']?>"><?php echo $row['num_reprint']?></td>
                      <td></td>
                      <td>
                        <?php 
                          echo '<button class="btn btn-primary btn-lg glyphicon glyphicon-edit" style="border-radius: 10px;" onclick="editRow('. $row['id'] .')">
                              </button>';
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
  <div class="modal fade" id="edit-modal">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
           <button type="button" class="close" data-dismiss='modal' aria-hidden="true"><span class="glyphicon glyphicon-remove"></span></button>
           <h4 class="modal-title" style="font-size: 20px; padding: 12px;"> Update Data Row </h4>
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

        <div class="modal-footer">
           <div class="form-group">
              <button type="button" class="btn btn-sm btn-info" onclick="subEditForm()"> Save <span class="glyphicon glyphicon-saved"></span></button>
              <button type="button" data-dismiss="modal" class="btn btn-sm btn-default"> Cancel <span class="glyphicon glyphicon-remove"></span></button>
           </div>
        </div>
        </form>
      </div>
    </div>
  </div>
<?php } ?>
<script type="text/javascript">
function editRow(id){
  $.ajax({
    url:'<?=base_url()?>admin/printer/load_data_for_edit_form/',
    type:'post',
    dataType:'json',
    data:{
      id:id
    },
    success:function(data){
      $('#form-data-edit').html(data);
      $('#edit-modal').modal('show');
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
        var table = $('#sampleTable').DataTable();
        $('#edit-modal').modal('hide');
        for (let [key, value] of Object.entries(data.response[0])) {
            table.cell($('#'+key+frm.get('id'))).data(value).draw();
        }
        if(data.success) ssi_modal.notify('success', {content: 'Thành công!!'});
        if(data.fail) ssi_modal.notify('error', {content: 'Thất bại!!'});
      }
    }
  });
}
</script>