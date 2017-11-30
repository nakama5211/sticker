<div class="content-wrapper">
        <div class="page-title">
          <div>
            <h1>Data Table</h1>
            <ul class="breadcrumb side">
              <li><i class="fa fa-home fa-lg"></i></li>
              <li>Tables</li>
              <li class="active"><a href="<?php echo base_url().'admin/admin/view_admin/bill'?>">Bill</a></li>
            </ul>
          </div>
        </div>
        <?php if($ms=$this->session->userdata('error')){ ?>
          <div class="alert alert-danger" id="scs-msg" >
          <strong><?php echo $ms; ?></strong>
          </div>
          <script type="text/javascript">
          $(document).ready(function() {
            $('#scs-msg').fadeOut(2000); // 5 seconds x 1000 milisec = 5000 milisec
          });
          </script>
        <?php } ?>
        <div class="row">
            <div class="col-lg-12">
                <section class="panel">
                    <header class="panel-heading">
                        <h3 class="control-label">Sửa Hóa Đơn</h3>
                    </header>
                        <div class="panel-body">
                            <form class="form-horizontal bucket-form" enctype="multipart/form-data"  id="add-form" method="post" action="<?php echo base_url(); ?>admin/admin/update_bill/">
                                <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
                                <input type="hidden" name="id" value="<?php echo $bill[0]['id']?>">
                                <input type="hidden" name="id_customer" value="<?php echo $bill[0]['id_customer']?>">
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Tên</label>
                                    <div class="col-sm-6">
                                        <input type="text" required="" minlength="4" name="customer" value="<?php echo $bill[0]['customer']?>" name="user" class="form-control" >
                                    </div>
                                
                                </div>
                                
                                 <div class="form-group">
                                    <label class="col-sm-3 control-label">Email</label>
                                    <div class="col-sm-6">
                                         <input type="email" required="" name="email" value="<?php echo $bill[0]['email']?>" class="form-control"  >
                                    </div>

                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Số điện thoại</label>
                                    <div class="col-sm-6">
                                         <input type="tel" pattern="[0-9]{10,11}" title="10-11 chữ số." name="phone" value="<?php echo $bill[0]['phone']?>" class="form-control"  >
                                    </div>

                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Địa chỉ</label>
                                    <div class="col-sm-6">
                                         <input type="text" required="" name="address" value="<?php echo $bill[0]['address']?>" class="form-control"  >
                                    </div>

                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Ghi chú</label>
                                    <div class="col-sm-6">
                                         <input type="text" name="note" value="<?php echo $bill[0]['note']?>" class="form-control"  >
                                    </div>

                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Loại Decal</label>
                                    <div class="col-sm-6">
                                        <select id="decalpriceform-decaltype" class="form-control" name="id_typedecal" aria-required="true">
                                        <?php
                                        if(!$typedecal) echo "<option value='0'>Empty</option>";
                                        else{
                                            foreach ($typedecal as $row) {
                                                if($bill[0]['typedecal']==$row['id']){
                                                    echo "<option selected value=".$row['id'].">".$row['name']."</option>";
                                                }else echo "<option value=".$row['id'].">".$row['name']."</option>";
                                            }
                                        }
                                        ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Cán màng</label>
                                    <div class="col-sm-6">
                                        <select id="decalpriceform-isextrusion" class="form-control" name="id_extrusion" aria-required="true">
                                        <?php
                                        if(!$extrusion) echo "<option value='0'>Empty</option>";
                                        else{
                                            foreach ($extrusion as $row) {
                                                if($bill[0]['extrusion']==$row['id']){
                                                    echo "<option selected value=".$row['id'].">".$row['name']."</option>";
                                                }else echo "<option value=".$row['id'].">".$row['name']."</option>";
                                            }
                                        }
                                        ?>
                                    </select>
                                    
                                    </div>

                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Kích thước</label>
                                    <div class="col-sm-3">
                                         <input type="number" min="3" max="280" name="width" value="<?php echo $bill[0]['width']?>" class="form-control"  >
                                    </div>
                                    <div class="col-sm-3">
                                         <input type="number" min="3" max="280" value="<?php echo $bill[0]['height']?>" class="form-control"  name="height">
                                    </div>

                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Số lượng</label>
                                    <div class="col-sm-4">
                                         <input type="number" name="quantity" value="<?php echo $bill[0]['quantity']?>" class="form-control"  >
                                    </div>
                                    <div class="col-sm-2">
                                        <select id="decalpriceform-unit" class="form-control" name="unit" aria-required="true">
                                        <?php
                                        if(!$unit) echo "<option value='0'>Empty</option>";
                                        else{
                                            foreach ($unit as $row) {
                                                if($bill[0]['unit']==$row['id']){
                                                    echo "<option selected value=".$row['id'].">".$row['name']."</option>";
                                                }else echo "<option value=".$row['id'].">".$row['name']."</option>";
                                            }
                                        }
                                        ?>
                                    </select>
                                    
                                    </div>
                                </div>
                                
                                 <div class="form-group">
                                    <label class=" col-sm-3 control-label ">File thiết kế</label>
                                    <div class="col-sm-6">
                                      <div class="input-group">
                                        <input type="text" class="form-control" name="" disabled="" id="f_in" value="<?php echo $bill[0]['file']?>">
                                        <div class="input-group-addon iga2">
                                           <label style="margin-bottom: 0px;" class="fa"><b>Browse...</b><input onchange="file_change(this,0);" type="file" id="f" name="file" style="display: none;"></label>
                                        </div>
                                      </div>
                                      <?php if($bill[0]['file']!=''){?>
                                      <img src="<?php echo base_url().'upload/'.$bill[0]['file']?>" width="100%" height="auto" id="img0" style="margin-top: 10px;  display: block;" />
                                      <?php }else{?>
                                      <img src="" width="100%" height="auto" id="img0" style="margin-top: 10px;  display: none;" />
                                      <?php }?>
                                    </div>
                                </div>
                                <button type="submit" class="button submit-button btn btn-info btn-lg glyphicon glyphicon-floppy-save saveEdit" style="border-radius: 10px; float: right; margin-right: 150px;">Save</button>           
                            </form>
                    	</div>
                </section>

            </div>
        </div>
      </div>
<script type="text/javascript">
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
      break;
    default:
      alert('Tập tin này không được hỗ trợ! Bạn chỉ được chọn file ảnh.');
      $("#f").val(null);
      $("#f_in").val(null);
      $("#img0").hide();
  }
}
</script>