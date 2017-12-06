<div class="content-wrapper">
        <div class="page-title">
          <div>
            <h1>Chỉnh sửa dự án</h1>
            <ul class="breadcrumb side">
              <li><i class="fa fa-home fa-lg"></i></li>
              <li>Home</li>
              <li class="active"><a href="<?php echo base_url().'admin/admin/view_admin/project'?>">Project</a></li>
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
                        <h3 class="control-label">Chỉnh Sửa Dự Án</h3>
                    </header>
                        <div class="panel-body">
                            <form class="form-horizontal bucket-form" enctype="multipart/form-data"  id="add-form" method="post" action="<?php echo base_url(); ?>updateProject">
                                <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
                                 <input type="hidden" name="id" value="<?php echo $project[0]['id_project'] ?>">
                                 <input type="hidden" name="id_customer" value="<?php echo $project[0]['ma_khachhang'] ?>">
                                 <input type="hidden" name="id_bill" value="<?php echo $project[0]['id_bill'] ?>">
                                 <div class="form-group">
                                    <label class="col-sm-3 control-label">Tên dự án</label>
                                    <div class="col-sm-6">
                                         <input type="text" name="name_project" value="<?php echo $project[0]['project_name'] ?>" class="form-control" required="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Khách hàng</label>
                                    <div class="col-sm-6">
                                         <input type="text" name="name_customer" value="<?php echo $project[0]['customer'] ?>" class="form-control" placeholder="Tên khách hàng" >
                                    </div>
                                    <button class="btn btn-primary" id="btnCustomer"><i class="fa fa-angle-down" aria-hidden="true"></i></button>
                                </div>
                                <div id="customer" style="display: none;">
                                    <input type="hidden" id="statusCustomer" value="0">
                                    <div class="form-group">
                                        <div class="col-md-3"></div>
                                        <div class="col-md-6">
                                           <input type="tel" pattern="[0-9]{10,11}"  title="10-11 chữ số." name="phone" class="form-control" value="<?php echo $project[0]['phone'] ?>" >
                                        </div>
                                    </div>
                                    <div class="form-group">
                                          <div class="col-md-3"></div>
                                          <div class="col-md-6">
                                             <input type="email" name="email" value="<?php echo $project[0]['email'] ?>" class="form-control" placeholder="Email" >
                                          </div>
                                    </div>
                                    <div class="form-group">
                                          <div class="col-md-3"></div>
                                          <div class="col-md-6">
                                             <input type="text" name="address" value="<?php echo $project[0]['address'] ?>" class="form-control" placeholder="Địa chỉ" >
                                          </div>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Loại Dự Án</label>
                                    <div class="col-sm-6">
                                        <select id="decalpriceform-decaltype" class="form-control" name="id_typeProject" required="" aria-required="true">
                                        <option selected hidden disabled value="">Chọn loại dự án</option>
                                        <?php
                                        if(!$typeProjects) echo "<option value='0'>Empty</option>";
                                        else{
                                          foreach ($typeProjects as $typePro) {
                                            if ($typePro['id'] == $project[0]['id_typeproject']) {
                                              echo "<option value=".$typePro['id']." selected>".$typePro['name']."</option>";
                                            }else{
                                              echo "<option value=".$typePro['id'].">".$typePro['name']."</option>";
                                            }
                                          }
                                        }
                                        ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Thông tin đơn hàng</label>
                                    <div class="col-sm-6">
                                        <input type="hidden" id="statusDonhang" value="0" class="form-control" >
                                    </div>
                                    <button class="btn btn-primary" id="btnDonhang"><i class="fa fa-angle-down" aria-hidden="true"></i></button>
                                </div>
                                <div id="donhang" style="display: none;">
                                  <div class="form-group">
                                    <label class="col-sm-3 control-label"></label>
                                    <div class="col-sm-6">
                                         <input type="text" name="so_luong" value="<?php echo  number_format($donhang['quantity']) ?>" class="form-control so" >
                                    </div>
                                    <span>*Số lượng</span>
                                  </div>
                                  <div class="form-group">
                                    <label class="col-sm-3 control-label"></label>
                                    <div class="col-sm-6">
                                         <input type="text" name="donvi" value="<?php echo $donhang['unit'] ?>" class="form-control" >
                                    </div>
                                    <span>*Đơn vị tính</span>
                                  </div>
                                  <div class="form-group">
                                      <label class="col-sm-3 control-label"></label>
                                      <div class="col-sm-6">
                                           <textarea name="note_donhang" value="" class="form-control" placeholder="Ghi chú" ><?php echo $donhang['note'] ?></textarea>
                                      </div>
                                      <span>*Ghi chú đơn hàng</span>
                                  </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Doanh thu</label>
                                    <div class="col-sm-6">
                                        <input type="text" name="doanhthu" value="<?php echo number_format($project[0]['tong_doanhthu']) ?>" class="form-control so" >
                                    </div>
                                    <button class="btn btn-primary" id="btnDoanhthu"><i class="fa fa-angle-down" aria-hidden="true"></i></button>
                                </div>
                                <div id="doanhthu" style="display: none;">
                                  <input type="hidden" id="statusDoanhthu" value="0">
                                  <div class="form-group">
                                    <label class="col-sm-3 control-label"></label>
                                    <div class="col-sm-6">
                                         <input type="text" name="tam_ung" value="<?php echo number_format($doanhthu['tam_ung']) ?>" class="form-control so" >
                                    </div>
                                    <span>*Tạm ứng</span>
                                  </div>
                                  <div class="form-group">
                                      <label class="col-sm-3 control-label"></label>
                                      <div class="col-sm-6">
                                           <textarea name="note_doanhthu" value="" class="form-control"  ><?php echo $doanhthu['ghi_chu'] ?></textarea>
                                      </div>
                                  </div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Chi phí</label>
                                    <div class="col-sm-6">
                                         <input type="text" readonly="" id="tong_chiphi" name="chiphi" class="form-control" value="<?php echo number_format($project[0]['tong_chiphi']) ?>" >
                                    </div>
                                    <button class="btn btn-primary" id="btnChiphi"><i class="fa fa-angle-down" aria-hidden="true"></i></button>
                                </div>
                                <div id="chiphi" style="display: none;">
                                    <input type="hidden" id="statusChiphi" value="0">
                                    <div class="form-group">
                                      <label class="col-sm-3 control-label"></label>
                                      <div class="col-sm-6">
                                         <input type="text" readonly="" value="<?php echo number_format($chiphi['chiphi_giay']) ?>" name="chiphi_giay" id="chiphi_giay" class="form-control" >
                                      </div>
                                      <span>*Chi phí giấy</span>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label"></label>
                                        <div class="col-sm-6">
                                             <input type="text" value="<?php echo number_format($chiphi['chiphi_inngoai']) ?>" name="chiphi_inngoai" id="chiphi_inngoai" class="form-control so"  >
                                        </div>
                                        <span>*Chi phí in ngoài</span>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label"></label>
                                        <div class="col-sm-6">
                                             <input type="text" value="<?php echo number_format($chiphi['chiphi_giacong']) ?>" name="chiphi_giacong" id="chiphi_giacong" class="form-control so"  >
                                        </div>
                                        <span>*Chi phí gia công</span>
                                    </div>
                                     <div class="form-group">
                                        <label class="col-sm-3 control-label"></label>
                                        <div class="col-sm-6">
                                             <input type="text" name="chiphi_giaohang" value="<?php echo number_format($chiphi['chiphi_giaohang']) ?>" id="chiphi_giaohang" class="form-control so"  >
                                        </div>
                                        <span>*Chi phí giao hàng</span>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Ngày nhận hàng</label>
                                    <div class="col-sm-6">
                                         <input type="date" id="today" name="deadline" value="" class="form-control" >
                                    </div>
                                </div>
                                <div class="form-group">
                                  <div style="margin: 0px 45%;">
                                    <button type="submit" class="button submit-button btn btn-info btn-lg glyphicon glyphicon-floppy-save saveEdit" style="border-radius: 10px; ">Save</button>
                                  </div>
                                </div>
                            </form>
                    	</div>
                </section>
            </div>
        </div>
      </div>
