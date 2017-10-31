<div class="container-fluid text-center content">
	<div class="panel-heading">
		<h2 class="">Thông tin đặt hàng</h2>
	</div>
	<form id="order-form" class="form-horizontal" action="<?= base_url()?>home/order/" method="post" enctype="multipart/form-data">
		<input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
		<div id="cart-grid" class="grid-view">
			<table class="table table-striped table-bordered">
				<thead>
					<tr>
						<th>Sản phẩm</th>
						<th>Đơn giá</th>
						<th>Số lượng</th>
						<th>Thành tiền</th>
						<th>File thiết kế</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<tr data-key="1">
						
						<td><?php echo $typedecal[0]['name']."; ".$extrusion[0]['name'];?><br>Kính thước: <?php echo $width."x".$height?> mm</td>
						<td><?php echo number_format($price=$typedecal[0]['price']+$extrusion[0]['price']);?>₫</td>
						<td><?php echo $quantity?></td>
						<td><?php echo number_format($price*$quantity)?>₫</td>
						<td>
							<div class="field-orderform-uploadfiles">
								<input type="file" name="uploadFiles" id="f" onchange="file_change(this,0)" value="" title="Chọn file">
                                <img class="pull-left" src="" width="50px" height="50px" id="img0" style="display: none;" />
							</div>
						</td>
						<td class="text-center">
						<a href="/sticker" type="button" class="btn btn-sm btn-warning" title="Sửa đơn hàng"><i class="glyphicon glyphicon-edit"></i> Sửa</a> 
						<a href="<?= base_url() ?>index.php/home/destroy/" type="button" class="btn btn-sm btn-danger" title="Huỷ đơn hàng"><i class="glyphicon glyphicon-remove" title="Huỷ đơn hàng"></i> Huỷ</a></td></tr>
					</tbody>
				</table>
			</div>
			<div class="row">
				<div class="col-md-8">
					<div class="panel panel-default">
						<div class="panel-body">
							<div class="form-group">
								<label class="control-label col-md-4 col-xs-4 col-sm-6">Tên khách hàng</label>
								<div class="col-md-8 col-xs-8 col-sm-6">
									<div class="field-orderform-customername required">
										<input type="text" id="orderform-customername" class="form-control " name="customerName" placeholder="Tên của quý khách" aria-required="true">
										<div id="order-form_customerName_errorloc" class="alert-danger" ></div>
									</div>              
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-md-4">Điện thoại</label>
								<div class="col-md-8">
									<div class="field-orderform-customerphone required">
										<input type="text" id="orderform-customerphone" class="form-control" name="customerPhone" placeholder="Số điện thoại" aria-required="true">
										<div id="order-form_customerPhone_errorloc" class="alert-danger" ></div>
									</div>              
								</div>
							</div>

							<div class="form-group">
								<label class="control-label col-md-4">Email</label>
								<div class="col-md-8">
									<div class="field-orderform-customeremail required">
										<input type="text" id="orderform-customeremail" class="form-control" name="customerEmail" placeholder="Địa chỉ email" aria-required="true" >
										<div id="order-form_customerEmail_errorloc" class="alert-danger" ></div>
									</div>               
								</div>
							</div>

							<div class="form-group">
								<label class="control-label col-md-4">Địa chỉ nhận hàng</label>
								<div class="col-md-8">
									<div class="field-orderform-customeraddress">
										<textarea id="orderform-customeraddress" class="form-control" name="customerAddress" placeholder="Địa chỉ nhận hàng"></textarea>
										<div class="help-block"></div>
									</div>                
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-md-4">Ghi chú</label>
								<div class="col-md-8">
									<div class="field-orderform-note">
										<textarea id="orderform-note" class="form-control" name="note" placeholder="Ghi chú"></textarea>
										<div class="help-block"></div>
									</div>                   
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-md-4">Nhập mã xác thực</label>
								<div class="col-md-8">
									<div class="field-orderform-verifycode">
										<div class="row">


											<div class="captcha-image image col-lg-4"></div> <!-- < echo $image_ch['image']; -->
								 			<div class="captcha-input col-lg-6">
											  <input class="form-control" placeholder="Nhập mã bên trái" name="captcha" id="captcha" type="text">          
										 	</div>
										 	<input type="hidden" id="cap" value="<?php echo $this->session->captcha['cap'] ?>"></input>
										 	<div class="col-lg-1"><a class="refresh glyphicon glyphicon-refresh" href="javascript:void(0)" title="Lấy mã mới"><i class="icon-refresh"></i></a></div>
										</div>
										<div id="help-captcha" class="alert-danger"></div>
									</div>       
								</div>
							</div>


						</div>
					</div>
				</div>
				<div class="col-md-4 text-center">
					<p>
						<button id="sm-btn" type="submit" class="btn btn-success btn-lg btn-block"><i class="glyphicon glyphicon-shopping-cart"></i> Đặt hàng &gt;&gt;</button>
					</p>
					<i>(Xin vui lòng kiểm tra lại đơn hàng trước khi Đặt Hàng)</i>

					
        <!--<p>
            <button type="button" class="btn btn-default btn-lg">Huỷ đặt hàng</button>
        </p>-->
    </div>
</div>
</form>
</div>
<script src="<?php echo base_url(); ?>js/gen_validatorv4.js"></script>
<script type="text/javascript">
// Load captcha image.   
// $( ".captcha-image" ).load("<?php echo base_url('Home/created'); ?>");    
// Ajax post for refresh captcha image.
    $("a.refresh").click(function() {
        jQuery.ajax({
            type: "GET",
            dataType:"json",
            url: "<?php echo base_url('Home/created'); ?>",
            success: function(res) {
            if (res)
                {
                    jQuery("div.image").html(res.image);
                    $("#cap").val(res.word);
                }
            }
        });
    });
    $("a.refresh").trigger('click');
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
                    break;
                default:
                    alert('Tập tin này không được hỗ trợ! Bạn chỉ được chọn file ảnh.');
                    $("#f").val(null);
                    $("#img0").hide();
            }
    }   
	var frmvalidator = new Validator("order-form");
	frmvalidator.EnableOnPageErrorDisplay();
    frmvalidator.EnableMsgsTogether();

	frmvalidator.addValidation("orderform-customername","req","Xin vui lòng nhập họ tên !!!");
	frmvalidator.addValidation("orderform-customername","maxlen=20",
	"Họ và tên không được quá 20 ký tự !!!");

	frmvalidator.addValidation("orderform-customeremail","req","Xin vui lòng nhập Email!!");
	frmvalidator.addValidation("orderform-customeremail","email","Email không đúng định dạng!!");
	
	frmvalidator.addValidation("orderform-customerphone","req","Xin vui lòng nhập số điện thoại !!!");
	frmvalidator.addValidation("orderform-customerphone","maxlen=11","Tối đa 11 chữ số!!!");
	frmvalidator.addValidation("orderform-customerphone","numeric","Điện thoại phải là kiểu số!!!");
	
	frmvalidator.setAddnlValidationFunction(DoCustomValidation);   
	function DoCustomValidation()
	{
	    var str1 = $("#cap").val();
		var str2 = $("#captcha").val();
		if(!str2){
			$("#help-captcha").hide();
			$("#help-captcha").html("Xin vui lòng nhập Captcha!!!").show();
		}else if(str1.localeCompare(str2)==0){
			$("#help-captcha").hide();
			return true;
		}else{
			$("#help-captcha").hide();
			$("a.refresh").trigger('click');
			$("#help-captcha").html("Captcha sai!! Vui lòng nhập lại!!").show();
			return false;
		}
	}
	    
</script>   