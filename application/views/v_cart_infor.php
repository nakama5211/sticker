<div class="container">     
		<div>&nbsp</div>  
        <h2>Đơn hàng A09181464</h2>
        <div>&nbsp</div>  
			<div class="row">
			    <div class="col-md-12">
			        <div class="panel panel-default">
			            <div class="panel-heading">Thông tin khách hàng</div>
			            <table class="table">
			                <tbody><tr>
			                    <th>Khách hàng</th>
			                    <td><?php echo $bill[0]['customer']; ?></td>
			                </tr>
			                <tr>
			                    <th>Điện thoại</th>
			                    <td><?php echo $bill[0]['phone']; ?></td>
			                </tr>
			                <tr>
			                    <th>Email</th>
			                    <td><?php echo $bill[0]['email']; ?></td>
			                </tr>
			                <tr>
			                    <th>Địa chỉ</th>
			                    <td><?php echo $bill[0]['address']; ?></td>
			                </tr>
			                <tr>
			                    <th>Ghi chú</th>
			                    <td><?php echo $bill[0]['note']; ?></td>
			                </tr>
			            </tbody></table>
			        </div>
			    </div>
			    <div class="col-md-12">
			        <div class="panel panel-default">
			            <div class="panel-heading">Thông tin đơn hàng</div>
			            <table class="table">
			                <tbody><tr>
			                    <th>Sản phẩm</th>
			                    <td><?php echo $bill[0]['typedecal_name']."; ".$bill[0]['extrusion_name']; ?></td>
			                </tr>
			                <tr>
			                    <th>Kích thước</th>
			                    <td><?php echo $bill[0]['width']."x".$bill[0]['height']." mm"; ?></td>
			                </tr>
			                <tr>
			                    <th>Số lượng</th>
			                    <td><?php echo $qty=$bill[0]['quantity']; ?></td>
			                </tr>
			                <tr>
			                    <th>Đơn giá</th>
			                    <td><?php echo number_format($price=$bill[0]['typedecal_price']+$bill[0]['extrusion_price']); ?>₫</td>
			                </tr>
			                <tr>
			                    <th class="">Thành tiền</th>
			                    <td class="text-success"><?php echo number_format($price*$qty)?>₫</td>
			                </tr>
			            </tbody></table>
			        </div>
			    </div>
			</div>
		<div>&nbsp</div>  
    </div>