<script type="text/javascript">
document.querySelector("#today").valueAsDate = new Date();

$("#btnCustomer").on('click', function(event) {
  event.preventDefault();
  var status = $('#statusCustomer').val();
  if (status == 0) {
    $('#customer').show();
    $('#statusCustomer').val(1);
    $(this).html('<i class="fa fa-angle-up" aria-hidden="true"></i>');
  }else{
    $('#customer').hide();
    $('#statusCustomer').val(0);
    $(this).html('<i class="fa fa-angle-down" aria-hidden="true"></i>');
  }
  
});
$("#btnDoanhthu").on('click', function(event) {
  event.preventDefault();
  var status = $('#statusDoanhthu').val();
  if (status == 0) {
    $('#doanhthu').show();
    $('#statusDoanhthu').val(1);
    $(this).html('<i class="fa fa-angle-up" aria-hidden="true"></i>');
  }else{
    $('#doanhthu').hide();
    $('#statusDoanhthu').val(0);
    $(this).html('<i class="fa fa-angle-down" aria-hidden="true"></i>');
  }
});

$("#btnChiphi").on('click', function(event) {
  event.preventDefault();
  var status = $('#statusChiphi').val();
  if (status == 0) {
    $('#chiphi').show();
    $('#statusChiphi').val(1);
    $(this).html('<i class="fa fa-angle-up" aria-hidden="true"></i>');
  }else{
    $('#chiphi').hide();
    $('#statusChiphi').val(0);
    $(this).html('<i class="fa fa-angle-down" aria-hidden="true"></i>');
  }
});
$("#btnDonhang").on('click', function(event) {
  event.preventDefault();
  var status = $('#statusDonhang').val();
  if (status == 0) {
    $('#donhang').show();
    $('#statusDonhang').val(1);
    $(this).html('<i class="fa fa-angle-up" aria-hidden="true"></i>');
  }else{
    $('#donhang').hide();
    $('#statusDonhang').val(0);
    $(this).html('<i class="fa fa-angle-down" aria-hidden="true"></i>');
  }
});


