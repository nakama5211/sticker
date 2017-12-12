
<?php if(!$this->session->userdata('user_id'))
  echo "<div style='margin-left:500px; margin-top: 300px;'><h1>Bạn chưa đăng nhập</h1></div>";
else{
                ?> 
<div class="content-wrapper">
        <div class="page-title">
          <h3>Quản lý trạng thái</h3>
          <div>
          <a class="btn btn-sm btn-primary btn-primary" onclick="addRow()"><i class="fa fa-lg fa-plus"></i></a>
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
                <table class="stripe row-border order-column" id="sampleTable">
                  <thead>
                    <tr style="text-align: center;">
                      <th class="col-data-table-0-1"></th>
                      <th class="col-data-table-0-5">ID</th>
                      <th class="col-data-table-0-8">Loại</th>
                      <th class="col-data-table-1-2">Tên</th>
                      <th class="col-data-table-0-8">Ngày tạo</th>
                      <th class="col-data-table-0-8">Ngày cập nhật</th>
                      <th class="col-data-table-1-8">Thao tác</th>
                    </tr>
                  </thead>
                  <tbody>
                  	<?php foreach ($status as $row) {
                  	?>
                  	<tr id="row<?php echo $row['id']?>">
                      <td></td>
                      <td><?php echo $row['id']?></td>
                      <td id="type<?php echo $row['id']?>"><?php echo $row['type']?></td>
                      <td id="name<?php echo $row['id']?>"><?php echo $row['name']?></td>                  
                      <td id="created_at<?php echo $row['id']?>"><?php echo $row['created_at']?></td>
                      <td id="updated_at<?php echo $row['id']?>"><?php echo $row['updated_at']?></td>
                      <td>
                      	<button class="btn btn-primary btn-sm glyphicon glyphicon-edit" style="border-radius: 10px;" onclick="editRow('<?php echo $row['id']?>')">
                        </button> 
                        <button class="btn btn-warning btn-sm glyphicon glyphicon-trash" style="border-radius: 10px;" onclick="delRow('<?php echo $row['id']?>')">
                         </button> 
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
  <div class="modal fade" id="edit-row" data-backdrop='static'>
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
           <button type="button" class="close" data-dismiss='modal' aria-hidden="true"><span class="glyphicon glyphicon-remove"></span></button>
           <h4 class="modal-title" style="font-size: 20px; padding: 12px;"> Sửa dữ liệu </h4>
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
  <div class="modal fade" id="add-row" data-backdrop='static'>
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
           <button type="button" class="close" data-dismiss='modal' aria-hidden="true"><span class="glyphicon glyphicon-remove"></span></button>
           <h4 class="modal-title" style="font-size: 20px; padding: 12px;"> Thêm dữ liệu mới </h4>
        </div>
        <form method="post" id="add-form">
        <div class="modal-body">
           <div class="container-fluid">
              <div class="row">
                 <div class="col-xs-12 col-sm-12 col-md-12" id="form-data-add">
                    <div class="form-group">
	                   	<div><b>Mã trạng thái</b></div>
	                 	<div class="input-group">
	                    	<div class="input-group-addon iga2">
	                       		<span class="fa fa-pencil-square"></span>
	                    	</div>
	                    <input type="text" class="form-control" name="id" value="">
	                 	</div>
	                 	<div class="help-block" id="error-id"></div>
	                </div>
                  <div class="form-group">
                      <div><b>Tên Loại</b></div>
                    <div class="input-group">
                        <div class="input-group-addon iga2">
                            <span class="fa fa-pencil-square"></span>
                        </div>
                      <input type="text" class="form-control" name="type" value="">
                    </div>
                    <div class="help-block" id="error-type"></div>
                  </div>
	                <div class="form-group">
	                   	<div><b>Tên trạng thái</b></div>
	                 	<div class="input-group">
	                    	<div class="input-group-addon iga2">
	                       		<span class="fa fa-pencil-square"></span>
	                    	</div>
	                    <input type="text" class="form-control" name="name" value="">
	                 	</div>
	                 	<div class="help-block" id="error-name"></div>
	                </div>
                 </div>
              </div>
           </div>
        </div>

        <div class="modal-footer">
           <div class="form-group">
              <button type="button" class="btn btn-sm btn-info" onclick="subAddForm()"> Save <span class="glyphicon glyphicon-saved"></span></button>

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
    url:'<?=base_url()?>admin/resource/load_data_row',
    type:'post',
    dataType:'json',
    data:{
      id:id,
      table:'status'
    },
    success:function(data){
      $('#form-data-edit').html(data);
      $('#edit-row').modal('show');
    }
  });
}
function subEditForm(){
  var route = '<?=base_url()?>admin/resource/update_data_row/';
  var frm = new FormData($('form#edit-form')[0]);
  $.ajax({
    url:route,
    processData: false, 
    contentType: false,
    type:'post',
    dataType:'json',
    data:frm,
    success:function(data){
      $('#edit-row').modal('hide');
      for (let [key, value] of Object.entries(data.response[0])) {
        $('#'+key+frm.get('id')).html(value);
      }
      if(data.success) ssi_modal.notify('success', {content: 'Thành công!!'});
      if(data.fail) ssi_modal.notify('error', {content: 'Thất bại!!'});
    }
  });
}
function addRow(){
  $('#add-row').modal('show');
}
function subAddForm(){
  var route = '<?=base_url()?>admin/resource/add_data_row/';
  var frm = new FormData($('form#add-form')[0]);
  frm.set('table','status');
  $.ajax({
    url:route,
    processData: false, 
    contentType: false,
    type:'post',
    dataType:'json',
    data:frm,
    success:function(data){
      if(data.error){
        for (let [key, value] of Object.entries(data.error)){
          $('#error-'+key).html(value);
        }
      }else{
        if (data.err) {
          ssi_modal.notify('error', {content: data.err});
        }else{
        window.location.reload();
        }
        // var row = [];
        // row.push('');
        // for (let [key, value] of Object.entries(data.response[0])) {
        //   row.push('<i id="'+key+data.response[0].id+'">'+value+'</i>');
        // }
        // row.push('<button class="btn btn-primary btn-sm fa fa-pencil" style="border-radius: 10px;" onclick="editRow('+data.response[0].id+')"></button> <button class="btn btn-warning btn-sm fa fa-trash" style="border-radius: 10px;" onclick="delRow("'+data.response[0].id+'")"></button>');
        // $('#add-row').modal('hide');
        // var rowIndex = $('#sampleTable').dataTable().fnAddData(row); 
        // var irow = $('#sampleTable').dataTable().fnGetNodes(rowIndex);
        // $(irow).attr('id', data.response[0].id);
        // if(data.success) ssi_modal.notify('success', {content: 'Thành công!!'});
        // if(data.fail) ssi_modal.notify('error', {content: 'Thất bại!!'});
      }
    }
  });  
}
function delRow(id){
  ssi_modal.confirm({
  content: 'Bạn có chắc muốn xóa dòng này?',
  okBtn: {
  className:'btn btn-primary'
  },
  cancelBtn:{
  className:'btn btn-danger'
  }
  },function (result) {
    if(result){
      var route="<?= base_url()?>admin/resource/del_row/";
      $.ajax({
      url:route,
      type:'post',
      data:{
        id:id,
      },
      success:function(){  
          $('#sampleTable').dataTable().fnDeleteRow($("#row"+id)[0]);
          ssi_modal.notify('success', {content: 'Thành công!!'});
        }
      });
    }
    else
      ssi_modal.notify('error', {content: 'Thất bại: ' + result});
    }
  );
}
</script>