$("#btnIn").on('click', function(event) {
  event.preventDefault();
  var status = $('#statusIn').val();
  if (status == 0) {
    $('#in').show();
    $('#statusIn').val(1);
    $(this).html('<i class="fa fa-angle-up" aria-hidden="true"></i>');
  }else{
    $('#in').hide();
    $('#statusIn').val(0);
    $(this).html('<i class="fa fa-angle-down" aria-hidden="true"></i>');
  }
  
});
$(document).ready(function() {
  
  $('#chiphi_inngoai').keyup(function(event) {
    var inngoai = unformatCurrency($(this).val());
    var giay = unformatCurrency($('#chiphi_giay').val());
    var giacong = unformatCurrency($('#chiphi_giacong').val());
    var giaohang = unformatCurrency($('#chiphi_giaohang').val());
    var tong = giay+inngoai+giacong+giaohang;
    $('#tong_chiphi').val(formatCurrency(tong.toString()));
  });
  $('#chiphi_giacong').keyup(function(event) {
    var giacong = unformatCurrency($(this).val());
    var inngoai = unformatCurrency($('#chiphi_inngoai').val());
    var giay = unformatCurrency($('#chiphi_giay').val());
    var giaohang = unformatCurrency($('#chiphi_giaohang').val());
    var tong = giay+inngoai+giacong+giaohang;
    $('#tong_chiphi').val(formatCurrency(tong.toString()));
  });
  $('#chiphi_giaohang').keyup(function(event) {
    var giaohang = unformatCurrency($(this).val());
    var inngoai = unformatCurrency($('#chiphi_inngoai').val());
    var giacong = unformatCurrency($('#chiphi_giacong').val());
    var giay = unformatCurrency($('#chiphi_giay').val());
    var tong = giay+inngoai+giacong+giaohang;
    $('#tong_chiphi').val(formatCurrency(tong.toString()));
  });




  

  //đinh dạng tiền tệ cho cac thẻ input có class=so
  $('.so').on('input', function(e){
    if ($(this).val() == '') {
              $(this).val(0);
        }        
    $(this).val(formatCurrency(this.value.replace(/[,VNĐ]/g,'')));
    }).on('keypress',function(e){
        if ($(this).val() == 0)
          $(this).val('');
        if(!$.isNumeric(String.fromCharCode(e.which))) e.preventDefault();
    }).on('paste', function(e){    
        var cb = e.originalEvent.clipboardData || window.clipboardData;      
        if(!$.isNumeric(cb.getData('text'))) e.preventDefault();
    });
    function formatCurrency(number){
        var n = number.split('').reverse().join("");
        var n2 = n.replace(/\d\d\d(?!$)/g, "$&,");    
        return  n2.split('').reverse().join('');
    }
    function unformatCurrency(number) {
      return n = parseFloat(number.replace(/[^0-9-.]/g, ''));
    }
});

</script>